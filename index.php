<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="src/css/bootstrap.min.css">
    <script src="src/js/jquery-3.6.1.js"></script>
    <script>
        $(function () {
            $("#cadastro").on("submit", function (e) {
                e.preventDefault();
                $.post("cadastro.php", $("#cadastro").serialize(),
                    function (data) {
                        $("#res").html(data);
                    }
                )
            })
        })
    </script>
    <title>RD Station</title>
</head>
<body>
    <?php
        include_once 'Connection.php';
        $con = new Connection();
        $config = $con->config();


    ?>
<script src="src/js/bootstrap.bundle.min.js"></script>
<script src="src/js/popper.min.js"></script>
<script src="src/js/bootstrap.min.js"></script>
</body>
</html>