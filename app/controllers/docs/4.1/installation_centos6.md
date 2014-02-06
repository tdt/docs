Installation of The DataTank on CentOS 6.5
========================================

Background
----------
When installing The DataTank, users of CentOS 6 will need to make a choice about what version of PHP they will be using to support the installation. As CentOS 6.5 is based on Red Hat Enterprise Linux - with its preference for older packages that have a proven track record of stability - the default installation of PHP is version 5.3.3.

However, the Laravel 4.0 framework, which forms the foundation upon which TheDataTank is constructed, requires PHP 5.3.7 as the minimum version, and newer versions of Laravel bump that requirement up to PHP 5.4.0. Additionally, there are a number of [PHPUnit tests](https://github.com/tdt/core/issues/170) that come with The DataTank which use syntax that requires by PHP 5.4 and above.

Thus, there are two choices when it comes to running The DataTank on CentOS 6 -- either upgrade PHP to version 5.4.x, or make the modifications, detailed below, needed to install The DataTank using the default PHP 5.3.3 installation.

When feasible, upgrading PHP to 5.4.x is perhaps the better option, because it enables forward-compatibility and will support the full complement of PHPUnit tests.  [Daniel Heramb](http://danielheramb.blogspot.com/2013/03/how-to-install-laravel-on-linux.html) has written some good instructions on installing PHP 5.4 as part of a Laravel installation. 

But there may be compelling reasons for remaining on PHP 5.3.3. There may be an organizational preference for utilizing default packages, or it may be necessary to maintain 5.3.x compatibility for other PHP applications running on the server. Drupal 7, for example, will run on PHP 5.4, but "prefers" 5.3, and may generate a rather large number of warnings when running PHP 5.4. 

For cases where remaining on PHP 5.3.3 is considered the best option, the following installation instructions may be used. They have been successfully tested on a virtual machine running a fresh installation of CentOS 6.5. Additionally, many of the steps below will also be of use to those installing The DataTank on top of PHP 5.4.x on a Red Hat-family Linux distribution, as they reflect a yum-based installation, Red Hat-flavored directory structures, and instructions on a required SELinux security configuration.

# Installation of basic packages

As the root user, use Yum to install git, curl, the MySQL client and Apache webserver:

	yum install git
	yum install curl
	yum install wget
	yum install mysql
	yum install httpd
	
Install and start memcached:

	yum install memcached
	/etc/init.d/memcached start

Next comes the PHP installation. To install PHP 5.4, follow the directions at [Daniel Heramb's website](http://danielheramb.blogspot.com/2013/03/how-to-install-laravel-on-linux.html). To install 5.3.3, follow the instructions below.


Install PHP core and various PHP libraries:

	yum install php
	yum install php-pecl-memcache
	yum install php-devel
	yum install php-mysql
	yum install php-pecl-apc
	yum install php-xml

The following package was recommended for optimization, but is not available in the default repositories. It is listed here for completeness only; you do not need to install it - and, indeed, may not be able to.  
	
	yum install php-pecl-zendopcache

There are some additional PHP packages which must be installed from the Extra Packages for Enterprise Linux (or EPEL) RPM repository, which is a repository of Red Hat compatible binaries supported by the Fedora community. Use the following commands to install the EPEL repository

	wget http://dl.iuscommunity.org/pub/ius/stable/CentOS/6/x86_64/epel-release-6-5.noarch.rpm
	rpm -ivh epel-release-6-5.noarch.rpm

With the EPEL repository installed, you will now be able to install these two PHP packages:

	yum install php-mcrypt
	yum install php-mbstring

# Install Composer and download tdt/core
Use the following commands to install Composer and put it in the path:

	curl -sS https://getcomposer.org/installer | php
	mv composer.phar /usr/local/bin/composer

Create an installation directory and bring in the tdt code using git:

	mkdir /opt/tdt
	cd /opt/tdt
    git clone https://github.com/tdt/core.git

# Database setup and configuration
If MySQL is to be hosted locally, install and start the MySQL server:

	yum install mysql-server 
	/etc/init.d/mysqld start

Configuring security on MySQL is outside the scope of this document. However, the following lines of SQL used to create a database and user are included for your convenience. Log into your MySQL prompt, and type the following:

	create database tdt;
	create user 'tdt_user'@'localhost' identified by 'PASSWORD123';
	grant all on tdt.* to 'tdt_user'@'localhost';

Be sure to use a better password than the one provided above. Add these settings to the Set these credentials in Laravel database configuration file in /opt/tdt/core/app/config/database.php. It should look like this:


    'mysql' => array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'tdt',
            'username'  => 'tdt_user',
            'password'  => 'PASSWORD123',
            'charset'   => 'utf8',-
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
    )

# Hack composer.json and run the build

For installing on PHP 5.3.3, this is where things get tricky. Those who are installing on 5.4.x can skip the edits to composer.json listed below, and move on to running composer, at the end of this section.

The reason Laravel requires PHP 5.3.7 at a minimum is that it requires bcrypt-based hashing, which is not available in 5.3.3. Howerver, [Rob Clancy](https://github.com/robclancy/laravel4-hashing) has provided a patch which overrides the bcrypt hashing code with a hash using the sha5 algorythm. Enable this patch by adding the following to the top of the "require" section of tdt's core/composer.json file:

* "robclancy/laravel4-hashing": "dev-master",

You will also need to trick the Composer build process into using Laravel 4.0.10 instead of 4.1.x. This is because the 4.1 series of Laravel requires PHP 5.4, and will not run with 5.3. Thus, in the same core/composer.json file as above, edit the line that referes to "laravel/framework", as follows:

* "laravel/framework": "4.0.10 as 4.1.10",

Now, run composer - this could take 20 minutes or so, depending on your setup.
	
	cd core
	composer install

# Set up the webserver, configure permissions and the firewall

Create a shortcut under Apache's content directory to the publicly exposed portion of your installation:

	ln -s /opt/tdt/core/public /var/www/html/tdt
    
Edit the Apache configuration file,  located at /etc/httpd/conf/httpd.conf:

* Under the configuration for &lt;Directory "/var/www/html">, change <i>AllowOverride None</i> to <i>AllowOverride All</i>
    
This directory needs to be made fully accessible to the application:
    
	chmod -R 777 /opt/tdt/core/app/storage/

Even with 777 permissions, SELinux will prevent the app from accessing that directory unless you explicitly provide that permission. Use the following command:
    
	chcon -Rv --type=httpd_sys_content_rw_t /opt/tdt/core/app/storage

Alternately, if you are on a non-production machine and you just want to turn SELinux off, do this:
    
	echo 0 > /selinux/enforce

Start the webserver

	apachectl start

Finally, if you want to access this site from a browser on a different machine, you will need to open up port 80 in the iptables firewall. Add the following line to your /etc/sysconfig/iptables file:

* -A INPUT -m state --state NEW -m tcp -p tcp --dport 80 -j ACCEPT

Then, restart the iptables firewall:
    
	/etc/init.d/iptables restart

The DataTank should now be installed and running at http://[Your.IP.Address]/tdt/. The admin console is located at http://[Your.IP.Address]/tdt/api/admin. The default username and password are both "admin."
