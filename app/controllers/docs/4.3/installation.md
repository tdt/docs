# Installation

On this page you will learn

* [What the system requirements are](#requirements)
* [How to install a datatank](#installation)
* [Installation on Pagoda box](#pagoda)

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

If you're using a <strong>Linux</strong> distribution derived from the Red Hat family, or which uses the <strong>yum</strong> package manager, you may need to follow the [CentOS 6](installation_centos6) installation instructions.

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


>> CAVEAT: When using Shared hosting, you might run into the issue that authentication headers are not set!! Do the following if you experience issues.

When using Shared Hosting, some PHP Authentication headers might not be in use, this is essential though, as we use them in our application. Therefore, to resolve this, add the following to your .htaccess

    RewriteEngine on
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]


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


<a id='pagoda' class='anchor'></a>
### Installation on pagoda box

Alot of platforms offer PHP as a service, where you can install and manage PHP applications. Pagoda box is one of them and Pieter Colpaert (@pieterc) has made a [one-click install](https://pagodabox.com/cafe/pietercolpaert/thedatatank) to get your hands dirty with the datatank without any hassle!

After the install, by clicking the "Launch" button you can click through to the live application, where you'll find the datatank user homepage telling you that it is hungry for data!

The first thing you'll want to do is changing the admin password, log in the admin panel by going to api/admin (e.g. http://pagodabox.com/api/admin) and change the admin user password, which is "admin" by default.

After that you can start adding data! In your admin panel go to "Datasets" and add your dataset to the datatank. Let's add a CSV file and let the datatank handle the data transformation. An example CSV could be [this](https://raw.githubusercontent.com/datasets/gold-prices/master/data/data.csv). Go the the tab in the dataset panel that says "CSV", click it, and you'll get an overview of the parameters you can add as meta-data. Some meta-data is requird to fill in, like the URI you want to publish your data under, the URI towards the CSV file and a description of the dataset.

The URI, can just be the URI of the gold prices csv, for explanatory reasons, the URI can be "gold/prices" and the description can be whatever you feel like typing.

Click "Add" when you're ready. After that you get redirected to an overview of your added datasets, for a look of how the data is translated, click the "Data" button on the right hand side of the dataset. Notice that in the view you'll see, you can click towards a JSON (or other) represenatation of the dataset.

This should get you started with the basics of how to manage a datatank. For more information, browse through our documentation pages, or click the information icon in the UI of the datatank on the right hand bottom side.