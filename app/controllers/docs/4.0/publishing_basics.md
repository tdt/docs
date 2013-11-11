# Publishing data

On this page you will learn

* [how to publish a dataset](#publish)

<pre class="prettyprint language-json">
resources: {
    definitions: {
        methods: {
            put: {
                httpMethod: "PUT",
                path: "/definitions/{identifier}",
                description: "Add a resource definition identified by the {identifier} value, and of the type identified by the content type header value {mediaType}. The {identifier} consists of 1 or more collection identifiers, followed by a final resource name. (e.g. world/demography/2013/seniors)",
                contentType: "application/tdt.{mediaType}",
                mediaType: {
                    csv: {
                        description: "Create a definition that allows for publication of data inside a CSV datastructure.",
                        parameters: {
                            title: {
                                required: false,
                                description: "A name given to the resource."
                            },
                            subject: {
                                required: false,
                                description: "The topic of the resource."
                            },
                            description: {
                                required: true,
                                description: "The descriptive or informational string that provides some context for you published dataset."
                            },
                            publisher: {
                                required: false,
                                description: "An entity responsible for making the resource available."
                            },
                            contributor: {
                                required: false,
                                description: "An entity responsible for making contributions to the resource."
                            },
                            date: {
                                required: false,
                                description: "A point or period of time associated with an event in the lifecycle of the resource."
                            },
                            type: {
                                required: false,
                                description: "The nature or genre of the resource."
                            },
                            format: {
                                required: false,
                                description: "The file format, physical medium, or dimensions of the resource."
                            },
                            identifier: {
                                required: false,
                                description: "An unambiguous reference to the resource within a given context."
                            },
                            source: {
                                required: false,
                                description: "A related resource from which the described resource is derived."
                            },
                            language: {
                                required: false,
                                description: "A language of the resource."
                            },
                            relation: {
                                required: false,
                                description: "A related resource."
                            },
                            coverage: {
                                required: false,
                                description: "The spatial or temporal topic of the resource, the spatial applicability of the resource, or the jurisdiction under which the resource is relevant."
                            },
                            rights: {
                                required: false,
                                description: "Information about rights held in and over the resource."
                            },
                            uri: {
                                required: true,
                                description: "The location of the CSV file, either a URL or a local file location."
                            },
                            delimiter: {
                                required: false,
                                description: "The delimiter of the separated value file.",
                                default_value: ","
                            },
                            has_header_row: {
                                required: false,
                                description: "Boolean parameter defining if the separated value file contains a header row that contains the column names.",
                                default_value: 1
                            },
                            start_row: {
                                required: false,
                                description: "Defines the row at which the data (and header row if present) starts in the file.",
                                default_value: 0
                            },
                            columns: {
                                required: false,
                                description: "Columns should be an array of columns indicis mapped onto the column name. This given column name will replace the original column name that is retrieved from the file itself."
                            },
                            pk: {
                                required: false,
                                description: "The index of the column that serves as a primary key when data is published. Rows will thus be indexed onto the value of the column which index is represented by the pk value."
                            }
                        }
                    }
                }
            }
        }
    }
</pre>


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


