# Updating

On this page we'll talk about some topics you'll need to take into consideration when updating your datatank (e.g. after a git pull, or new version):

* [Migrations](#migrations)
* [Seeding](#seeding)
* [Export/Import](#export)

<a class="anchor" id="migrations"></a>
## Migrations

In order to make sure you've migrated your back-end to the latest version, perform the following command:

    $ php artisan migrate

This may have to be done manually when you add the --no-scripts option when updating through Git. In the same way you can update the back-end for a package, e.g. tdt/input:

    $ php artisan migrate --package=tdt/input

<a class="anchor" id="seeding"></a>
## Seeding

In contrast to migrations, seeding is not performed when updating your datatank, because a maintainer might have added his own licenses, ontology prefixes and languages. To (re)seed these meta-data properties perform the following command:

    $ php artisan db:seed --class=OntologyPrefixSeeder
    $ php artisan db:seed --class=DcatSeeder

<a class="anchor" id="export"></a>
## Export & Import

If you want to make sure you maintain your configuration between updates, perhaps because you might be considering a migrate reset or rollback which might throw away content in the database, perform the export command to export your configuration followed by the import command to import it. More details about this workflow can be found on [management page](/4.1/management).