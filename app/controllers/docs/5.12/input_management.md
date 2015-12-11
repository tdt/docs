# Input management

On this page you will learn:

* [Input CLI](#cli)

<a id="cli" class="anchor"></a>
## Input CLI

Just like the main application of the datatank, the input package provides in some useful management CLI tools as well. Next to the command to execute jobs, we also provide in an export and import of job configurations and these should be listed as well in the artisan list when the input package is properly installed or referenced via the workbench.

    input
      input:execute          Execute a job
      input:export           Export job definitions to a JSON file.
      input:import           Import job definitions from a JSON file.

If we ask some more information about this command by:

    $ php artisan input:export --help

then we get the following output:

    Usage:
      input:export [-f|--file[="..."]] [jobid]

    Arguments:
      jobid                 The identifier of the job to export, if empty all of the jobs will be exported.

    Options:
      --file (-f)           The file to write the JSON export to.

By default it prints out the JSON to the console which makes it able to pipe it to a file of your choosing.

The JSON output that is produced by the export command can then be used to import all of the exported job definitions into the datatank by the following command:

    $ php artisan input:import
