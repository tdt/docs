# Introduction

On this page you will learn:

* what The DataTank is
* what it can do for you and what not

## What is The DataTank?

The DataTank is an open source tool that aims at publishing data. These data can be stored in text based files such as CSV, XML and JSON or in binary structures such as SHP and relational databases. The DataTank will read the data in a generic way and publish it on the web to a given URI. It can then provide these data in any format the user wants, no matter what the original datastructure was. Furthermore, it can also semantify your data so that it can be a part of the semantic web. For more inforamtion check out our <a href="http://www.youtube.com/watch?v=3QMpd0BW7bU&amp;feature=youtu.be" target="_blank">movie</a>.

## How does it work?

This section will explain, on a high-level, how The DataTank works, and what the common terms are we used throughout our documentation.

1. Publishing data

    The DataTank publishes data on the web, in a RESTful way. However, in contrast to what many people intuitively suspect, The DataTank doesn't copy nor store your data, nor will it act as if The DataTank owns that data. This means that the owner of the data stays in full control! So how do we publish that data to the web? Well, we ask the users wanting to publish data, to pass along the meta-data necessary to read the data file. This configuration of meta-data is also referred to as a <em>resource-definition</em>. For example if I want to publish a CSV file, I'd have to pass along the uri of where that file is located, and what the delimiter is. There are a few more datatank-specific meta-data pieces to pass along, but that is being covered in the <em><a href="http://thedatatank.com/help/" target="_blank">Publishing data - category</a></em>.

2. Requesting data

    Once you gave The DataTank a resource-definition,it can read the<em> resource </em>and return the data to a data user. The term <em>resource</em> is being used to refer to the resource-definition, as well as to the data it represents. Thus, when a user requests some data, The DataTank will read the file on the fly and return the data. This brings along some concerns when it comes to "large datasets". Large datasets are datasets that can't be fully maintained in memory, or aren't meant to return in one HTTP response. Therefore, paging has been implemented to allow the user to browse through the data, while still getting HTTP responses that don't contain several MB's of data.

    For optimization reasons we also make use of caching. <a href="http://memcached.org/" target="_blank">Memcached</a> is software that allows for scalable caching solutions, and is used in The DataTank to temporarily store requested data.

3. Where to go next

    By now, via the various introduction documentation available you should have a fair knowledge of what The DataTank is all about. You can continue by reading the<a href="http://thedatatank.com/help/installation/"> installation page</a>, which will guide you through installation and configuration of your datatank.