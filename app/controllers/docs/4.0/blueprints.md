# Blue prints

In this section you will learn

* [The big picture and its components](#project_setup)
* [What development cycles we have](#devcycle)

<a id="project_setup"></a>
## The big picture

Our project's aim is providing an open source tool that can publish data in a RESTful way, provide visualizations that make you interpret the data and provide an additional package that can semantify your data. At this moment you're looking at the contents of the [tdt/docs](https://github.com/tdt/docs) repository, this repository holds the documentation for all of the tdt repositories starting from version 4.0. And contains documentation about our previous version 3.0. Our [repository](https://github.com/tdt) holds several packages at this moment, the ones relevant to version 4.0 are

* [core](https://github.com/tdt/core)
* [input](https://github.com/tdt/input)
* [docs](https://github.com/tdt/docs)
* [streamingrdfmapper](https://github.com/tdt/streamingrdfmapper)

The rest of the packages hosted in the tdt repository will become obsolete - from version 4.0 on - as most of them are either included in core, or are no longer relevant due to the migration to the [Laravel framework](http://laravel.com/) framework which marks the 4.0+ version.

The core package contains the main component of The DataTank project and provides the basic functionality of publishing data in a RESTful way and making the data requestable in any raw webformat as well as visualizing the data (e.g. a map based on geographical properties in a CSV file).

The input package is a package that can be plugged into our core application and provides the functionality to create a custom extract-map-load functionality. Currently this eml functionality is used to create semantified data from raw data using a mapping file, but can be configured and expanded to, for example, load data from several data structures into a NoSQL.

The docs package contains all of the documentation relevant to our repository for packages from version 4.0 or higher. This documentation package is also created in the Laravel framework and consists of a list of markdown files. This makes it so that even a non-technical person can change our documentation where he sees fit.

The streamingrdfmapper package contains code that provides mapping functionalities used in the input package. It can take a certain mapping file that specifies which data must be mapped onto a certain semantic concept. This creates triples that can be used for further processing.

<a id="devcycle"></a>
## Development cycles

We currently work with bi-annual development cycles that provides releases on the 5th of december and june.

Our versions are created following the [semantic versioning 2.0.0](http://semver.org/) specification. Our code base has a set of core developers, but as it is an open source project anyone can contribute in the form of pull-requests. Feature request, bugs, issues, questions and so on can be added to the corresponding repo using the github issue tracker.
