# Consuming

On this page you will learn how to

* [read data](#get)
* [filter data](#filter)
* [visualize data](*visualize)

<a id='get' class='anchor'></a>
## Reading data in a RESTful way

The DataTank makes data available through a REST interface. This means data added to The DataTank instance, is available through the uniform HTTP interface, making it interoperable with any web client. Data can be read by sending a simple GET request to a URI. This URI is created when the data was added under the provided package and resource, and typically follows the following pattern: http://{datatank_host}/{packagename}/{resourcename}. For example, if your DataTank is installed at http://foo/, and you added a resource “restaurants” under package “london”, you can then get the data by going to http://foo/london/restaurants.

With REST, everything is a resource on the web, identified by a URI. This allows you to browse into data. For example, our documentation about what an admin user can do located at http://foo/TDTInfo/Admin. Now let’s assume you only want the data about creating CSV resource definitions. You can do that by identifying the object using backslashes e.g. http://foo/TDTInfo/Admin/create/generic/CSV. With this, you’ll notice that each part is an resource on its own, that can be searched deeper.

Another part of reading data through the web is paging, in the datatank we implement paging in the following way. We allow a basis of an amount of entries that can be returned. If the datasource however contains more entries than a page can hold, paging is applied. If paging is applied you can find the links towards the next and/or previous page in the HTTP headers! The Link HTTP Header will contain the combination of a link and an indication whether that link refers to the next or previous page by putting rel=[previous/next] after the link. You can also alter the way paging is done, by using a combination of limit/offset or page/page\_size. Some examples:

* http://foo/data/paged\_data.json?page=1&page\_size=20
* http://foo/data/paged\_data.json?limit=10&offset=5

The first url will return the first 20 items, and will give a link towards http://foo/data/paged\_data.json?page=2&page\_size=20, if there are more than 20 entries in the datasource. The second uri will return entry 5 till 15 in comparison.

If you request a limit or page_size of -1, then paging will not be applied. This means all of the data will be read and passed to the user and might give a memory allocation error internally, and a 500 externally to the user depending on how much memory is configured to PHP.

<a id='filter' class='anchor'></a>
## Filter data

On The DataTank you can also filter data using our own filter language which has some small resemblences with HTSQL, and is called SPECTQL.

### What is SPECTQL

SPECTQL is a query language developed for the datatank. It provides the functionality for the data consumer to fetch data, but pre-processed through a specific grammar. It’s based on htsql, but since we’re not following the standard strictly, we’re going to guide you through the SPECTQL grammar on this page.

### Data retrieval

Getting data through SPECTQL is always done using the SPECTQL end-point. This end-point is put right after your datatank uri. For example if your datatank is installed on http://foo/, your spectql query will begin with http://foo//spectql. In order to start querying a resource, you must append the resource-path to the SPECTQL end-point uri. For example if I was to query a resource located at http://foo//forests/greenwood, I’d have my SPECTQL uri built like this: http://foo//spectql/forests/greenwood. Now the SPECTQL interface knows what resource you want to query, but it doesn’t know what to do with it. Therefore, you’ll have to pass a selection statement. Just like a MySQL query, a selection statement tells the parser which data fields you want to retrieve. In SPECTQL, this statement is identified by using the curley brackets. The following examples provide a query which returns all of the fields from the greenwood resource, and some specified fields respectively.

* http://foo//spectql/forests/greenwood{*}:json
* http://foo//spectql/forests/greenwood{id, tree\_count, bird\_count}:json

Note that after the selection statement a colon is used to identify the end of the query, followed by a format in which the data will be returned. In both cases, this is a JSON format.

#### Filtering with SPECTQL

The SPECTQL interface also provides in filtering data before it is returned to the data consumer. This is done by putting a question-mark after the selection statement, indicating the start of a where-statement. A where-statement can be one or more filter-statements, and in its turn a filter-statement is build with an identifier, an operator and a value. Below are a few example uri’s followed by an overview of possible operators. Note that values that represent strings need to be passed within single quotes.

* http://foo//spectql/forests/greenwood{id, tree\_count, city}?tree\_count>24&city~’county’:json
* http://foo//spectql/forests/greenwood{*}?city==’Orange County’|city==’Orange City’:xml

The first query will return all of the entries of greenwood that have a tree\_count higher than 24 and contains county in its city name. This result will be returned in a JSON format. The second query will return all of the entries where the city is equal to Orange County. This result will be returned in XML.

A list of possible operators is given below:

<table border="1">
    <thead>
        <tr>
            <th>Description</th>
            <th>Operator</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Equal</td>
            <td align='center'>==</td>
        </tr>
        <tr>
            <td>Not equal</td>
            <td align='center'>!=</td>
        </tr>
        <tr>
            <td>Greater than</td>
            <td align='center'>&gt;</td>
        </tr>
        <tr>
            <td>Less than</td>
            <td align='center'>&lt;</td>
        </tr>
        <tr>
            <td>Greater than or equal</td>
            <td align='center'>&gt;=</td>
        </tr>
        <tr>
            <td>Lesser than or equal</td>
            <td align='center'>&lt;=</td>
        </tr>
        <tr>
            <td>Like</td>
            <td align='center'>~</td>
        </tr>
    </tbody>
</table>

Note that mutiple conditions can be combined by using the & and | operator, representing an AND-statement and an OR-statement respectively.

#### Functions

Certain functions are also available through SPECTQL and can be used in the selection statement of a SPECTQL query. Below are some examples and an overview of the available functions.

* http://foo/forests/greenwood{sum(tree\_count), city}:json
* http://foo/forests/greenwood{max(bird\_count)}?city~’a':json


The first example provides a the sum of all of the tree\_count results from the entire greenwoord resource. The second example returns the maximum bird\_count in the greenwoord resource only taken into account records where the city entry contains the letter a.
Note that these functions are grouping functions, they return data based on an aggregation of data. In MySQL for example you pass grouping identifiers along with the group by- statement, in SPECTQL however data is group based on the other identifiers you pass along in the selection statement.

<table>
    <thead>
        <tr>
            <th>Description</th>
            <th>Operator</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Average</td>
            <td>avg</td>
        </tr>
        <tr>
            <td>Count</td>
            <td>count</td>
        </tr>
        <tr>
            <td>Maximum</td>
            <td>max</td>
        </tr>
        <tr>
            <td>Minimum</td>
            <td>min</td>
        </tr>
        <tr>
            <td>Sum</td>
            <td>sum</td>
        </tr>
    </tbody>
</table>


#### Sorting

A data consumer can also ask the data in a sorted way, in MySQL this is done by adding ASC and DESC to the sort-statement. In SPECTQL we integrate this into our selection statement by using + and – to sort ascending and descending respectively.A few examples:

* http://foo//spectql/forests/greenwood{id,tree\_count+}:json
* http://foo//spectql/forests/greenwood{id,bird\_count-}:json


#### Paging

A data consumer can also limit its default amount of entries that are returned. Note that by default data will be paged when a certain treshold (50) is reached. Paging in SPECTQL is implemented by adding a limit-statement to the query. This statement is located behind the where-statement, if present and holds one or two parameters:

    limit(integer [,integer])

When given one integer, the limit function will use that as a maximum amount of rows that may be returned. If however two integers are passed, the first will be seen as the offset, and the second one will be seen as the limit. Note that when paging is used via the datatank, you will get uri’s towards the next and previous page if relevant. These uri’s will appear in the Link HTTP header. An example of a query using the limit statement is provide as follows:

* http://foo//spectql/forests/greenwood{*}.limit(2,5):json

<a id='visualize' class='anchor'></a>
## Visualize data

In addition to our raw format representations of data, we also provide some visualizations of data.

#### Table visualization

In the datatank a visualization is handled just like requesting a data format such as JSON or XML. In practice this means that you can append a <em>.table</em> after the resource of which you want to see a table of. There are however a few side notes to be made. A table is primarily used to display tabular data, however if you request a table on a non-tabular datasource, you’ll also get a table visualization, but fields containing objects will have a string value object.

#### Bar visualization

A bar visualization is a graph representing numeric data. Note that this visualization currently works for tabular data structures! Upon requesting a <em>.bar</em> visualization of a resource you will also have to pass along a bar\_value query string parameter. This parameter tells the bar visualization which datafield has to be displayed. For example if we have a dataset of forests with each entry containing the number of birds, we could ask a bar by creating the uri http://foo/heritage/forests.bar?bar_value=bird\_count. This will give you a bar chart with bars representing the numeric data (bird\_count). Upon hovering over the bars, the number of birds will appear. Note that this is build using javascript, so a javascript enabled browser is necessary. Furthermore, it relies on a SVG library, so for the Internet Explorer users among us, you’ll have to use IE9+.
