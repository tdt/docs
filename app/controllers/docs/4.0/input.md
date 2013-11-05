# Input

In this section you will learn

* [the functionality of input](#functionality)
* [how to add it to your datatank instance](#include)

## Functionality

The default out-of-the-box datatank provides the functionality to provide a 1-1 translation and publication of data to a web URI. However, in order to move up the [open data ladder](http://5stardata.info/) we need to be able to add context to data. This can be done by adding semantics to the data and storing them in data structures that support storing semantic data.

The functional analysis of this semantifying operation identifies 3 steps, namely the extraction of data, the mapping of data and the storage of the mapped data. In the datatank we've named this an extract-map-load sequence or eml. If you're a developer, you'll find a similar approach in our code.

## Installation

Installation is fairly simple and can be done by adding the tdt/input package to the `require` section of the composer.json file. This file can be found in the root of your installation.
The `require` section might look like this:

    "require": {
        ...,
        "tdt/input" : "dev-master"
    }

After the composer.json changed, you need to let composer know that a new dependency has been added. The following command will download the input package:

    $ composer update