<?php

require_once 'Config.php';

class Connection
{

    protected $pdo;

    function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=' . Config::$host . ';dbname=' . Config::$db, Config::$user, Config::$pass);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

    }

    function exec($url, $request, $header, $data = "")
    {
        $curl = curl_init();
        $opts = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $request,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $header);

        curl_setopt_array($curl, $opts);

        $return = curl_exec($curl);
        curl_close($curl);
        return json_decode($return, TRUE);
    }

    function config()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM config;");
        $stmt->execute();
        $rs = $stmt->fetch(PDO::FETCH_ASSOC);
        return $rs;
    }

    function auth($code)
    {
        $config = Connection::config();

        $data["client_id"] = $config["client_id"];
        $data["client_secret"] = $config["client_secret"];
        $data["code"] = $code;

        $data = json_encode($data);
        $url = $config["host"] . "auth/token";


        $request = "POST";
        $header = ["Content-Type: application/json"];

        $exec = Connection::exec($url, $request, $header, $data);

        if (!$exec["errors"]) {
            $stmt = $this->pdo->prepare("UPDATE config SET access_token = :access_token, refresh_token = :refresh_token, code = :code;");
            $stmt->bindValue(":access_token", $exec["access_token"]);
            $stmt->bindValue(":refresh_token", $exec["refresh_token"]);
            $stmt->bindValue(":code", $code);

            var_dump($stmt);die;

            $stmt->execute();
        }

        return $exec;

    }

    function refresh_token($code)
    {
        $config = Connection::config();

        $data["client_id"] = $config["client_id"];
        $data["client_secret"] = $config["client_secret"];
        $data["refresh_token"] = $config["refresh_token"];

        $data = json_encode($data);
        $url = $config["host"] . "auth/token";
        $request = "POST";
        $header = ["Content-Type: application/json"];

        $exec = Connection::exec($url, $request, $header, $data);

        if (!$exec["errors"]) {
            $stmt = $this->pdo->prepare("UPDATE CONFIG SET access_token = :access_token, refresh_token = :refresh_token;");
            $stmt->bindValue(":access_token", $exec["access_token"]);
            $stmt->bindValue(":refresh_token", $exec["refresh_token"]);
            $run = $stmt->execute();
        }

        return $exec;

    }

    function get_contact($email)
    {
        $config = Connection::config();
        $url = $config["host"] . "/platform/contacts/email:" . $email;
        $request = "GET";
        $header = [
            'Autorization: Bearer ' . $config["access_token"]
        ];

        $exec = Connection::exec($url, $request, $header);
        return $exec;
    }

    function update_contacs($email, $tags)
    {
        $config = Connection::config();

        $array_tags = ["tags" => $tags];
        $data = json_encode($array_tags);
        $url = $config["host"] . "/platform/contacts/email:" . $email;
        $request = "PATCH";
        $header = [
            'Authorization: Bearer ' . $config["access_token"],
            'Content-Type: application/json'
        ];

        $exec = Connection::exec($url, $request, $header, $data);
        return $exec;

    }

    function set_sale($email, $price)
    {
        $config = Connection::config();

        $price = (float)$price;
        $data["event_type"] = "SALE";
        $data["event_family"] = "CDP";
        $data["payload"] = [
            "email" => $email,
            "funnel_name" => "default",
            "value" => $price
        ];

        $data = json_encode($data);

        $url = $config["host"] . "/platform/events";
        $request = "POST";
        $header = [
            'Authorization: Bearer ' . $config["access_token"],
            'Content-Type: application/json'
        ];

        $exec = Connection::exec($url, $request, $header, $data);
        return $exec;
    }


}
