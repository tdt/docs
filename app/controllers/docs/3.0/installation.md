# Installation

On this page you will learn how to:

* [system requirements](#sysreq)
* [install composer](#composer)

## System Requirements

The DataTank 3.0 requires a server with:

 * Apache 2 (or equivalent)
 * mod rewrite enabled
 * PHP 5.3 or higher
 * MySQL database

Optional software components are:

* memcached
* php-memcache

if you’re using a Unix system, the easiest way to meet these requirements is to perform the next commands:

    $ apt-get install apache2 php5 mysql-server php5-dev php5-memcache memcached
    $ a2enmod rewrite

If you’re using a Windows system, you’ll have to download a stack that holds the necessary requirements, stated above. Popular stacks are XAMPP and Wampserver. Make sure you download a build that includes the correct versions of the required software, described above.

## Installation & Configuration

The installation process covers these next 3 steps.

Download and unzip the tdt/start package from [our repository](https://github.com/tdt/start). You’re safe with the most recent tag. You can skip this step, if you’d like composer to download the software and install it.
Create a new MySQL database and user. Be sure to provide this user with write permissions on the database you created. This database will be used by The DataTank to store its meta-data.
Follow the documentation on how to auto-install The DataTank through composer. The link to the documentation also contains the configuration documentation.

Note that we're no longer developping on tdt/start and its packages as we migrated to the Laravel framework as of december 2013.