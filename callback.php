<?php

include_once "Connection.php";

$con = new Connection();

if ($GET['code'] ?? '') {
    $auth = $con->auth($_GET["code"]);

    if ($auth["errors"] || !$auth["access_token"]) {
        echo "Erro de Autenticação. Tente Novamente";
    } else {
        $config = $con->config();
        header("Location:" . $config["app"]);
    }
}