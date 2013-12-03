# Source types

On this page you will learn

* [What different data sources are supported](#source_types)
* [How to create your own source type](#create_source_type)

Note that this documentation is primarely targets technical people.

<a id='source_types' class='anchor'></a>
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

<a id='create_source_type' class='anchor'></a>
## Create your own source type


> <i class='fa fa-2x fa-warning'></i> Only create a source type if you're sure you need one. If you want to publish data through custom extraction (e.g. a scraper) first consider making an installed resource before creating a source type, the level of difficulty to get started is much lower and you can create seperate repositories for them.


Once you are familiar with the concepts and functions that need to be present in a SourceType implementation, you can easily create your own. First of all you need to figure out which parameters you need in order to read your data structure. Assuming that a certain data structure foo has 2 parameters foobar, bar and a description we can construct the following class with a few functions.

<pre class="prettyprint linenums">
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