<?php

include_once "Connection.php";

$con = new Connection();

if (isset($_GET['code'])) {
    $auth = $con->auth($_GET["code"]);
    var_dump($auth["errors"]);die;
    if ($auth["errors"] || !$auth["access_token"]) {
        echo "Erro de Autenticação. Tente Novamente";
    } else {
        $config = $con->config();
        header("Location:" . $config["app"]);
    }
}