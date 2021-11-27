<?php
    require_once "../vendor/autoload.php";
    // Buat koneksi baru ke database "pemweb"
    $db = (new MongoDB\Client("mongodb://localhost:27017"))->pemweb;
?>