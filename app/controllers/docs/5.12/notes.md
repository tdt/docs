# Notes

On this page we will elaborate more on some specifics about source types and certain formats

* [Xml format](#xmlformat)
* [Shp source type](#shp)
* [Sparql source type](#sparql)
* [Xml source type](#xml)
* [Logs](#logs)

There are some side-notes to be made with the requesting of data be it in certain formats, or from certain source types.

<a id='xmlformat' class='anchor'></a>
## XML format

If you request data in an xml format, do note that xml has a few flaws in its design and specification. One of them is the prohibition of the first character of a tag name being an integer according to the [XML spec](http://www.w3.org/TR/REC-xml/#NT-Name). Therefore if properties (column names in a CSV file for example) are integers, then they will be prefixed with the character "i". Another data-changing action we had to take is with column names that contain whitespace will also be concatenated with an underscore since XML doesn't allow whitespaced tag names.

A last small change we had to make on XML documents (when extracting and outputting them) is due to the non-usage of OOP principles, in other words, XML is not OOP. This shows in the allowed specification of an element having a string value and at the same time one or more child elements. This is impossible to process properly in an OOP way, therefore all of the #text elements in an XML DOM tree are parsed an pushed into an @text array. The only thing lost here, is the order of these #text nodes. They are returned by imploding this array on formatting the raw data.

All of our data formatting is done in a uniform anonymous way. This means that (if applicable) the root element of a representation is either non-existent or uniform across all representations. Therefore, the root element of an XML representation will be <em>root</em>.

<a id='shp' class='anchor'></a>
## SHP source type

Our SHP data is being read using an open source library. The structures (shape types) that we support depend entirely on that library. Currently we support all shape types except types where a measurement is given. (pointM, polygonM, multipointM and multilineM). Normal shape types as well as shape types with elevation properties are supported.

The supported EPSG codes are the codes that are supported by the [proj4 PHP project](https://github.com/proj4php/proj4php). This means that the supported codes are dependent on the codes supported in their library. However, there's a branch that will focus on parsing [geographical strings](http://spatialreference.org/ref/epsg/) that describe a certain coordinate system instead of transforming the coordinates based on pre-defined EPSG codes as is the case at the time of writing. Future minor releases of the 5.12 version may hold the functionality to add EPSG codes, a command for this has already been made, so when this functionality is merged into the master branch of the proj4 project we can integrate this feature quite fast.

<a id='sparql' class='anchor'></a>
## SPARQL source type

The SPARQL source type can take a query as a parameter, and can even contain parameters inside the query itself which can then be filled in. If our query were to be the following:

<pre class='prettyprint'>
    query = 'SELECT * from { GRAPH <${graph_name}> { ?s ?p ?o }}'
</pre>

and it was published on a link http://foo/sparql/bar, you would get a 400 error telling you that the request failed and there might be be a chance that you have to pass along a parameter, which is the case here.

So, in order to fill in the ${graph_name} part of the SPARQL query, you have to pass along a key - value pair in the query string of the request e.g. http://foo/sparql/bar.json?graph\_name=foo\_graph .

This value will be replaced on a 1-1 raw basis. A very important caveat to mention here is that when you happen to find yourself in a situation where you have to pass a hash tag along as a value of a request parameter you'll have to url encode (# = %23) it, and replace that in your query string e.g. http://foo/sparql/bar.json?graph\_name=foo\_graph%23posthashtag

<a id='xml' class='anchor'></a>
## XML source type

When publishing an XML data source, you might notice some strange formatting of the data at first sight. This however is due to the specification of the XML spec, and its incompatibility with other formats such as JSON and representation in PHP.

Let's take a simple example XML to clarify what happens and what you can expect.


    <persons>
        <person id="foo" attribute="bar">
            <id>1</id>
            <name id='rose'>Rosalyn</name>
            <surname>Mcclure</surname>
            <city>Victor Harbor</city>
        </person>
    </persons>


Now, if you have any knowledge with PHP and/or JSON, try to think how you can parse this into a PHP or JSON object.

At first glance you might think, a person will be an object name and contains properties with a string as a value, what's the big deal? The deal with XML is that it can attribute a property (attribute) and a value (textnode e.g.) to one and the same tagname (object); which is impossible to do in JSON or PHP, it must either have a literal or an array/object as a value, not both.

Therefore, you'll see the following formatting appearing when you're requesting this published XML source in JSON:

<pre class='prettyprint'>
{
    "person": [
        {
            "id": {
                "@value": "1"
            },
            "name": {
                "@attributes": {
                    "id": "rose"
                },
                "@value": "Rosalyn"
            },
            "surname": {
                "@value": "Mcclure"
            },
            "city": {
                "@value": "Victor Harbor"
            },
            "@attributes": {
                "id": "foo",
                "attribute": "bar"
            }
        }
    ]
}
</pre>

Why the rather strange @'s prefixes for attributes and value? Simple, an @ sign is not allowed as a first character in an XML tag. If you have been somewhat reading our explanation thusfar, you'll understand that <em>@value</em> is the textnode value and <em>@attributes</em> is the listing of the attribute key value pairs.
We can agree on the fact that if your XML doesn't contain any attributes, and you want everything to be parsed as if there were no such thing as attributes, you can always suggest a solution on our [github repository](https://github.com/tdt/core).

Another thing to be aware of is that the concept of arrays isn't explicitly present in XML, meaning that you can easily have the following in XML:

    <persons>
        <person id="foo" attribute="bar">
            <id>1</id>
            <name id='rose'>Rosalyn</name>
            <surname>Mcclure</surname>
            <city>Vici Harbor</city>
        </person>
        <person id="bar" attribute="foo">
            <id>2</id>
            <name id='tulip'>Tulyn</name>
            <surname>McPeak</surname>
            <city>Veni Harbor</city>
        </person>
    </persons>

This will be represented in PHP (and possibly JSON in any XML to JSON converter) as a person (not persons) array with elements in them that contain the person information. Since information is lost here an XML representation of the original XML document will look slighly different. We've opted to represent arrays of elements as an XML array with the same tagname (person) but with each element identified by the tagname <em>element</em>.


    <persons>
        <person>
            <element id="foo" attribute="bar">
                <id>1</id>
                <name id="rose">Rosalyn</name>
                <surname>Mcclure</surname>
                <city>Victor Harbor</city>
            </element>
            <element>
                <id>2</id>
                <name>Amy</name>
                <surname>Mullen</surname>
                <city>Casciana Terme</city>
            </element>
        </person>
    </persons>

## Logs

when in debug mode things get written to the log file located in app/storage/logs/laravel.log. Make sure to clear this file from time to time as it might build up in large file, doing nothing. Even when the application is in production, errors that occur or certain high relevant events get written to the logs so make sure you either clear it manually from time to time, or configure it in a cronjob.