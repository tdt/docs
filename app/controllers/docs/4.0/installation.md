# Installation

On this page you will learn

* [what the system requirements are](#requirements)
* [how to install a datatank](#installation)

<a name="requirements"></a>
## System Requirements

The DataTank requires a server with

* Apache2 or Nginx
* mod rewrite enabled
* PHP 5.3+, preferably 5.4
* Any database supported by [Laravel 4](http://four.laravel.com/docs/database)

If you're using a <strong>Unix</strong> system, the easiest way to meet these requirements is to perform the following commands:

    $ apt-get install apache2 php5 mysql-server php5-dev php5-memcache memcached
    $ a2enmod rewrite

If you're using a <strong>Windows</strong> system, you'll have to download a web stack that holds the necessary requirements.

<a name="installation"></a>
## Installation

### Command line

An installation through the command line requires the installation of [composer](http://getcomposer.org/).

#### Install core

To install the latest version of core execute the following commands

    $ composer create-project tdt/core
    $ composer update

#### Install docs

To install the latest version of our documentation execute the following commands

    $ composer create-project tdt/docs
    $ composer update