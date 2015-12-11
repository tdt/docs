# Errors

* [HTTP Status Code Summary](#httpcodes)
* [The error object](#object)


The DataTank uses HTTP response codes to indicate success or failure of a request. In general, codes in the 2xx range indicate success, codes in the 4xx range indicate an error that resulted from the provided information (e.g. a required parameter was missing), and codes in the 5xx range indicate an error with our servers or a bug.

## HTTP Status Code Summary
<a id='httpcodes' class='anchor'></a>

* **200 OK** - Everything worked as expected.
* **400 Bad Request** - Forgot to pass a certain parameter?.
* **401 Unauthorized** - No valid authentication has been provided..
* **403 Forbidden** - The authenticated user has no permissions for a certain action.
* **404 Not Found** - The requested URI doesn't exist.
* **405 Method Not Allowed** -  A request was made using a request method not supported by that resource.
* **406 Not Acceptable** - The requested resource is only capable of generating content not acceptable according to the Accept headers sent in the request.
* **500, 502, 503, 504 Server errors** - something went wrong on the DataTank's end.

## The error object
<a id='object' class='anchor'></a>


<pre class="prettyprint linenums">
{
   "error":{
      "type":"invalid_request_error",
      "message":"The dataset or collection you were looking for could not be found (URI: non-existing)."
   }
}
</pre>

The error object has a couple of attributes:

* **type** The type of error returned. Can be `invalid_request_error` or `api_error`.
* **message** A human-readable message of the error.