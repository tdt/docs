# Management

On this page you will learn:

* [General info on artisan](#artisan)
* [The datatank management cli](#cli)

<a id="artisan" class="anchor"></a>
## General info on Laravel's CLI

[Artisan](http://laravel.com/docs/artisan) is the name of the command-line interface included with Laravel. It provides a number of helpful commands to use while developing your application. It is driven by the powerful Symfony Console component.

All of the commands that are written for the datatank are using this (super) handy component of Laravel. To get a full list of possible commands perform the following command:

    $ php artisan --list


Every command that builds on artisan also, by default, has a --help option. This allows you to ask for a description of any command available in the application.


<a id="artisan" class="anchor"></a>
## Datatank CLI management

For general datatank management it's often useful to use commands instead of doing everything through the user interface.

These commands are meant to help datatank maintainers save time on key aspects in a general workflow. One of these workflows is to copy a configuration of a datatank in development or staging to a live one.

Currently we provide the command to export and import the published resources and the created users with their corresponding permissions.

### Export

By performing the command

    $ php artisan --list

We see that there is a listing of datatank commands:

    // TODO

    $ php artisan core:export --help

<pre class="prettyprint linenums">
Usage:
core:export [-u|--users] [-f|--file[="..."]]

Options:
 --users (-u)          Export the users, if this option is not given the command will export the definitions.
 --file (-f)           Write the export data to this file. Default value is the file definition_export.json located in the app/commands folder.
</pre>