# Consuming data

On this page you will learn how you can

* [Request data from The DataTank](#request)

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
