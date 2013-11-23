<!DOCTYPE html>
<html lang='en'>
    <head profile="http://dublincore.org/documents/dcq-html/">
        <title>The DataTank documentation</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="DC.title" content="The DataTank documentation"/>

        <link rel='stylesheet' href='{{ URL::to("css/style.css") }}' type='text/css'/>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="//google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
    </head>

    <body>
        <nav class="navbar navbar-fixed-top">
            <a class="navbar-brand" href="{{ URL::to('') }} ">
                <img src='{{ URL::to("img/logo.png") }}' alt='Datatank logo' />
                <h1>The DataTank {{ $version }} documentation</h1>
            </a>
        </nav>

        <div id='sidebar-background' class='hidden-xs hidden-sm'></div>

        <div class="wrapper">
            <div class='row'>
                <div id='sidebar' class='col-md-2'>
                    {{ $sidebar }}
                </div>
                <div id='content' class='col-md-10'>
                    {{ $content }}
                </div>
            </div>

            <div class='push'></div>
        </div>

        <footer>
            <div class="col-lg-12">
                The DataTank &middot; <a href="//thedatatank.com/" target="_blank">Visit our website</a>
            </div>
        </footer>
    </body>
</html>