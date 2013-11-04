<html>
<head>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
</head>
<body>

    <div class="container">

        <div class="navbar navbar-default">
            <a class="navbar-brand" href="#">The DataTank</a>
        </div>
        <div class="row">
            <h1>The DataTank documentation</h1>
            <div class="col-md-3">
                {{ $sidebar }}
            </div>

            <div class="col-md-9">
                {{ $content }}
            </div>
        </div>
    </div>
</body>
</html>