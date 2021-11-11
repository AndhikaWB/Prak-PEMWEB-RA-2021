<?php
	include "_koneksi.php";

	// Baca seluruh data pada tabel mahasiswa
	$sql = "SELECT * FROM mahasiswa";
	$result = $conn->query($sql);

	// Buat array pertama untuk menyimpan data tabel mahasiswa
	$response = array();

	if ($result->num_rows > 0) {
		// Konversi satu baris data menjadi array asosiatif (dictionary)
		while ($row = $result->fetch_assoc()) {
			// Tambahkan array asosiatif sebagai anggota/indeks baru array pertama
			// Menjadi array 2 dimensi (dimensi pertama = angka, dimensi kedua = dict)
			$response[] = $row;
		}
	} else if ($result->num_rows == 0) {
		// Bila table mahasiswa belum terisi data
		$response += array("success" => false, "error" => "Empty table");
	} else {
		// Bila table tidak dapat ditemukan dan error lainnya
		$response += array("success" => false, "error" => $conn->error);
	}

	// Tampilkan data array dalam bentuk JSON
	echo json_encode($response);

	// Tutup koneksi
	$conn->close();
?>