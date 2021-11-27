<?php
    include "connect.php";

    // Buat collection (tabel) bernama "users" di database "pemweb"
    $login = $db->users;

    if ($_POST["type"] == "login") {
        // Cari akun yang sudah ada di "users"
        $result = $login->findOne([
            "email" => $_POST["email"],
            "password" => $_POST["password"]
        ]);
    } elseif ($_POST["type"] == "register") {
        // Buat akun baru di "users"
        $result = $login->insertOne([
            "name" => $_POST["name"],
            "email" => $_POST["email"],
            "password" => $_POST["password"]
        ]);
    }

    if ($result) {
        $response = array("success" => true);
    } else {
        $response = array("success" => false, "error" => "Can't find or create account");
    }

    echo json_encode($response);
?>