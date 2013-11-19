# Consuming data

On this page you will learn how you can

* [request data from The DataTank](#request)
* [notes about certain source types](#notes)

<a name='request'></a>
## Requesting data

The DataTank makes data available through a REST interface. This means that data extracted from a certain data structure is available through HTTP. Just as any other operation of functionality, the discovery document shows us where to go!

<pre class="prettyprint linenums">
{
    "protocol": "rest",
    "rootUrl": "http://foo",
    "resources": {
        "info": {
            "methods": {
                "get": {
                    "httpMethod": "GET",
                    "path": "/info",
                    "description": "Get a list of all retrievable datasets published on this datatank."
                }
            }
        }
    }
}
</pre>

The discovery document shows that http://foo/info contains a document that has references to all available datasets, as stated before this list will be presented in a json format since it's part of the resources the datatank manages itself. If you haven't published any datasets so far, there will still be 1 entry in this info document, namely the <em>info/dcat</em> entry. This entry represents a document that lists information about the published datasets, much like the info resource does itself, but created from properties standardized in the [DCAT vocabulary](http://www.w3.org/TR/vocab-dcat/).

<pre class="prettyprint linenums">
{
	info/dcat: {
		description: "A DCAT document about the available datasets created by using the DCAT vocabulary.",
		uri: "http://foo/info/dcat"
		type: null
	},
	geo/csv: {
		description: "An example csv file with geographical properties.",
		uri: "http://foo/geo/csv",
		type: "CSV",
		parameters: {
			page: "Represents the page number if the dataset is paged, this parameter can be used together with page_size, which is default set to 500. Set this parameter to -1 if you don't want paging to be applied.",
			page_size: "Represents the size of a page, this means that by setting this parameter, you can alter the amount of results that are returned, in one page (e.g. page=1&page_size=3 will give you results 1,2 and 3).",
			limit: "Instead of page/page_size you can use limit and offset. Limit has the same purpose as page_size, namely putting a cap on the amount of entries returned, the default is 500. Set this parameter to -1 if don't want paging to be applied.",
			offset: "Represents the offset from which results are returned (e.g. ?offset=12&limit=5 will return 5 results starting from 12)."
		}
	}
}
</pre>

As you can see every entry has a description that is retrieved from the definition itself and contains the type of the data structure that holds the data represented by the uri. Furthermore we can see that some resources have a parameters entry. These represent optional request parameters that can be passed, in most cases this will be a duo of paging parameters, but can vary on the level of a single entry for these request parameters are configurable.

This is all you need to know in order to get a glimp of what datasources are available and on which uri they are retrievable.

<a name='notes'></a>
## Notes

There are some side-notes to be made with the requesting of data be it in certain formats, or from certain source types.

### XML format

If you request data in an xml format, do note that xml has a few flaws in its design and specification. One of them is the prohibition of the first character of a tag name being an integer according to the [XML spec](http://www.w3.org/TR/REC-xml/#NT-Name). Therefore if properties (column names in a CSV file for example) are integers, the XML will be 'malformed', but will still be made nonetheless. Note that column names that contain whitespace will also be concatenated with an underscore since XML does not take whitespaced tag names.

### SHP source type

Currently we store geo properties in the back-end as meta-data information so that formatters can use this information to provide more visual information (e.g. map formatter). There currently is 1 inhibition considering the SHP publisher, namely it can take only 1 type of shape. We have noticed that the shape files currently available on several open data portals (Germany, Italy, ...) all use 1 type of shape type in their binary structure be it a set of points, multi-lines, polygons, etc. If we encounter however a lot of instances where a variety of shapes is used, we'll probably opt to calculate the type of the shape a row represents in the SHP file on the fly.

### SPARQL source type

The SPARQL source type can take a query as a parameter, and can even contain parameters inside the query itself which can then be filled in. If our query were to be the following:

<pre class='prettyprint'>
    query = 'SELECT * from { GRAPH <${graph_name}> { ?s ?p ?o }}'
</pre>

and it was published on a link http://foo/sparql/bar, you would get a 400 error telling you that the request failed and there might be be a chance that you have to pass along a parameter, which is the case here.

So, in order to fill in the ${graph_name} part of the SPARQL query, you have to pass along a key - value pair in the query string of the request e.g. http://foo/sparql/bar.json?graph_name=foo_graph .

This value will be replaced on a 1-1 raw basis. A very important caveat to mention here is that when you happen to find yourself in a situation where you have to pass a hash tag along as a value of a request parameter you'll have to url encode (# = %23) it, and replace that in your query string e.g. http://foo/sparql/bar.json/graph_name=foo_graph%23posthashtag
