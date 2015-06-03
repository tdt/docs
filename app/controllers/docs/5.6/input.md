# Input

In this section you will learn

* [The functionality of input](#introduction)
* [How to install the input package](#install)

<a id='functionality' class='anchor'></a>
## Introduction

The default out-of-the-box datatank provides the functionality to provide a 1-1 translation and publication of data to a web URI. However, in order to move up the [open data ladder](http://5stardata.info/) we need to be able to add context to data. This can be done by adding semantics to the data and storing them in data structures that support semantics.

The functional analysis of this semantifying operation identifies 3 steps, namely the extraction of data, the mapping of data and the storage of the mapped data. In the datatank we've named this an extract-map-load sequence or eml.

Because we're embedding this functionality as a package in our core application we can also publish our freshly new made semantic data (or whatever new data you produced using the input package) to the web. This can be done by configuring an optional 4th processing factor in the eml process. This last process is called the publish process and takes a set of variables needed to publish the result of the load process.

<a id='install' class='anchor'></a>
## Installing tdt/input

The installation is fairly simple and can be done by telling the core application that tdt/input is now a required package. This can be done by editing the require section of the composer.json file, located in your root application folder.

Note that the commands listed are assumed to be executed from the root folder of the datatank application.

<pre class="prettyprint linenums">
"require": {
    ...,
    "tdt/input" : "dev-master"
}
</pre>

After the composer.json changed, you need to let composer know that a new dependency has been added. The following command will download the input package:

    $ composer update

The next thing you need to do is to create the datatables necessary for input to store its information. This can be done by executing the following command:

    $ php artisan migrate --package=tdt/input

Now that everything is set and done, you'll have to let the core application know that it has a package it needs to approach. Unfortunately this has to be done manually in Laravel 4, by adding the [service provider](http://four.laravel.com/docs/packages#service-providers) to the providers array entry in the <em>app.php</em> file located in the <em>app/config</em> folder.

A snippet is of this file is

<pre class="prettyprint linenums">
    'providers' => array(

        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        'Illuminate\Cache\CacheServiceProvider',
        'Illuminate\Foundation\Providers\CommandCreatorServiceProvider',
        ...
        'Tdt\Input\InputServiceProvider',
    )
</pre>

## Developing input

If you are developing on the input package, you'll need to know the [Laravel package development basics](http://four.laravel.com/docs/packages).
This means that you don't need to include it in your composer.json file but rather include in your Laravel workbench. In a practical manner this comes down to the following set of commands:

    $ mkdir workbench
    $ cd workbench
    $ git clone git@github.com:tdt/input.git

After that install the necessary dependencies for the input package by going to the workbench input package and running the composer install command:

    $ cd workbench/input
    $ composer install

Now that the dependencies have been installed, we have to inform the autoloader that new classes have been added, this is done using artisan located in the root directory:

    $ cd ../.. (go to the root again)
    $ php artisan dump-autoload

In order to migrate the workbench package execute the following command:

    $ php artisan migrate --bench=input

Creating a migration goes down the same way:

    $ php artisan migrate:make --bench=input

