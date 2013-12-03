# Installed resources

The datatank's functionality so far has always been focussed on publishing data from datasets, however this is not the only way to publish data. We also allow a custom class to return data, instead of this data being read from a certain data file in a generic way. This concept is named an "installed resource". To place this in the big picture let's do a small recap.

We have a Definition, which contains a unique uri to identify a certain set of parameters that enable the extraction and publication of data. This Definition, under the hood, contains a relationship with a SourceType instance, for example CSVDefinition. This CSVDefinition contains parameters that allow data extraction from a given CSV file.

The level of an installed resource, is the level of a CSV file, which is identified by the InstalledDefinition which takes a path and a class name as meta-data parameters.
Just like the CSV file, the installed resource returns data, all be it by executing PHP functionality instead of holding actual comma-separated-values.

## Creating an installed resource

The creation of an installed resource is fairly simple and for your ease, we have some [examples ready to be used](https://github.com/tdt/installed-example). We have chosen not to provide an abstract class for this. The reason therefore is the same reason Eloquent doesn't need to know wich data properties your database table has, it just assumes that you're doing everything ok.

So let's make sure you know what our definition of "ok" is. Open up your favorite editor and copy our [example(s) of installed resources](https://github.com/tdt/installed-example) in it. You'll see a minimal set of functionalities in our Stock (for example) class. This set of functions is <b>required</b> to be present in your class! That's the only thing we'll be needing from you, if you want to publish data using your own scraper/webservice proxy/... through The DataTank.

When you are finished building your class that, in our Stock example, returns Stock data you'll need to put it in our installed folder located in the root of the application. Then you can add an installed definition like you add any other type of definition using our API (explained by the discovery document) or by using our user interface.

Example of a snippet of our discovery document concerning installed resources:
<pre class="prettyprint linenums">
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

> <i class='fa fa-lg fa-exclamation-circle'></i> The path description indicates that you have to put your class inside the installed folder of our application.

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
    CURLOPT_POSTFIELDS => json_encode($put),
    CURLOPT_HTTPHEADER => array("Content-Type: application/tdt.installed"),
);

// Set the configuration of the curl request
curl_setopt_array($ch, $options);

$response = curl_exec($ch);
</pre>
