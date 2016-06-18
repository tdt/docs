# Input usage

In this section you will learn

* [How to configure a job](#job)
* [How to execute a job](#execute)
* [Overview of jobs](#overview)

<a id='job' class='anchor'></a>
## Configuring a job

When the input package has been installed there will be an extra tab in the admin panel called "Jobs". This panel will list all of the available jobs and allows for updates and deletes. To add a job, simply click on "Add" and fill in the appropriate fields.

Important to note is that you can load data automatically and manually.

If the configured data source changes from time to time, you can configure a scheduler. This scheduler can be configured by selecting a value from the schedule dropdown list.

If your data only changes rarely, you should choose for "once". This way the data will get loaded and when you need to reload the data from the data source, you can trigger it manually through the provided input CLI command.

Alternatively, if your data changes frequently (every week, month) then you'll have to choose an appropriate interval value in the schedule dropdown list.

<a id='execute' class='anchor'></a>
## Execute a job

Whether your job has been configured to run one time or periodically, you can always execute it through the command line.

Laravel comes with a handy tool called [artisan](http://laravel.com/docs/artisan) and allows for a number of framework commands. It also provides the base to create our own [commands](http://laravel.com/docs/commands) and one of these custom commands is the job execution command.

Executing a job is very easy, simply pass along the identifier of the job you want to execute with the input:execute command:

    $ php artisan input:execute foo/bar

Every configured step of the job (extraction, mapping and loading) will provide output to the console, so if you might want to consider piping the execution of the command to a log file. Note that all commands that are run by artisan have a similar interface, use --help for example on any command and you'll get the description of the command accompanied by a list of available options and arguments.
