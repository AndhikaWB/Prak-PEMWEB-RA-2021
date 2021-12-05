<?php
    // Buat koneksi baru ke database
    $conn = new mysqli("localhost","root","","pemweb");
    // Salt dan cipher untuk menyimpan selain password
    $salt = "5!vb3Gj&KYRELk3&5Av%TjJ96uic56k&";
    $cipher = "aes-256-cbc-hmac-sha256";

    if ($conn->connect_errno) {
        $error = true;
    }

    // // Kode error selain 0 dianggap true (bermasalah)
    // if ($conn->connect_errno) {
    //     // Alihkan ke halaman error
    //     http_response_code(500);
    //     include "../error.php";
    //     die();
    // }
?>