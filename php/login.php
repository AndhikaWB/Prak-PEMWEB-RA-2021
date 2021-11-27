<?php
    include "connect.php";

    // Buat collection (tabel) bernama "users" di database "pemweb"
    $login = $db->users;

    try {
        if ($_POST["type"] == "login") {
            $result = $login->findOne([
                // Cari akun yang sudah terdaftar
                "email" => $_POST["email"],
                "password" => $_POST["password"]
            ]);
        } elseif ($_POST["type"] == "register") {
            $result = $login->updateOne(
                // Cek apakah email sudah terdaftar
                ["email" => $_POST["email"]],
                // Buat akun baru bila belum ada
                ["$setOnInsert" => [
                    "name" => $_POST["name"],
                    "email" => $_POST["email"],
                    "password" => $_POST["password"]
                ]],
                ["upsert" => true]
            );
        }
    } catch(MongoDB\Driver\Exception $e) {
        $error = $e->getMessage();
    }

    if ($result) {
        $response = array("success" => true);
    } else {
        $response = array("success" => false, "error" => $error);
    }

    echo json_encode($response);
?>