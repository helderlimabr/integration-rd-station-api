<?php

require_once "Connection.php";

$con = new Connection();

$email = $_POST["email"] ?? "";
$price = $_POST["price"] ?? "";
$tag = $_POST["tag"] ?? "";
$tags = [];

if ($tag) {
    array_push($tags, $tag);
}

if ($email && $tag) {
    $contact = $con->get_contact($email);
    if ($contact["errors"]["error_type"] == "UNAUTHORIZED") {
        $auth = $con->refresh_token();
        if ($auth["errors"] || !$auth["access_token"]) {
            echo "Erro de Autenticação <br>";
            exit();
        }

        $contact = $con->get_contact($email);

        if (!$contact["errors"]) {
            foreach ($contact["tags"] as $tag) {
                array_push($tags, $tag);
            }
        }
    } else {
        foreach ($contact["tags"] as $tag) {
            array_push($tags, $tag);
        }
    }
}
