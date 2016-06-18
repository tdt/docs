# SPARQL

On this page we will elaborate on how you can publish SPARQL queries.

## Templating

### Simple value templating

Publishing SPARQL queries is done the same way you would publish any other data source. However, SPARQL queries have some extra flexibility. Since you're passing along SPARQL queries, it's possible to abstract them and replace certain values with variables.

Let's take a simple SPARQL query:

<pre class='prettyprint'>
    SELECT * from { GRAPH &lt;${graph_name}&gt; { ?s ?p ?o. }}
</pre>

The parameter is identified by ${identifier} in the query itself and is here used to identify the graph but don't let that hold you from using the parameter anywhere else, it can be used anywhere in the query and there's no limit to how many parameters you put in your query.

When someone requests your published SPARQL query the parameter string, ${identifier}, will be entirely replaced by the query string parameter value the user passes along with its request.

For example when a user passes this uri: http://foo/sparql/query.json?graph\_name=http://foobar%23version1 the query will look like this:

<pre class='prettyprint'>
    SELECT * from { GRAPH &lt;http://foobar#version1&gt; { ?s ?p ?o. }}
</pre>

This query will then be executed to the SPARQL endpoint and the proper response will be returned.

> CAVEAT: since hashtags are quite often used in the semantic world, you'll find yourself passing one in as a query string parameter. Make sure you encode it first (%23 = #) before entering it in your URI, the datatank can't fetch it if you don't.

Note that one can send multiple request parameters with the same identifier like this: http://foo/sparql?identifier=value1&identifier=value2.  In this case the SPARQL definition can refer to the distinct values by using ${identifier[0]} and ${identifier[1]}

### Logical templating

Another templating structure is the use of an ifisset or ifnotset structure.
The purpose of this structure is quite simple, if a certain value is passed in the query string, add/omit a certain part of the query.

Example:

<pre class='prettyprint'>
    SELECT * from
    { GRAPH &lt;http://foobar&gt;
    {
    ?s ?p ?o.
    ifisset(geo) { ?s a geo:Location.}
    }
    }
</pre>

If the URI is http://templated?geo, then the part that is between the curly braces will be included. If not, it will not be added to the query. In return, you can also use ifnotset to achieve the opposite.

## Semantic vs non-semantic results

Publishing a SPARQL query, in contrast to other data sources, can return 2 types of results namely a semantic and a non-semantic one.

> Currently we only support select and construct SPARQL queries.

When you define a construct query, the datatank will request an rdf+xml representation of the query result from the endpoint and load it into a [graph object](https://github.com/semsol/arc2/wiki). This graph will then be returned and by default formatted into a turtle representation.

When you define a select query, the datatank will request a json representation and will handle it as raw data, just like all the other data sources in the datatank.

>> CAVEAT: We fetch some meta-data (e.g. paging queries) using a query to the sparql-endpoint with [application/sparql-results+json](http://www.w3.org/TR/sparql11-results-json/) as a format parameter. Also select queries are being retrieved with this given format. Make sure the endpoint supports this.