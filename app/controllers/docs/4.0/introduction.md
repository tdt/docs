# Introduction

On this page you will learn

* [what The DataTank is](#what)
* [how it works](#how)

<a name="what"></a>
## What is The DataTank?

The DataTank is an open source tool that aims at publishing data. These data can be stored in text based files such as CSV, XML and JSON or in binary structures such as SHP and relational databases. The DataTank will read the data in a generic way and publish it on the web to a given URI. It can then provide these data in any format the user wants, no matter what the original datastructure was. Furthermore, it can also semantify your data so that it can be a part of the semantic web.

The DataTank, starting from version 4.0, is built in Laravel 4.

Check out our video below for more information.

<iframe width="560" height="315" src="//www.youtube.com/embed/3QMpd0BW7bU" frameborder="0" allowfullscreen></iframe>

<a name="how"></a>
## How does it work?

This section will explain, on a high-level, how The DataTank works, and what the common terms are we used throughout our documentation.
After watching the movie above, this section should be quite easy to follow, so let's get started!

1. Publishing data

    The DataTank publishes data on the web, in a RESTful way. However, in contrast to what many people intuitively suspect, The DataTank doesn't copy nor store your data, nor will it act as if The DataTank owns that data. This means that the owner of the data stays in full control! So how do we publish that data to the web? Well, we ask the users wanting to publish data, to pass along the meta-data necessary to read from the data structure. This configuration of meta-data, accompanied by other meta-data that is relevant to the dataset such as a publisher, a description, a title,... is also referred to as a <em>resource-definition</em>. For example if I want to publish a CSV file, I'd have to pass along the uri of where that file is located, and what character is used to delimit the values. Each data structure has its own set of necessary meta-data it needs to be read, more information about what these are exactly will be explained in a next chapter.

2. Requesting data

    Once you gave The DataTank a resource-definition, it can read the<em> resource </em>and return the data to a data user in a certain representation format. Note that the term <em>resource</em> is being used to refer to the resource-definition, as well as to the data it represents. Thus, when a user requests some data, The DataTank will read the file on the fly and return the data.

    This concept of proxying data brings along some concerns when it comes to "large datasets". Large datasets are datasets that can't be fully maintained in memory, or aren't meant to return in one HTTP response. Therefore, paging has been implemented to allow the user to browse through the data, while still getting HTTP responses that don't contain several MB's of data.

    For optimization reasons we also make use of caching.