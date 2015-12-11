# Blue prints

In this section you will learn

* [The big picture of the project](#project_setup)
* [Our development cycles](#devcycle)

<a id='project_setup' class='anchor'></a>
## The big picture

Our project's aim is to provide a tool that enables open data consumption in an easy, open and transparant way. This is achieved by providing an open source tool that can

* publish data in a RESTful way so that data consumers (e.g. app developers) don't have to download raw data files anymore but can get started right away
* provide visualizations that makes it easy for civilians to interpret the data and gain information from it

Our repositories are divided by functionality on github, for example the documentation you're reading right now is managed on the [tdt/docs](https://github.com/tdt/docs) repository, this repository holds the documentation for all of The DataTank (tdt) repositories starting from version 4, and contains documentation about our previous versions. Our main [repository](https://github.com/tdt) holds several packages at this moment, the ones relevant to version 4+ are

* [core](https://github.com/tdt/core)
* [input](https://github.com/tdt/input)
* [docs](https://github.com/tdt/docs)

As of version 5.12 the input package is a part of the core package by default and provides an ETL for larger datasets.

The rest of the packages hosted in the tdt repository will become obsolete - from version 4 on - as most of them are either included in core, or are no longer relevant due to the migration to the [Laravel framework](http://laravel.com/) framework.

The core package contains the main component of The DataTank project and provides the basic functionality of publishing data in a RESTful way and making the data requestable in any raw webformat as well as visualizing the data (e.g. creating a map based on geographical properties in a CSV file).

The docs package contains all of the documentation relevant to our repository for packages from version 4 or higher. This documentation project is also created in the Laravel framework and consists of a list of markdown files. This makes it easy for non-technical people to change our documentation where they see fit.

<a id='devcycle' class='anchor'></a>
## Development cycles

We currently work with bi-annual development cycles that provides releases on the 5th of december and the 5th of june.

Our versions are created following the [semantic versioning 2.0.0](http://semver.org/) specification. Our code base has a set of core developers, but as it is an open source project anyone can contribute in the form of pull-requests. Feature request, bugs, issues, questions and so on can be added to the corresponding repo using the github issue tracker.
