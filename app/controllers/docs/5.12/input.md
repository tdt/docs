# Input

In this section you will learn

* [The functionality of input](#introduction)

<a id='functionality' class='anchor'></a>
## Introduction

In previous versions (< 5.12) the datatank provides the functionality to provide a 1-1 translation and publication of data to a web URI. With previous versions there was an option to install a package called [tdt/input](https://github.com/tdt/input) which would allow for an ETL process with semantification options. There is a need however to publish and use larger datasets in a consumer friendly way. That's why we transformed the input package to an ETL that extracts data from a set of possible datasource and loads into a NoSQL store such as MongoDB or Elasticsearch.

The ETL jobs can be triggered periodically but will require to install [Beanstalk](http://kr.github.io/beanstalkd/download.html). Beanstalk is a simple to install queueing system that can be interfaced with through PHP. Upon making an ETL job you can select multiple choices for the schedule property. The default one is "once", this will cause the job to be added to the queue once and be executed when the job queue is triggered to work. After that, the data will never be refreshed in the selected loading system, unless done so manually through the CLI.

Semantifying raw data has been thrown out and is replaced by a separate project which is an implementation of the [RML specification](http://semweb.mmlab.be/rml/spec.html) which is still an unofficial draft.


## Developing input

If you are developing on the input package, you'll need to know the [Laravel package development basics](http://four.laravel.com/docs/packages).
This means that you don't need to include it in your composer.json file but rather do a Git checkout into your Laravel workbench. In a practical manner this comes down to the following set of commands:

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

Make sure you perform a composer update after you adjusted the main composer file of the core project. This way the input package will only exist in the workbench and not in the vendor map.