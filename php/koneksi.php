<?php
    // Buat koneksi baru ke database
    $conn = new mysqli("localhost","roota","","pemweb5");
    // Salt dan cipher untuk menyimpan selain password
    $salt = "5!vb3Gj&KYRELk3&5Av%TjJ96uic56k&";
    $cipher = "aes-256-cbc-hmac-sha256";

    // // Kode error selain 0 dianggap true (bermasalah)
    // if ($conn->connect_errno) {
    //     // Alihkan ke halaman error
    //     http_response_code(500);
    //     include "../error.php";
    //     die();
    // }
?>