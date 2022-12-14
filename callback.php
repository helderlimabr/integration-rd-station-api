<?php

include_once "Connection.php";

$con = new Connection();

if (isset($_GET['code'])) {
    $auth = $con->auth($_GET["code"]);

    if ($auth["errors"] || !$auth["access_token"]) {
        echo "Erro de Autenticação. Tente Novamente";
    } else {
        $config = $con->config();
        header("Location:" . $config["app"]);
    }
} else {
    echo '<h1>Nenhuma informação a ser exibida.</h1>';
};