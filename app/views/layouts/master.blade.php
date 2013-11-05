<html>
<head>
    <link href="<?php echo \Request::root() . '/assets/css/bootstrap.min.css'; ?>" rel="stylesheet" media="screen">
</head>
<body>

    <div class="container">
        <div class="row">
            <h1>The DataTank documentation</h1>
            <div class="col-md-2">
                {{ $sidebar }}
            </div>

            <div class="col-md-1">
            </div>

            <div class="col-md-9">
                {{ $content }}
            </div>
        </div>
    </div>
</body>
</html>