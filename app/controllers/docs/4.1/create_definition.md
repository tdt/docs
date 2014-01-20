# Create a resource definition

On this page you will learn

* [How to create a definition](#publish)

<a id='publish' class='anchor'></a>
## Adding a resource

Our core functionality is to extract data from a certain data structure and provide this content to the user using HTTP. As described in our introduction pages, in order to extract data we need some meta-data telling us how to do that. This set of meta-data is called a resource definition, or - shorter - definition.

What follows is a list of steps a maintainer of a datatank has to take in order to create a new definition so that data can be published from a certain data file. This small tutorial assumes that a datatank is hosted on http://foo and explains the basics of the discovery document. A fair bit of reading, but essential nonetheless!

If you don't feel like doing all this manual technical stuff, you can do everything through a [user interface](/4.1/ui_introduction).

### Set up the resource definition template

In order to know which meta-data properties you have to pass to create a valid resource definition in order to publish data from a certain data structure you'll have to take a look at the discovery document, located at http://foo/discovery.

The discovery document shows a list of methods that one can perform on the resources of a datatank instance. One of those resources is called <b>definitions</b> and is used to create, read, update and delete resource definitions. For tutorial purposes, a small snapshot is taken and displayed below.

<pre class="prettyprint pre-scrollable linenums">
{
    "protocol": "rest",
    "rootUrl": "http://foo/api",
    "resources": {
        "definitions": {
            "methods": {
                "get": {
                    "httpMethod": "GET",
                    "path": "/definitions/{identifier}",
                    "description": "Get a resource definition identified by the {identifier} value, or retrieve a list of the current definitions by leaving {identifier} empty."
                },
                "put": {
                    "httpMethod": "PUT",
                    "path": "/definitions/{identifier}",
                    "description": "Add a resource definition identified by the {identifier} value,. The {identifier} consists of 1 or more collection identifiers, followed by a final resource name. (e.g. world/demography/2013/seniors). Valid characters that can be used are alphanumerical, underscores and whitespaces.",
                    "contentType": "application/tdt.definitions+json",
                    "mediaType": {
                        "csv": {
                            "description": "Create a definition that allows for publication of data inside a Csv datastructure.",
                            "parameters": {
                                type: {
                                    required: true,
                                    name: "type",
                                    description: "The type of the data source.",
                                    type: "string",
                                    value: "csv"
                                },
                                "title": {
                                    "required": false,
                                    "description": "A name given to the resource."
                                },
                                "subject": {
                                    "required": false,
                                    "description": "The topic of the resource."
                                },
                                "description": {
                                    "required": true,
                                    "description": "The descriptive or informational string that provides some context for your published dataset."
                                },
                                "publisher": {
                                    "required": false,
                                    "description": "An entity responsible for making the resource available."
                                },
                                "rights": {
                                    "required": false,
                                    "description": "Information about rights held in and over the resource."
                                },
                                "uri": {
                                    "required": true,
                                    "description": "The location of the CSV file, either a URL or a local file location."
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
</pre>

If we take a look at the definitions resource we notice that it has a property called <b>methods</b>. This identifies all the methods the definitions resource can handle.
Note that the name of the methods do not always have a 1-1 translation to HTTP methods, which this document happens to have. Going by the description of the <b>put</b> method we know that we have to use this method, identified by a HTTP PUT method, to create a new resource definition.

The document also provides us a `path` property which tells us which path we have to use, relative to the <b>rootUrl</b> property of the discovery document, to perform our HTTP request to. The path also contains an {identifier} piece which servers as an identifier for the resource definition you want to add, the curly braces indiciate that this is variable field and needs to be filled in.

From the description we can derive that the identifier consists of a collection part and a resource-naming part. In this tutorial we're going to publish data about trees, we have 3 datasets in total, data from 2011, 2012 and 2013. Our collection uri will be "trees" and the name of the resource will be the year that the data is relevant to, leading to the following structure:

* http://foo/api/definitions/trees/2011
* http://foo/api/definitions/trees/2012
* http://foo/api/definitions/trees/2013

Note that we can only add 1 resource definition per method call.

Ok! Now you know what the discovery document is all about and how to use it, let's recap what we know so far.

We know which method to use, and to which URI we must perform the request, the next step is to figure out which meta-data we have to pass along with the request.

For the sake of this example we'll assume that the data we want to publish is a CSV file. The data structures that are supported by the datatank are listed as properties of the put method. If we take a look at our snapshot above we see that <em>csv</em> is listed, so we know we can publish CSV data!

>> The Content-Type header is optional, just make sure your HTTP request doesn't contain any other default Content-Type header.

Assuming we work in a PHP environment to create an HTTP call using cURL, we can already construct the following:

<pre class="prettyprint linenums">
// Initiate the curl request
$ch = curl_init();

// Define our definition uri
$url = "http://foo/api/definitions/trees/2011";

// Construct the meta-data properties
$put = array(

);

// Create the general configurations for the curl request
$options = array(
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_URL => $url,
    CURLOPT_HTTPAUTH => CURLAUTH_ANY,
    CURLOPT_USERPWD => "foo" . ":" . "bar",
    CURLOPT_FRESH_CONNECT => 1,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_FORBID_REUSE => 1,
    CURLOPT_TIMEOUT => 4,
    CURLOPT_POSTFIELDS => json_encode($put),
    CURLOPT_HTTPHEADER => array("Content-Type: application/tdt.definitions+json"),
);

// Set the configuration of the curl request
curl_setopt_array($ch, $options);

$response = curl_exec($ch);
</pre>

### Filling in the definition template

Now we have a our basic parameters filled in to make our request, all we need to do is fill in the required parameters, and some other meta-data properties if we like.
Again we look at the discovery document, which tells us that in for a CSV datasource, we need to pass 3 required parameters namely <em>description</em>, <em>uri</em> and <em>type</em>. Note that type is always filled in already, so you just need to copy its content.

Going by the description of each of the parameters we know that we have to pass a small informational, descriptive text about our dataset, and a uri that can be accessed by the datatank to extract the data from.

Other meta-data properties are indicated as optional, this is the case when the property "required" is set to false. Our example CSV files happen to have a semi-colon as a delimiter, which is different from the default value that the property "delimiter" has.

<pre class="prettyprint linenums">

id;tree_type;height;age
B93;Ailanthus;50m;25
B94;Ebony;34;16
B95;Ebony;2;3
B96;Ash;34;19
B97;Apple;9;4
</pre>

Adding this information to the cURL request in our PHP script we have the following:

<pre class="prettyprint linenums">
// Initiate the curl request
$ch = curl_init();

// Define our definition uri
$url = "http://foo/api/definitions/trees/2011";

// Construct the meta-data properties
$put = array(
    "description" => "Tree data taken in the year 2011 in the foo forest.",
    "delimiter" => ";",
    "uri" => http://bar/data/trees/2011.csv",
    "type" => "csv",
);

// Create the general configurations for the curl request
$options = array(
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_URL => $url,
    CURLOPT_HTTPAUTH => CURLAUTH_ANY,
    CURLOPT_USERPWD => "foo" . ":" . "bar",
    CURLOPT_FRESH_CONNECT => 1,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_FORBID_REUSE => 1,
    CURLOPT_TIMEOUT => 4,
    CURLOPT_POSTFIELDS => json_encode($put),
    CURLOPT_HTTPHEADER => array("Content-Type: application/tdt.csv"),
);

// Set the configuration of the curl request
curl_setopt_array($ch, $options);

$response = curl_exec($ch);
</pre>

When this call returns successfully, 2 things will have changed to your datatank:

* a new resource definition will be added to the definitions resource
* a uri identified by {identifier} will now return data extracted from the data source that the definition describes
