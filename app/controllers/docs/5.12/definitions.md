# Definitions

In addition to creating definitions, this page will focus on

* [How to read a definition](#publish)
* [How to delete a definition](#delete)
* [How to patch a definition](#patch)

The following paragraphs form a technical explanation on how to achieve the functionalities listed above through the REST API.
If you want to manage and edit datasets you can also do this through our user interface.

<a id='read' class='anchor'></a>
## Read a definition

In order to retrieve the set of parameters that make up a definition, you can perform a get method on the definitions resource. This can be extracted from the snippet discovery document below.

<pre class="prettyprint linenums">
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
                }
            }
        }
    }
}
</pre>

The REST URI for a certain definition would be: http://localhost/api/definitions/resources/resource1.

Note that our internal API is only interfaceable through JSON or HTTP query parameters. The format in which datasets are retrieved is being done through content negotiation.

<a id='delete' class='anchor'></a>
## Delete a definition

The delete method, as shown by the snippet discovery document, will allow us to delete a resource definition. Note that this will also remove the uri on which the data could be retrieved. An example of how to perform a delete request is given below the snippet.

<pre class="prettyprint linenums">
{
    "protocol": "rest",
    "rootUrl": "http://foo/api",
    "resources": {
        "definitions": {
            "methods": {
                "delete": {
                    "httpMethod": "DELETE",
                    "path": "/definitions/{identifier}",
                    "description": "Delete a resource definition identified by the {identifier} value."
                }
            }
        }
    }
}
</pre>

The snippet below deletes the resource identified by the identifier <em>trees/2011</em>.

<pre class="prettyprint linenums">
// Initiate the curl request
$ch = curl_init();

// Define our definition uri
$url = "http://foo/api/definitions/trees/2011";

// Create the general configurations for the curl request that deletes a resource definition
$options = array(
    CURLOPT_CUSTOMREQUEST => "DELETE",
    CURLOPT_URL => $url,
    CURLOPT_HTTPAUTH => CURLAUTH_ANY,
    CURLOPT_USERPWD => "foo" . ":" . "bar",
    CURLOPT_FRESH_CONNECT => 1,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_FORBID_REUSE => 1,
    CURLOPT_TIMEOUT => 4,
);

// Set the configuration of the curl request
curl_setopt_array($ch, $options);

$response = curl_exec($ch);
</pre>

<a id='patch' class='anchor'></a>
## Update a definition

The patch method of the definitions resource allows to update certain parts of the definition. These parts are dependent on the source type, and can be checked using the discovery document. Note that this is almost exactly the same as the put-method of the definitions resource. The fundamental difference here is that you're updating a resource, making it so that there's no difference between required or additional parameters. As an example, a snippet of the discovery document (patching a csv) is shown below as well as an example patch request.

<pre class="prettyprint linenums">
{
    "protocol": "rest",
    "rootUrl": "http://foo/api",
    "resources": {
        "definitions": {
            "methods": {
                "patch": {
                    httpMethod: "PATCH",
                    path: "/definitions/{identifier}",
                    description: "Patch a resource definition identified by the {identifier} value. In contrast to PUT, there's no need to pass the media type in the headers.",
                    mediaType: {
                        csv: {
                            description: "Patch an existing definition.",
                            parameters: {
                                ...
                                description: {
                                    name: "Description",
                                    description: "The descriptive or informational string that provides some context for you published dataset.",
                                    type: "string"
                                },
                                ...
                                columns: {
                                    description: "Columns must be an array of objects of which the template is described in the parameters section.",
                                    parameters: {
                                        column_name: {
                                            required: false,
                                            name: "Column name",
                                            description: "The column name that corresponds with the index.",
                                            type: "string"
                                        },
                                        pk: {
                                            required: false,
                                            name: "Primary key",
                                            description: "The index of the column that serves as a primary key when data is published. Rows will thus be indexed onto the value of the column which index is represented by the pk value.",
                                            type: "integer"
                                        },
                                        index: {
                                            required: false,
                                            name: "Index",
                                            description: "The index of the column, starting from 0.",
                                            type: "integer"
                                        },
                                        column_name_alias: {
                                            required: false,
                                            name: "Column name alias",
                                            description: "Provides an alias for the column name and will be used when data is requested instead of the column_name property.",
                                            type: "string"
                                        }
                                    }
                                },
                                geo: {
                                    description: "Geo must be an array of objects of which the template is described in the parameters section.",
                                    parameters: {
                                        property: {
                                            required: false,
                                            name: "Property",
                                            description: "This must be a string holding one of the following values polygon,latitude,longitude,polyline,multiline,point.",
                                            type: "string"
                                        },
                                        path: {
                                            required: false,
                                            name: "Path",
                                            description: "This takes on the path to the value of the property, for tabular data for example this will be the name of the column that holds the property value.",
                                            type: "string"
                                        }
                                    }
                                },
                                title: {
                                    name: "Title",
                                    description: "A name given to the resource.",
                                    type: "string",
                                    group: "dc"
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

The php snippet below will patch up the definition description of the resource identified by <em>trees/2011</em>. This shows another difference to what a put requests looks like, we don't have to pass along the source type, as the uri already defines a definition, and with it, a source type.

<pre class="prettyprint linenums">
// Initiate the curl request
$ch = curl_init();

// Construct the meta-data properties
$patch = array(
    "description" : "Updated description about the resource trees/2011.",
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
);

// Set the configuration of the curl request
curl_setopt_array($ch, $options);

$response = curl_exec($ch);
</pre>

