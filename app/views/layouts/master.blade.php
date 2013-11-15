<html>
<head>
    <title>The DataTank documentation</title>
    <link href="<?php echo \Request::root() . '/assets/css/bootstrap.min.css'; ?>" rel="stylesheet" media="screen">
    <link href="<?php echo \Request::root() . '/assets/css/docs.css'; ?>" rel="stylesheet" media="screen">
    <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-11 col-md-offset-1">
                <header>
                    <h1>The DataTank documentation</h1>
                </header>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-2 col-md-offset-1">
                {{ $sidebar }}
            </div>

            <div class="col-md-8 col-md-offset-1">
                {{ $content }}
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

</body>
</html>
