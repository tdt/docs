# Introduction

On this page you will learn

* [What The DataTank is](#what)
* [How it works](#how)

<a id="what"></a>
## What is The DataTank?

The DataTank is an open source tool that publishes data. These data can be stored in text based files such as CSV, XML and JSON or in binary structures such as SHP files and relational databases. The DataTank will read the data out of these structures and publish them on the web using a given URI. It can then provide these data in any format a user wants, no matter what the original datastructure was. Furthermore, it can also semantify your data so that it can be a part of the semantic web.

The documentation that you can find in the sidebar is relevant for the [input](https://github.com/tdt/input) and [core](https://github.com/tdt/core) repository marked by version 4.0.

<a id="how"></a>
## How does it work?

1. Publishing data

    The DataTank publishes data on the web in a RESTful way. However, in contrast to what many people intuitively suspect, The DataTank doesn't copy nor store your data, nor will it act as if The DataTank owns that data. This means that the owner of the data stays in full control! So how do we publish that data to the web? Well, we ask the users that want to publish data, to pass along the meta-data necessary to read data from the data structure.

    For example if I want to publish a CSV file, I'd have to pass along the uri of where that file is located, and what character is used to delimit the values in order to have a basic set of information that allow extraction out of the file.

2. Requesting data

    By providing enough information to read data we can extract the data and provide it to the user. When a user requests some data, The DataTank will read the data structure on the fly and return the data in the requested format (e.g. JSON, XML, PHP, ..).

    This concept of proxying data brings along some concerns when it comes to "large datasets". Large datasets are datasets that can't be fully maintained in memory, or aren't meant to return in one HTTP response. Therefore, paging has been implemented to allow the user to browse through the data, while still getting manageable HTTP responses.

    Next to data serialized into a certain format, we also provide visualizations of data sets. If you have a dataset with geographical properties, you can provide this information to The DataTank, allowing it to extract those geographical properties and displaying your data on a map.


In short, if you have for example a CSV file with locations of parking lots, you can display them on a map with few clicks using our platform, and provide a JSON, XML, ... feed to end-users at the same time!
