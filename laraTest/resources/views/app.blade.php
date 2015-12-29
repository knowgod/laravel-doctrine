<!doctype html>

<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

    <style type="text/css">
        .action-container li,
        .tag-cloud li {
            list-style-type: none;
            display: inline-block;
            margin-right: 10px;
        }

        .tag-list {
            margin-right: 20px;
        }
    </style>
</head>

<body>

<div class="container">
    @yield('content')
</div>

<div class="footer">
    @yield('footer')
</div>

</body>
</html>