# Source types

On this page you will learn

* [what different data sources are supported](#source_types)
* [how to create your own source type](#create_source_type)
* [how to create an installed source type](#installed)

Note that this documentation is primarely targetted at developers and will be quite technical.

<a name="source_types"></a>
## Data sources

In previous sections we have mentioned how you can determine which data structures can be published by using our platform. Each type of data structure is abstracted in our platform as a source type. This is modelled in our models folder located in the root of the application.

<pre>
--/models
	SourceType.php
  --/sourcetypes
		CsvDefinition.php
		ShpDefinition.php
		XmlDefinition.php
		...
</pre>

Each of the entries in the sourcetypes folder inherits from the SourceType class located in the models folder. This super class contains a set of functionalities that help the implementation of source types a breeze. Note that a Definition model has a [polymorphic relationship](http://four.laravel.com/docs/eloquent#polymorphic-relations) with a SourceType, since a Definition can have a relationship with either a CSV, SHP etc.

In its turn a class that inherits from SourceType can have a relationship with some meta-data models such as TabularColumns and GeoProperty. The first is to keep track of the column names and aliases, the latter to keep track of which fields represent certain geographical properties.

To get familiar with the concept of inheriting from the SourceType class and how it interacts with its relationship with Definition, you might want to take a look at XML.php. It has a small set of parameters it requires and no meta-data relationships.

Note that it uses a lot of the functions that SourceType provides and adds some validators for its own parameters as well. These validators only need to be declared and will be handled by the super class. If you find yourself in the need of a combined validation when two or more parameters that are passed need to be validated in a certain combination of eachother then you'll have to implement this validation yourself in the validate function. An example of this can be seen in the InstalledDefinition model where we need to validate both the class name and the path of the file where the class is located.

<a name="create_source_type"></a>
## Create your own source type

Once you are familiar with the concepts and functions that need to be present in a SourceType implementation, you can easily create your own. First of all you need to figure out which parameters you need in order to read your data structure. Assuming that a certain data structure foo has 2 parameters foobar, bar and a description we can construct the following class with a few functions.

<pre class="prettyprint">
/**
 * Foo model
 */
class FooDefinition extends SourceType{

    protected $table = 'foodefinitions';

    protected $fillable = array('foobar', 'bar', 'description');

    /**
     * Relationship with the Definition model.
     */
    public function definition(){
        return $this->morphOne('Definition', 'source');
    }

    /**
     * Validate the input for this model
     */
    public static function validate($params){
        return parent::validate($params);
    }

    /**
     * Retrieve the set of create parameters that make up a installed definition.
     */
    public static function getCreateParameters(){
        return array(
            'foobar' => array(
                'required' => true,
                'description' => 'Foo description',
            ),
            'bar' => array(
                'required' => true,
                'description' => 'Foobar description',
            )
        );
    }

    /**
     * Retrieve the set of create parameters that make up a foo definition.
     * Include the parameters that make up relationships with this model.
     */
    public static function getAllParameters(){
        return self::getCreateParameters();
    }

    /**
     * Retrieve the set of validation rules for every create parameter.
     * If the parameters doesn't have any rules, it's not mentioned in the array.
     */
    public static function getCreateValidators(){
        return array(
            'foobar' => 'required',
            'bar' => 'required',
            'description' => 'required',
        );
    }
}
</pre>

If you want to provide relationships with the GeoProperty or TabularColumns model, check out CsvDefinition for it contains the same structure as this FooDefinition, but has additional function calls for those specific relationships.

After this you might want to update your class loader so this class is recognized:

	$ root > php artisan dump-autoload

If you head down to the discovery document, you'll see that your Foo is now picked up as a source type that can be added. There's one essential step left in order to make this work though and that is the configuration of our database table that holds our parameters for our Foo model.

We've defined a protected property `$table` which tells the Eloquent ORM of Laravel that the database table used by this model is called `foodefinitions`. In order to create and configure this table, and perhaps later adjust, you'll need to use a [migration](http://four.laravel.com/docs/migrations) of the application's back-end.

We will skip on the specifics of how to create your migration, but checkout our database/migrations folder in the root of the application for a wide variety of examples as well as the previously linked webpage that explains [Laravel migrations](http://four.laravel.com/docs/migrations). On an abstract level the migration process will come down to this:

	$ php artisan migrate:make foo_definitions_model

This creates a unique migration file for you in the database/migrations folder. Fill in the necessary functionalities to create/alter your foodefinitions table followed by the following command:

	$ php artisan migrate

After this you can perform any type of methods that are listed for other source types in our application on your own source type.


<a name="installed"></a>
## Installed resource

The datatank's functionality has so far always been focussed on publishing data from datasets, however this is not the only way to publish data. We also allow a custom build class to return data, instead of this data being read from a certain data file in a generic way. This concept is named an "installed resource". To place this in the big picture let's do a small recap.

We have a Definition, which contains a unique uri to identify a certain set of parameters that enable the extraction and publication of data. This Definition, under the hood, contains a relationship with a SourceType instance, for example CSVDefinition. This CSVDefinition then reads data from a given CSV file and returns this.

The level of an installed resource, is the level of a CSV file, which is identified by the InstalledDefinition which takes a path and a class name as meta-data parameters.
Just like the CSV file, the installed resource returns data, all be it by executing PHP functionality.

### Creating an installed resource

The creation of an installed resource is fairly simple and for your ease, we have some [examples ready to be used](https://github.com/tdt/installed-example). We have chosen not to provide an abstract class for this. The reason therefore is the same reason Eloquent doesn't need to know wich data properties your database table has, it just assumes that you're doing everything ok.

So let's make sure you know what our definition of "ok" is. Open up your favorite editor and copy our example(s) of installed resources in it. You'll see a minimal set of functionalities in our Stock (for example) class. This set of functions is <b>required</b> to be present in your class! That's the only thing we'll be needing from you, if you want to publish data using your own scraper/webservice proxy/... .

When you are finished building your class that, in our Stock example, returns Stock data you'll need to put it in our installed folder located in the root of the application. Then you can add an installed definition like you add any other type of definition using our API (explained by the discovery document).

<pre class="prettyprint">
installed: {
	description: "Create a definition that allows for publication of data inside a Installed datastructure.",
	parameters: {
		...

		description: {
			required: true,
			description: "The descriptive or informational string that provides some context for you published dataset."
		},

		...
		class: {
			required: true,
			description: "The name of the class"
		},
		path: {
			required: true,
			description: "The location of the class file, relative from the "/installed" folder."
		}
	}
}
</pre>

The path description also indicates that you have to put your class inside the installed folder of our application.

An example PHP script that adds an installed resource could be the following assuming that our class is located in the installed folder under path: installed-examples/Stock.php.

<pre class="prettyprint linenums">
// Initiate the curl request
$ch = curl_init();

// Define our definition uri
$url = "http://foo/definitions/foo/Stock";

// Construct the meta-data properties
$put = array(
    "description" => "Data retrieved from the stock webservice.",
    "path" => "installed-examples/Stock.php",
    "class" => "Stock",
);

// Create the general configurations for the curl request
$options = array(
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_URL => $url,
    CURLOPT_HTTPAUTH => CURLAUTH_ANY,
    CURLOPT_USERPWD => "foo" . ":" . "bar",
    CURLOPT_FRESH_CONNECT => 1,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_FORBID_REUSE => 1,
    CURLOPT_TIMEOUT => 4,
    CURLOPT_POSTFIELDS => http_build_query($put),
    CURLOPT_HTTPHEADER => array("Content-Type: application/tdt.installed"),
);

// Set the configuration of the curl request
curl_setopt_array($ch, $options);

$response = curl_exec($ch);
</pre>
