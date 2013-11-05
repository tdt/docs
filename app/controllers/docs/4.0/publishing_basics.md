# Publishing data

On this page you will learn

* [how to publish a dataset](#publish)

<a name="publish"></a>
## Adding a resource

Our core functionality is to translate data from a certain data structure and provide this content to the user. As described in our introduction pages, we need some meta-data in order to make this happen.
The following list shows how the addition of a resource goes down assuming that a datatank exists on the uri http://foo.

1. Set up the resource definition template

    In order to know which meta-data properties you have to pass to create a valid resource definition you'll have to take a look at the discovery document, located at http://foo/discovery.
    The discovery document was inspired by the [Goole API reference](https://developers.google.com/discovery/v1/reference/apis)
    This document shows a list of methods that one can perform on the resources of a datatank instance. One of those resources is called `definitions` and is used to create, read, update and delete resource definitions.

    If we take a look at the definitions resource we notice that it has a property called `methods`. This identifies all the methods the definitions resource can handle. Note that these methods do not always have a 1-1 translation to HTTP methods, which this document happens to have. Going by description of the  `put` method we know that we have to use this method, identified by a HTTP PUT method, to create a new resource definition. It also provides us a `path` property which tells us to which path we have to use to perform our HTTP request to. The path also contains an {identifier} piece which servers as an identifier for the resource definition you want to add. It consists of a collection part and a naming part. For example you might want to publish data about forest coverage in a certain area over the span of several years. This might intuitively lead to a collection of tree definitions of which each is identified by a resource name. This makes the following URI structure (including the definitions path).

    * http://foo/definitions/trees/2009
    * http://foo/definitions/trees/2010
    * http://foo/definitions/trees/2011

    > Note that you can only create one definition per method call.

    So far we know which method to use, and to which URI we must perform the request. Now the next step is to figure out which meta-data we have pass along with the request.
    For the sake of this example we'll assume that the data we want to publish is a CSV file. The supported data structures are now listed in the `mediaType` property of the method. CSV is one of them, so we know we can publish our data using the datatank. This also identifies what value we have to pass with the Content-Type header, identified by the `contentType` property, this consists of a small template that takes the name of the data structure, in our case csv.

    Quite the dump of information if you're new to the datatank, so let's recap of what we have at this point.
    We need to create a definition and check how our HTTP request must be built up and which meta-data we have to pass.


2. Fill in the template

3.

## Requesting data


