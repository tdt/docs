# SpectQL

On this page you will learn

* [What spectql is](#introduction)
* [How it works](#howto)
* [What its limitations are](#limits)

<a id="introduction" class="anchor"></a>
## Introduction

Spectql is a query language that is created by and for the datatank. It provides a set of functionalities that users can use to pre-process data before they get a response from the datatank. Normally you request data by going to a certain URI (e.g. http://host/foo/bar) and the datatank will provide you with a response containing data that has been published using foo/bar as an identifier. So on one end you have the user that requests data, on the other the extraction of data, spectql lives between those two ends.

The query you pass through the URI is interpreted by the datatank and is then executed on the data the datatank returns, after the execution the query result is returned to the user.


<a id="howto" class="anchor"></a>
## How does it work

Spectql is a query language used by the datatank and uses the URI to parse the query. The spectql template is the following:

    http://host/spectql/[identifier]{[selectors]}?$filters:[format]

A more specific template is given on [spectql.org](http://spectql.org), not that this is an automatically generated visualization, making sure it's a charm for the eye will come soon.

### identifier

The identifier of the data source on the datatank

### selectors

A comma seperated list of selector values. A selector value can be

* the path to a value in the data
* a function with a path value
* an asterisk '*', which will return all of the data

Possible functions are:

* avg = returns the average of the value
* count = returns number of rows
* first = returns the first value
* last = returns the last value
* max = returns the maximum value
* min = returns the minimum value
* sum = returns the sum of the values
* ucase = returns the value in uppercase
* lcase = returns the value in lowercase
* len = returns the length of a value

### filters

A list of comparative triplets separated with either an ampersand (&) or a pipe symbol (|)
A triplet exists out of a path to a string value, a comparator and another string value for example column1=='foo'

Multiple filters can be passed by combining them with an ampersand, indicating a boolean AND operation, and a pipe symbol indicating a boolean OR operation.

The list of available comparators are:

* like: ~
* equals: ==
* greater than: >
* greater than or equal: >=
* smaller than: <
* smaller than or equal: <=


Let's take a look at some examples that should clarify the template and its components described above.

    http://host/spectql/foo/bar{*}?name=='John Doe':json
    http://host/spectql/foo/bar{name, last_name, age}?name~'John'|age>'30'&city=='New York':xml
    http://host/spectql/foo/bar{avg(age), name}?name=='Jane':json

Let's analyse these queries one by one in order to know what each of them does.

1. http://host/spectql/foo/bar{*}?name=='John Doe':json

    This first query has 1 selector value and 1 filter, the selector value '*' indicates that all of the data will be returned.
    The filter will make it so that only the objects that have their property 'name' set to 'John' are returned.
    The entire result will be passed as a JSON result.


2. http://host/spectql/foo/bar{name, last_name, age}?name~'John'|age>'30'&city=='New York':xml

    This query specifies the specific data fields to be returned, and wants their objects to have:
        John mentioned in the name (e.g. 'The John', 'Our John', 'Johny' will all match)
        the age property higher than 30
        the city property to be equal to New York
    The entire result will be returned in an XML representation.


3. http://host/spectql/foo/bar{avg(age)}?city=='Chicago':json

    This last query will return the average age of all the objects where the property city is equal to Chicago.


A note to make is the name of the keys will be the same of the original dataset, unless a function has been used! Then the name will be concatenated to the original name of the key e.g.

    select{ucase(firstname)}:json

Then the result will be:

<pre class='prettyprint'>
    {
        "ucase_firstname" : "JOHN"
    }
</pre>



<a id="limits" class="anchor"></a>
## Limitations of spectql

Spectql is a fun feature of our application in order to provide you with information you want from a certain data source, however there are a few limitations.

1. Size matters

    The spectql queries are processed post extraction time, this means that before any spectql filter is executed, the entire data source will be extracted and put into memory.
    Once the entire object has been read, the spectql query will be applied to that entire object. Large datasource will sometimes cause a timeout on the server because the amount of resources
    will be too high.

2. Raw data only

    Semantic data will not be eligible to query though spectql for the simple reason that semantic data has a complete different approach towards representation, structure and therefore handling than pure raw data.
    However, we do provide the possibility to [publish SPARQL queries](/4.1/sparql) through the datatank so that using a query language such as spectql becomes obsolete for semantic data.