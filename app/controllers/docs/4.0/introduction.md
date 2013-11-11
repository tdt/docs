# Introduction

On this page you will learn

* [what The DataTank is](#what)
* [how it works](#how)

<a name="what"></a>
## What is The DataTank?

The DataTank is an open source tool that aims at publishing data. These data can be stored in text based files such as CSV, XML and JSON or in binary structures such as SHP files and relational databases. The DataTank will read the data out of these structures and publish them on the web using a given URI. It can then provide these data in any format a user wants, no matter what the original datastructure was. Furthermore, it can also semantify your data so that it can be a part of the semantic web.

This documentation version of The DataTank is relevant for the input and core repository marked by version 4.0.

The video below shows you some more information about what the general principles and functionalities are of The DataTank and are summarized in the last section of this page.

<iframe width="560" height="315" src="//www.youtube.com/embed/3QMpd0BW7bU" frameborder="0" allowfullscreen></iframe>

<a name="how"></a>
## How does it work?

This section will explain, on a high-level, how The DataTank works, and what the common terms are we used throughout our documentation.
After watching the movie above, this section should be quite easy to follow, so let's get started!

1. Publishing data

    The DataTank publishes data on the web, in a RESTful way. However, in contrast to what many people intuitively suspect, The DataTank doesn't copy nor store your data, nor will it act as if The DataTank owns that data. This means that the owner of the data stays in full control! So how do we publish that data to the web? Well, we ask the users wanting to publish data, to pass along the meta-data necessary to read from the data structure. This configuration of meta-data, accompanied by other meta-data that is relevant to the dataset such as a publisher, a description, a title,etc. is also referred to as a <b>resource-definition</b> or <b>definition</b>. For example if I want to publish a CSV file, I'd have to pass along the uri of where that file is located, and what character is used to delimit the values in order to have a basic set of information that allow extraction out of the file. Each data structure has its own set of meta-data in order to be interfaced with, more information about what these are exactly will be explained in a next chapter.

2. Requesting data

    The definition you have published represents a set of meta-data, the actual data that is published is called a <b>resource</b>. When a user requests some data, The DataTank will read the file on the fly and return the data in the requested format.

    This concept of proxying data brings along some concerns when it comes to "large datasets". Large datasets are datasets that can't be fully maintained in memory, or aren't meant to return in one HTTP response. Therefore, paging has been implemented to allow the user to browse through the data, while still getting manageable HTTP responses.
