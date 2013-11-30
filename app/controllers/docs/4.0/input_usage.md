# Input usage

In this section you will learn

* [How to configure a job](#job)
* [Overview of jobs](#overview)

<a name="job"></a>
## Configuring a job

In our core publishing application (tdt/core) we've defined a set of meta-data necessary to read data as a (resource) definition. Input has a same approach to identify a set of meta-data that make up the entire emlp process and is called a job. This job holds a set of parameters per process of the emlp variable to which purpose the part is used. Sounds difficult and complicated, so let's break it down with an example.

After installing input, the core application picks this up as a resource that can be triggered with methods, head down to the discovery document e.g. http://foo/discovery in order to see which methods you can call onto input and which parameters are expected.

<pre class="prettyprint linenums">
{
    "httpMethod": "PUT",
    "path": "/input/{identifier}",
    "description": "Create a new input job that consists of an extract, mapping (optional), loading and publishing (optional) process. The {identifier} identifies the configuration.",
    "parameters": {
        "extract": {
            "parameters": {
                "type": {
                    "JSON": {
                        "parameters": {
                            "uri": {
                                "required": true,
                                "description": "The location of the JSON file"
                            }
                        }
                    }
                }
            }
        },
        "map": {
            "parameters": {
                "type": {
                    "rdf": {
                        "parameters": {
                            "mapfile": {
                                "required": true,
                                "description": "The location of the mapping file,either a URL or a local file location."
                            },
                            "base_uri": {
                                "required": true,
                                "description": "The baseuri that will be used as a base for the subject of the triples."
                            }
                        }
                    }
                }
            }
        }
    }
}
</pre>

For the sake of this example we haven't included the load and publish section because the document would get too long. Nonetheless, the same workflow accounts to those sections as the extract and map sections which will be explained in the following paragraphs.

The input section of the discovery document shows a couple of methods. The one that is important for this explanation is the put-method. This method is identified by the PUT HTTPMethod and takes on a similar path as we've seen in the definitions example, the only difference is the resource name (input instead of definitions).

In order to know how to build your configuration for a job, take this rule of thumb into account: whenever you encounter a parameters section, the keys in that section must be passed ( if required is true, or no required key is given) in the configuration. So, let's put this rule to the test shall we?

We encounter a parameters section at the level of path, description and httpMethod, marking the top-level of our configuration document(we can already tell it's going to be a hierarchical set of parameters, hence the document).

We can see that our top level will have the keys extract and map (and load and publish if the complete document is taken into account) and contain a few parameters themselves. Our document we have to pass is now this :

<pre class="prettyprint linenums">
{
	"extract" : null,
	"map" : null
}
</pre>

Let's dig deeper into the extract part, if we think back to definitions and its sourcetypes, we remember that we can extract data from several data sructures, the extract part of the job does a similar job at defining which data source needs extraction, and what parameters are necessary per source type. For the sake of simplicity we've only kept JSON as a possible data structure.

This type on itself takes on a set of parameters itself, namely the uri of the JSON file.

Map has exactly the same workflow, and so does publish and load in the full discovery document, and contains a type of mapping, RDF in our example, which again takes on a set of parameters itself. With the rule of thumb that every parameter can be a key, we can construct the following document that needs to be put with the HTTP request.

<pre class="prettyprint linenums">
{
	"extract" : {
		"type" : "json",
		"uri" : "http://foo/bar.json"
	},
	"map" : {
		"type" : "rdf",
		"mapfile" : "http://foobar/mapping.ttl",
		"base_uri" : "http://foo"
	}
}
</pre>

In a real world example you would need to pass a load section and optionally a publish section with the document as well.

<a name="overview"></a>
## Overview

Just like definitions, you can perform a get method on the input resource. This will return all of the configured jobs in a JSON-format. Note that each of these jobs can be used as a document to put the same configuration elsewhere.

As the discovery document states, this can be simply done by performing a GET request to the input resource e.g. GET http://foo/input
