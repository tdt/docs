# User interface - Managing datasets

The user interface of The DataTank is designed to make the admin's job a bit easier.

In the sections below we'll explain

* [Managing datasets](#manage)

<a id="manage"></a>
## Datasets

If you log into the user interface using the URI api/admin, you'll be redirected to the datasets view of the user interface. This view lists the available data sets published in The DataTank and provides in a set of functionalities to manage them.

In short, the view provides the following:

* [Adding a new definition](#adding_def)
* [Deleting a definition](#deleting_def)
* [Updating a definition](#updating_def)
* [Viewing a definition](#viewing_def)
* [Viewing the data a definition describes](#viewing_data)

<a id="adding_def"></a>
### Adding a new definition

To add a new definition, click the "+Add" button next to the search box in the top right section of the view. This will link the user to a tab-view, each tab representing a supported source type the datatank can extract data from. Click the tab that corresponds with the data type you want to publish and fill out the corresponding form. Important to note is that the required parameters must all be filled in in order for the addition to work. Optional parameters allow you to further define some extra parameters and sometimes contain default values. Make sure to adjust these if they differ from your data source configuration (e.g. a ; instead of a , as a delimiter in a CSV file). If you're ready filling out the necessary parameters, click the "+Add" button on the top right section to perform the request. If this is successful the user will be redirected to the list of definitions in which the new definition will stand, if something went wrong a message will be displayed with an explanation of what went wrong.

<a id="deleting_def"></a>
### Deleting a definition

To delete an existing definition, simply click the "X" button in the row that displays the definition's identifier. This will delete the entire definition, and the identifier that was used will become available again.

<a id="updating_def"></a>
### Updating a definition

To update a definition, for example to update the description of a published dataset, simple click the row that displays the definition's identifier. This will link the user to a view that lists the parameters that make up the definition. Here you can adjust certain values and update them by clicking the "Save" button in the top right section of the view.

<a id="viewing_def"></a>
### Viewing a definition

In order to view a full definition, click the "Definition" button in the row that displays the identifier of the definition. This will provide you with a JSON document that consists of all the parameters a definition has.

<a id="viewing_data"></a>
### Viewing data

To view the data that the description describes, simply click the "data" button on the row the displays the identifier. This will link the user to a view appropriate for the type of dataset. For example a published SHP file will always be displayed by default on a map, a CSV file will be displayed in a tabular manner, and so forth. The default serialization is JSON for raw data and [Turtle](http://www.w3.org/TR/2012/WD-turtle-20120710/) for semantic data.