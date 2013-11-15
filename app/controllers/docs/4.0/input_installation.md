# Input installation

The installation is fairly simple and can be done by telling the core application that tdt/input is now a required package. This can be done by updating the require section of the composer.json file, located in your root application folder.

Note that the commands listed are assumed to be executed from the root folder of the datatank application.

<pre class="prettyprint">
"require": {
    ...,
    "tdt/input" : "dev-master"
}
</pre>

After the composer.json changed, you need to let composer know that a new dependency has been added. The following command will download the input package:

    $ composer update

The next thing you need to do is to create the datatables necessary for input to store its information. This can be done by executing the following command:

	$ php artisan migrate --package=tdt/input

## Developping input

If you are developing on the input package, you'll need to know the [Laravel package development basics](http://four.laravel.com/docs/packages).
This means that you don't need to include it in your composer.json file but rather include in your Laravel workbench. In a practical manner this comes down to the following set of commands:

	$ mkdir workbench
	$ cd workbench
	$ git clone git@github.com:tdt/input.git

In order to migrate the workbench package (given that the directory in which input is cloned into is called input), execute the following command:

	$ php artisan migrate --bench=input

Creating a migration goes down the same way:

	$ php artisan migrate:make --bench=input

Do note that you need to use the artisan autoload generator, and not the composer one if you're working with the workbench:

	$ php artisan dump-autoload
