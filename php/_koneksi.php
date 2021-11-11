<?php
    // Buat koneksi baru ke database
    $conn = new mysqli("localhost","root","","pemweb4");

    // Kode error selain 0 dianggap true (bermasalah)
    if ($conn->connect_errno) {
        // Buat array asosiatif untuk menyimpan pesan error
        $response = array("success" => false, "error" => $conn->connect_error);
        // Tampilkan pesan error dalam bentuk JSON dan berhenti
        die(json_encode($response));
    }
?>