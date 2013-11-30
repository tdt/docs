# Read a definition

The discovery document shows us that by performing a get method on the definitions resource we'll get a list of the defined definitions.

<pre class="prettyprint linenums">
{
    "protocol": "rest",
    "rootUrl": "http://foo",
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

Moreover, if we fill in an identifier value, we'll only retrieve that specific definition unique to the given identifier. Note that this information is only retrievable in a JSON format, all of our core resources (e.g. definitions, input, info, ...) for that matter will return JSON formatted documents. The retrieval of data however is done through content negotiation.

<a name="delete"></a>
# Delete a definition

The delete method, as shwon by the discovery document, will allow us to delete a resource definition. Note that this will also remove the uri on which data, that the definition described, could be retrieved. Note that the identifier part must be specified.

<pre class="prettyprint linenums">
{
    "protocol": "rest",
    "rootUrl": "http://foo",
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

<a name="patch"></a>
# Update a definition

At this moment updating (using the PATCH header) is not yet supported.
