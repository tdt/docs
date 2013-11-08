# Input

In this section you will learn

* [the functionality of input](#functionality)
* [how to add it to your datatank instance](#include)

## Functionality

The default out-of-the-box datatank provides the functionality to provide a 1-1 translation and publication of data to a web URI. However, in order to move up the [open data ladder](http://5stardata.info/) we need to be able to add context to data. This can be done by adding semantics to the data and storing them in data structures that support storing semantic data.

The functional analysis of this semantifying operation identifies 3 steps, namely the extraction of data, the mapping of data and the storage of the mapped data. In the datatank we've named this an extract-map-load sequence or eml. If you're a developer, you'll find a similar approach in our code.

Because we're embedding this functionality as a package in our core application we can also publish our freshly new made semantic data (or whatever new data you produced using the input package). This can be done by configuring an optional 4th processing factor in the eml process. This last process is called the publish process and takes a set of variables needed to publish the result of the load process.

Each of the above described functionalities will further documented in the next secttions of input.
