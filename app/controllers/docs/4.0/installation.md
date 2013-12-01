# Installation

On this page you will learn

* [What the system requirements are](#requirements)
* [How to install a datatank](#installation)

<a id="requirements"></a>
## System Requirements

The DataTank requires a server with

* Apache2 or Nginx
* mod rewrite enabled
* PHP 5.4 or higher
* Any database supported by [Laravel 4](http://four.laravel.com/docs/database)
q²
If you're using a <strong>Unix</strong> system, the easiest way to meet these requirements is to perform the following commands:

    $ apt-get install apache2 php5 mysql-server php5-dev php5-memcache memcached
    $ a2enmod rewrite

If you're using a <strong>Windows</strong> system, you'll have to download a web stack that holds the necessary requirements.

<a id="installation"></a>
## Installation

### Command line

An installation through the command line requires the installation of [composer](http://getcomposer.org/).

#### Install core

To install the latest version of core execute the following commands

    $ composer create-project tdt/core
    $ composer update

If, for some reason, you haven't installed The DataTank through the create-project command, there's a chance that some commands haven't been executed that are necessary.
One of them might be the deployment of basic users, in order to do this manually execute the following after (!) you have performed the composer update command.

    $ php artisan db:seed --class=UserSeeder

#### Get started with our demo data

In order to get you started, we've provided a seeder that publishes a set of data files. This can be done with the following command:

    $ php artisan db:seed

This will publish some data sets (mostly the same ones used for our unittesting) to some self-explanatory uri's. For example CSV files will be published under the collection uri 'csv', SHP files under 'shp', and so on and so forth.
Note that any personal related data is generated at random, and any resemblances to real data is purely coincidental.

#### Install docs

As a last pointer, we suggest you install our documentation pages locally so that they can be addressed at all times. To install the latest version of our documentation execute the following commands

    $ composer create-project tdt/docs
    $ composer update
