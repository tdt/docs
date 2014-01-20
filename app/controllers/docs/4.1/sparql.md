# SPARQL

On this page we will elaborate on how you can publish SPARQL queries.

## Templating

Publishing SPARQL queries is done the same way you would publish any other data source. However, SPARQL queries have some extra flexibility. Since you're passing along SPARQL queries, it's possible to abstract them and replace certain values with variables.

Let's take a simple SPARQL query:

<pre class='prettyprint'>
    SELECT * from { GRAPH <${graph_name}> { ?s ?p ?o. }}
</pre>

The parameter is identified by ${identifier} in the query itself and is here used to identify the graph but don't let that hold you from using the parameter anywhere else, it can be used anywhere in the query and there's no limit to how many parameters you put in your query.

When someone requests your published SPARQL query the parameter string, ${identifier}, will be entirely replaced by the query string parameter value the user passes along with its request.

For example when a user passes this uri: http://foo/sparql/query.json?graph\_name=http://foobar%23version1 the query will look like this:

<pre class='prettyprint'>
    SELECT * from { GRAPH <http://foobar#version1> { ?s ?p ?o. }}
</pre>

This query will then be executed to the SPARQL endpoint and the proper response will be returned.

>> Caveat lector: since hashtags are quite often used in the semantic world, you'll find yourself passing one in as a query string parameter. Make sure you encode it first (%23 = #) before entering it in your URI, the datatank can't fetch it if you don't.

## Semantic vs non-semantic results

Publishing a SPARQL query, in contrast to other data sources, can return 2 types of results namely a semantic and a non-semantic one.

>> Currently we only support select and construct SPARQL queries.

When you define a construct query, the datatank will request an rdf+xml representation of the query result from the endpoint and load it into a [graph object](https://github.com/semsol/arc2/wiki). This graph will then be returned and by default formatted into a turtle representation.

When you define a select query, the datatank will request a json representation and will handle it as raw data, just like all the other data sources in the datatank.