<?php
    include "connect.php";

    // Buat collection (tabel) bernama "goods" di database "pemweb"
    $login = $db->goods;

    try {
        if ($_POST["type"] == "add") {
            $result = $login->updateOne([
                // Cek apakah id barang sudah ada
                ["id" => $_POST["id"]],
                // Buat barang baru atau perbarui bila sudah ada
                ["$set" => [
                    "id" => $_POST["id"],
                    "name" => $_POST["name"],
                    "stock" => $_POST["stock"],
                    "desc" => $_POST["desc"]
                ]],
                ["upsert" => true]
            ]);
        } elseif ($_POST["type"] == "read") {
            $result = $login->find([
                // Cari id barang yang sudah ada
                "id" => $_POST["id"]
            ]);
        } elseif ($_POST["type"] == "delete") {
            $result = $login->deleteOne([
                // Hapus id barang yang sudah ada
                "id" => $_POST["id"]
            ]);
        }
    } catch(MongoDB\Driver\Exception $e) {
        $error = $e->getMessage();
    }

    if ($result) {
        $response = array("success" => true, "result" => $result);
    } else {
        $response = array("success" => false, "error" => $error);
    }

    echo json_encode($response);
?>