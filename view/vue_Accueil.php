<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../jQuery/jquery.min.js"></script>
    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Document</title>
</head>
<body>
    <?php include_once "header.php";
    include_once "../model/DBO.php";
        $test = new DBO("my_meetic",'127.0.0.1', 'root', '080176');
        $test->connect();
        var_dump($test->query());
    include_once "footer.php";
    ?>
</body>
</html>