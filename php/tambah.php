<?php
	include "_koneksi.php";

	// Masukkan data form ke dalam variabel
	$nim = $_POST["nim"];
	$nama = $_POST["nama"];
	$prodi = $_POST["prodi"];
	$angkatan = $_POST["angkatan"];

	// Masukkan data form ke dalam database, perbarui data jika sudah ada
	$sql = "INSERT INTO mahasiswa VALUES ('$nim', '$nama', '$prodi', '$angkatan')" .
		   "ON DUPLICATE KEY UPDATE nama = '$nama', prodi = '$prodi', angkatan = '$angkatan'";
	$result = $conn->query($sql);

	// Buat array untuk menyimpan respons query
	$response = array();

	if ($result) {
		// Tampilkan kembali data form mahasiswa untuk pengecekan tabel
		$response += array("nim" => $nim, "nama" => $nama, "prodi" => $prodi, "angkatan" => $angkatan);
	} else {
		// Tampilkan error bila query tidak valid, data kosong, dan error lainnya
		$response += array("success" => false, "error" => $conn->error);
	}

	// Tampilkan data array dalam bentuk JSON
	echo json_encode($response);

	// Tutup koneksi
	$conn->close();
?>