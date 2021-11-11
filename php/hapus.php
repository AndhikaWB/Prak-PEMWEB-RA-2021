<?php
    include "_koneksi.php";

    $nim = $_POST["nim"];

    $sql = "DELETE FROM mahasiswa WHERE nim = '$nim'";
    $result = $conn->query($sql);

	// Buat array untuk menyimpan respons query
	$response = array();

    if ($result) {
		// Tampilkan kembali NIM mahasiswa untuk pengecekan tabel
		$response += array("nim" => $nim);
	} else {
		// Tampilkan error bila query tidak valid, data kosong, dan error lainnya
		$response += array("success" => false, "error" => $conn->error);
	}

	// Tampilkan data array dalam bentuk JSON
	echo json_encode($response);

	// Tutup koneksi
	$conn->close();
?>