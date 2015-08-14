# Configuration

On this page you will learn how to configure:

* [A production environment](#production)
* [Caching](#caching)
* [A development environment](#development)
* [Unit testing](#unittesting)

The configuration is entirely handled by the Laravel framework, if you encounter things that aren't covered on this page, visit the [Laravel configuration documentation](http://laravel.com/docs/4.2/configuration) or if that doesn't help you out, get in touch with us via e-mail or [github](https://github.com/tdt).

> Ideally, you don't change any files in the app/config directory, but rather copy them into a folder you create under app/config and then edit as you see fit. This allows for proper configuration management and will make your overall configuration flow alot easier. For more info on this, check out the [configuration documentation](http://four.laravel.com/docs/configuration).

The sections below are a summary of what the important parts of the configuration are.

<a id='production' class='anchor'></a>
## Production environment

For production purposes, there's little configuration necessary. The only thing you have to do is head down the config folder located relatively to the root of the application at <em>app/config</em>.

In this folder you'll find a set of php files and folders that make up one or more configurations. The one that has to be changed is called <em>database.php</em>

If you have a MySQL database (recommended), you'll have to set the default to <em>mysql</em> and fill in the mysql entry in the connections array in the <em>database.php</em> file. There's no need to throw away the other connection options or change anything else. This should make your database.php file look something like the following. Note that the comments that are present from a default Laravel installation have been deleted for the sake of simplicity.

<pre class='prettyprint'>
return array(

    'fetch' => PDO::FETCH_CLASS,

    'default' => 'mysql',

    'connections' => array(

        'sqlite' => array(
            'driver'   => 'sqlite',
            'database' => __DIR__.'/../database/production.sqlite',
            'prefix'   => '',
        ),

        'mysql' => array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'datatank_db',
            'username'  => 'foo',
            'password'  => 'bar',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),

        'pgsql' => array(
            'driver'   => 'pgsql',
            'host'     => 'localhost',
            'database' => 'database',
            'username' => 'root',
            'password' => '',
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ),

        'sqlsrv' => array(
            'driver'   => 'sqlsrv',
            'host'     => 'localhost',
            'database' => 'database',
            'username' => 'root',
            'password' => '',
            'prefix'   => '',
        ),

    ),
    ...
</pre>

That's all there is to it!

<a id='caching' class='anchor'></a>
## Caching

The data request made to The DataTank are cached using the [Laravel caching mechanism](http://four.laravel.com/docs/cache). By default requests are cached for 1 minute, if you want to change the caching period simply change the configuration in the <em>app/config/cache.php</em> file.

<a id='development' class='anchor'></a>
## Development environment

If you're planning on getting your hands dirty with The DataTank, you'll need to read up on how to configure environments in the [Laravel configuration documentation](http://four.laravel.com/docs/configuration#environment-configuration). In short, in order to load your database for development (e.g. localhost) only, you need to create a folder called <em>local</em> in the <em>app/config</em> folder, and make sure the environment is recognized by Laravel. This is done by adding your host name to the <em>$env</em> variable in the <em>bootstrap/start.php</em> file. Don't forget to add this file to the .gitignore file.

<a id='unittesting' class='anchor'></a>
## Unit testing

If you want to run the unittests, to check if everything is still ok after adjustments or to test your own additional tests, go to the root of the application and perform the simple command:

    $ phpunit

This will execute all of the tests located at the <em>app/tests</em> folder.

If you've never performed the unit tests before, you will probably stumble upon a large series of errors. This is because the testing environment hasn't been configured yet. It is however fairly simple to do such a thing, so bare with us!

First you'll need to create a database table that will be used by the unit tests. This can be configured in the <em>database.php</em> file inside the <em>app/config/testing</em> folder. Next you'll want to create the necessary tables in order to create a similar back-end as the application uses, in order to do this you'll need to perform the migration command, but with the testing environment as a parameter.

    $ php artisan migrate --env=testing

Next up, you'll have to migrate the extra package that we use for authentication purposes as well:

    $ php artisan migrate --env=testing --package=cartalyst/sentry

After that, fill up the database with some basic users using our seeder:

    $ php artisan db:seed --env=testing

That's it! You can perform the phpunit command now.
