# Blue prints

In this section you will learn

* [the big picture and its components](#project_setup)
* [what development cycles we have](#devcycle)

<a name="project_setup"></a>
## The big picture

Our project's aim is providing an open source tool that can publish data in a RESTful way and provide an additional package that can semantify your data. At this moment you're looking at the contents of the tdt/docs repository, this repository holds the documentation for all of the tdt repositories starting from version 4.0. Our [repository](https://github.com/tdt) holds several packages at this moment, the ones relevant to version 4.0 are

* [core](https://github.com/tdt/core)
* [input](https://github.com/tdt/input)
* [docs](https://github.com/tdt/docs)
* [streamingrdfmapper](https://github.com/tdt/streamingrdfmapper)

The rest of the packages hosted in the tdt repository will soon become obsolete as most of them are either included in core, or are no longer relevant due to the migration to the [Laravel framework](http://laravel.com/) framework which marks the 4.0+ version.

The core package contains the main component of The DataTank project and provides the basic functionality of publishing data in a RESTful way and making the data requestable in any raw webformat as well as visualizing the data in a set of visualizations (e.g. a map based on geographical properties in a CSV file).

The input package is a Laravel package that can be plugged into our core application and provides the functionality to create custom extract-map-load functionality. Currently this eml functionality is used to create semantified data from raw data using a mapping file.

The docs package contains all of the documentation relevant to our repository for packages from version 4.0 or higher. This documentation package is also created in a Laravel framework and consists of a list of markdown files. This makes it so that even a child can change our documentation.

The streamingrdfmapper package contains code that providers mapping functionalities used in the input package. It can take a certain mapping file that specifies which data must be mapped onto a certain semantic concept, creating triples that can then be handled by our input package.

Our versions are created of a major release number and a minor number which represents certain patches to be applied. If these numbers aren't sufficient sub-minor numbers will be used. Our code base has a set of core developers, but as it is an open source project anyone can contribute in the form of pull-requests. Feature request, bugs, issues, questions and so on can be added to the corresponding repo using the github issue tracker.

Our project also has a [website](http://thedatatank.com) which contains some non-technical information in addition to these more instructional and technical information.

<a name="devcycle"></a>
## Development cycles

We currently work with bi-annual development cycles that provides releases on the 5th of december and june.