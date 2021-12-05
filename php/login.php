<?php
    session_start();
    include("koneksi.php");

    $name = $_POST["name"];
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $type = $_POST["type"];

    if ($type == "login") {
        $sql = "SELECT * FROM user WHERE email='$email' AND password='$pass'";
        $result = boolval($conn->query($sql)->num_rows > 0);
    } elseif ($type == "register") {
        $sql = "INSERT INTO user VALUES ('$name', '$email', '$pass')";
        $result = $conn->query($sql);
    }

	if ($result) {
        if ($type == "login") {
            $_SESSION["vYMDpfRD"] = crypt($email, $crypt);
            $_SESSION["TYBEtdoU"] = password_hash($pass, PASSWORD_DEFAULT);
        }
        $response = array("success" => true, "type" => $type);
	} else {
        $response = array("success" => false, "type" => $type);
    }

	// Tampilkan data array dalam bentuk JSON
	echo json_encode($response);

	// Tutup koneksi
	$conn->close();
?>