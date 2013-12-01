# Publishing data

On this page you will learn

* [how to publish data](#publish)

There are 2 packages in our framework providing Info and Admin resources.
The first one is a public accessible package in which information is shown about the resources published through the datatank.
Next to that we have an Admin package which handles GET, PUT, DELETE requests. This package holds resources to which new resource definitions can be PUT or DELETEd and full definitions can be GET. This package holds a very important resource, tdtadmin/resources, that forms the entry point through which new resources can be published.

<a id='publish'></a>
## tdtadmin/resources

The most important resource in our framework is called tdtadmin/resources. This resource holds a list of resource definitions that allow data to be read and published to the web. In order to know which meta-data to pass to create a resource definition, you'll have to check out our tdtinfo/admin document. This document holds the information about which meta-data needs to be passed for which data source type you want to publish. On this page we'll provide some examples that should get you started at publishing data.

The DataTank is a web based framework, you can communicate with it through RESTful HTTP requests. To make things easy, you can install a REST based user interface in your browser. Chrome, for example has a plug-in called RESTConsole, Mozilla Firefox has a plug-in called RESTClient, etc. If you feel like getting your hands dirty, you can also use cURL to set up HTTP requests in code, or through the command line. F

### Gathering information

The DataTank publishes data and in order to do this it needs some information depending on which source type you want to publish. For example, a CSV file is located on a certain URI and uses a certain delimiter. A MySQL table is located in a certain database, on a certain host, etc. These parameters that make up the information that is needed to pbulish data, is documented on the resource tdtinfo/admin (e.g. http://foo/tdtinfo/admin).

In the next sections we're going to publish a CSV file, which should provide enough information to auto-detect which types of data that can be published and how to publish those data.

1. Auto-detect necessary parameters

    As stated above, the necessary parameters that make up a resource definition are listed in the tdtinfo/admin document. We're going to publish a CSV file, so the parameters we need are listed in the <em>create</em> section of the document because we're going to <em>create</em> a new resource definition. The entire path to look for a CSV definition model is tdtinfo/admin/create/generic/csv.

    Note that not every parameter is required, this is marked by using a <em>parameters</em> section (optional parameters) and <em>required parameters</em> section.

2. Fill in the template

    Now that we know which parameters a resource definition to publish a CSV file takes, it's time to provide them with the proper values. For a CSV file this will be the URI (e.g. http://bar/foo.csv) and a description of what data is in the CSV file itself. Optional parameters are for example the delimiter of the CSV file, if none is passed a default value will be used.

3. Make the request

    We're nearly there, for we have our set of parameters that make up our resource definition, and we know to which URI we have make our call (tdtadmin/resources)

    Now the next thing we have to decide is to which URI we want to publish our data, assuming that our CSV file contains data about pollution in europe, we can opt to publish this under a URI europe/pollution.

    This information together with the set of parameters allows us to create the following request, given that tdtadmin (user) and admin (password) are the credentials for a user that has permissions to create new resource definitions:

<pre class='prettyprint'>
    curl -v -d '{"documentation" : "Pollution data concerning Europe", "URI" : "http://stats.eu/pollution.csv", "delimiter" : ";" , "source_type" : "generic/CSV"}' -XPUT http://tdtadmin:admin@foo/tdtadmin/resources/europe/pollution
</pre>


If everything went well you should get a 200 OK response, with a Location header pointing to the published data from your CSV file. For other types of data, take a similar approach as we did in the above section.