# Management

On this page you will learn:

* [General info on artisan](#artisan)
* [The datatank management cli](#cli)

<a id="artisan" class="anchor"></a>
## General info on Laravel's CLI

[Artisan](http://laravel.com/docs/artisan) is the name of the command-line interface included with Laravel. It provides a number of helpful commands to use while developing your application. It is driven by the powerful Symfony Console component.

All of the commands that are written for the datatank are using this (super) handy component of Laravel. To get a full list of possible commands perform the following command:

    $ php artisan --list


Every command that builds on artisan, by default, has a --help option. This allows you to ask a description of any command available in the application.


<a id="artisan" class="anchor"></a>
## Datatank CLI management

For general datatank management it's often useful to use commands instead of doing everything through the user interface.

These commands are meant to help datatank maintainers save time on key aspects in a general workflow. One of these workflows is to copy a configuration of a datatank in development or staging to a live one.

Currently we provide the command to export and import the published resources and the created users with their corresponding permissions.

### Export

By performing the command

    $ php artisan --list

We see that there is a listing of datatank commands:

    datatank
      datatank:export        Export functionality for the datatank configuration. By default it exports all of the users and definitions in JSON.
      datatank:import        Import functionality for a datatank configuration, can import users and resources passed in a JSON file.

Let's find out some more about the export command by performing:

    $ php artisan datatank:export --help

We then get the following output:

<pre class="prettyprint linenums">
Usage:
 datatank:export [-d|--definitions] [-u|--users] [-f|--file[="..."]] [identifier]

Arguments:
 identifier            If you specify the option -d, you can export a single definition by specifying the indentifier of that definition (e.g. csv/cities)

Options:
 --definitions (-d)    Only export the definitions, if you specify an identifier only that definition will be exported.
 --users (-u)          Only export the users.
 --file (-f)           Write the export data to a file.
</pre>

This tells us that we will have an output of all of the users and definitions. We can also opt to choose for one of the two using options, or a specific resource using the identifier of the resource. Ultimately you can choose to pass along a file to which the JSON output will be written.

Let's use the most basic command we can perform and pipe it to a file:

    $ php artisan datatank:export > export_all.json

This JSON file contains all of our users and definitions of our datatank instance and can be used as an input for the import command.

The help info of the datatank:import command tells us it takes only 1 argument namely the path to the file that contains the configuration it needs to import. An example can look as the following:

    $ php artisan datatank:import export_all.json

Note that when you add users that already exist in the datatatank, they will be ignored! This is not the same as when existing definitions are imported. They get overridden since definitions are following the HTTP specification, namely a PUT is an update or a creation of a resource, whereas importing users is merely an injection action of users to the datatank configuration.