# Installation

On this page you will learn

* [What the system requirements are](#requirements)
* [How to install a datatank](#installation)

<a id='requirements' class='anchor'></a>
## System Requirements

The DataTank requires a server with

* Apache2 or Nginx
* mod rewrite enabled
* PHP 5.4 or higher
* Git
* Any database supported by [Laravel 4](http://four.laravel.com/docs/database)

If you're using a <strong>Unix</strong> system that supports the <strong>apt-get</strong> package manager, the easiest way to meet these requirements is to perform the following commands:

    $ apt-get install apache2 php5 mysql-server php5-dev php5-memcache memcached php5-curl
    $ a2enmod rewrite

If you're using a <strong>Linux</strong> distribution derived from the Red Hat family, or which uses the <strong>yum</strong> package manager, you may need to follow the [CentOS 6](installation_centos6.md) installation instructions.

If you're using a <strong>Windows</strong> system, you'll have to download a web stack that holds the necessary requirements, such as [WAMPServer](http://www.wampserver.com/en/), plus [msysgit](http://msysgit.github.io/).

Set the rewrite rules in <code>/etc/apache2/sites-available/default</code> to <code>ALL</code>:

    <Directory />
        Options FollowSymLinks
        AllowOverride All
    </Directory>
    <Directory /var/www/>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Order allow,deny
        allow from all
    </Directory>


<a id='installation' class='anchor'></a>
## Installation

### Preparations

An installation through the command line requires the installation of [composer](http://getcomposer.org/). Make sure you have it downloaded properly and ready to use. Next to that you'll need to prepare a database with a user that has read & write permissions for The DataTank to use.

#### Install the application

To install, open up a terminal and clone our repository

    git clone https://github.com/tdt/core.git

#### Configure the database

Provide your database credentials in the `app/config/database.php` file, according to the [Laravel database configuration](http://laravel.com/docs/configuration).

After that you're ready to make composer work his magic! Run the following command from the root of the folder where you cloned the repository:

    composer install
    
#### Add permissions to the log directory

To store logs and other files, the right permissions need to be set:

    $ chmod -R  777 /var/www/tdt/app/storage/

#### Get started with our demo data

In order to get you started, we've provided a seeder that publishes a set of data files. This can be done with the following command:

    php artisan db:seed --class=DemoDataSeeder

This will publish some data sets to some self-explanatory uri's. For example CSV files will be published under the collection uri 'csv', JSON files under 'json', and so on and so forth.

#### Get started with our user interface

We've created a user interface to manage datasets and users on the uri api/admin, relative to the root uri. The default credentials are:

    user: admin
    password: admin

Best practice is to change the admin password immediatly by editing it using the user interface. Click the question mark <i class='fa fa-lg fa-question-circle'></i> in the user interface to start the help guide.
