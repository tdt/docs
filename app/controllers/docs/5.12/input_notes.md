# Notes

On this page we'll elaborate on some notes to be made with the ETL module.

* [ElasticSearch](#elastic)
* [MongoDB](#mongodb)

<a id='elastic' class='anchor'></a>
## ElasticSearch

One of the possible loaders to load data into as part of the ETL is ElasticSearch. The ElasticSearch version that we have tested our software with is 1.7.2. We can only recommend using the same (or compatible versions) when using it through either our ETL module or as a dataset. (you can also configure an ElasticSearch endpoint to serve as a dataset)

Important to note is that you want to use one ElasticSearch type per dataset! The ElasticSearch loader is programmed so that it will override all of the data of a certain type in a certain index with new data when a job is triggered.

To close this paragraph ElasticSearch doesn't come with a standard authentication layer, for 1.7.2 you can use this [open source](https://github.com/Asquera/elasticsearch-http-basic) project to facilitate basic auth on top of your ElasticSearch instance. The authentication that is provided with the configuration of an ElasticSearch dataset handles over HTTP auth.

<a id='mongodb' class='anchor'></a>
## MongoDB

The MongoDB loader can also be used to store data into. This loader has been tested with version 2.6 of MongoDB.