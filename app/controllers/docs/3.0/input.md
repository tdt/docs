# Input

When you have tdt/input installed, you can ingest data in a triple store, and make The DataTank automatically read these data. This page is going to walk you through the process.

## Why would you want to do this

There are various reasons why this is a must for your organisation:

* you want to lift your data to the fifth star of open data
* you want to have different internal files talking about the same thing to be query-able as if they are one
* you want to create a “data hub”

All of these reasons mean that you want to add semantics to your data, so that even machines know what you are talking about. Of course this requires some work from your side: you need to describe your data which you are putting into one big store. This requires domain knowledge, and although a lot of this domain knowledge has already been made available, you still need to say which part of your data is talking about which thing.

## The set-up

We will need a triple store. A triple store is a type of database that is perfect for storing semantically enriched data. The triple store has a SPARQL-endpoint, which allows you to query the data using SPARQL.
Then you'll need to include tdt/input in your composer.json file in the root of you application (the folder where you installed tdt/start) and perform a composer update command.

## Configuring a semantifying sequence

A semantifying sequence exists of an extract, map and load part. These parts need to be configured in what we call a <em>job</em>. This job thus contains all the information that is needed to extract data from a certain data source, map the extracted data based on a mapping file, creating triples and loading these triples into a triple store.

Similar to the core, where you would add resource definitions to the tdtadmin/resources package, you will have to use the input endpoint to create new jobs which is located at <em>input</em> (e.g. http://foo/input). Below are some examples of job configuration creations.

Ex. 1: Adding a CLI loader

A command line interface loader, without mapping, can be used to check what the output of a job will be. This can be used to create the mapping file for the next example.

In this example we are going to add a loader that will write all output to standard output and not map anything. We will tell the system that this job needs to be done every 1 minute.

<pre class='prettyprint'>
$ curl http://foo/TDTInput/Stations -XPUT -d '
{
    "name": "Stations",
    "occurence": 1,
    "extract":{
        "type":"CSV",
        "delimiter":";",
        "source":"http://data.irail.be/NMBS/Stations.csv",
        "has_header_row" : "1"
     },"map": {
        "type": "RDF",
        "mapfile": "http://demo.thedatatank.org/nmbs.ttl",
        "datatank_package": "NMBS",
        "datatank_resource": "Stations",
        "datatank_uri": "http://foo/"
    },
    "load" : {
      "type":"CLI"
    }
}' -i -u "username" -p
</pre>


Ex. 2: Adding an RDF loader

Do you have a mapping file yet? Be sure to read this document first.

Now you can add your own parameters when adding this:

<pre class='prettyprint'>
"load":{
    "type":"RDF",
    "datatank_uri": "http://foo/",
    "datatank_package": "NMBS",
    "datatank_resource": "Stations",
    "endpoint" : "http://yoursparqlendpoint:8890/sparql-auth",
    "datatank_user" : "DataTankUser",
    "datatank_password" : "FancyPassword",
    "endpoint_user" : "dba",
    "endpoint_password" : "dba"
}
</pre>

## Creating a mapping file

In order to use tdt/input to map datasources to RDF data, a mapping file is required. Before you can start, some prior knowledge is required:

* A basic understanding of RDF and its graph pattern
* A notion of the Turtle syntax
* A good understanding about the domains of the data, and public Ontologies describing them.
* A mapping file is a counterpart textfile of your original datasource. Inside this textfile, we describe a mapping specification to convert tabular data to an RDF graph pattern. This specification itself is also written in the RDF based language Vertere Mapping Language, and is syntactically represented with Turtle. The recommended filename of this file is therefore <name_source>.<extension_source>.spec.ttl . You can edit this file using a simple texteditor.

For a detailed description on how to declare the mappings, read the documentation on the [Vertere Mapping Language](https://github.com/tdt/input/blob/development/includes/Vertere/dist/documentation/README.md).

You may find a working example for each file type (CSV, XML, JSON) at the examples folder. For each file type, there is a source file and its corresponding mapping file.

## Running the job

In order to run your job configuration, allowing data extraction, mapping, loading you'll have to go to the URI adding a /run e.g. http://foo/input/eml/example/run.
