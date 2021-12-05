<?php
    session_start();
    include "php/koneksi.php";
    // Cek email dan password pada session storage
    if (isset($_SESSION["vYMDpfRD"]) && isset($_SESSION["TYBEtdoU"])) {
        // Decrypt email dari session storage
        $email = openssl_decrypt($_SESSION["vYMDpfRD"], $cipher, $salt);
        // Cek email yang sudah di decrypt pada database
        $sql = "SELECT * FROM user WHERE email='$email' LIMIT 1";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                // Dapatkan password murni pada database
                $pasword = $conn->query($sql)->fetch_assoc()["password"];
                // Bandingkan password murni dengan hash password
                if (password_verify($pasword, $_SESSION["TYBEtdoU"])) {
                    // Alihkan ke beranda bila kedua password sama
                    header("Location: home.php");
                }
            }
        } else $error = true;
    }
    if ($error) {
        // Alihkan ke halaman error jika koneksi ke database gagal
        http_response_code(500);
        include "error.php";
    }
    $conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Andhika Wibawa - 119140218</title>
    <!-- JQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="jumbotron d-flex align-items-center min-vh-100">
        <div class="container">
            <div class="card">
                <div class="row">
                    <div class="col my-auto" style="border-right: 1px solid #EEEEEE;">
                        <!-- Sumber: https://www.freepik.com/free-vector/business-team-discussing-ideas-startup_6974855.htm -->
                        <img src="img/login.svg" class="img-fluid" alt="Background">
                    </div>
                    <div class="col">
                        <div class="card-body">
                            <!-- Deklarasi tab masuk dan pendaftaran -->
                            <ul class="nav nav-pills justify-content-center" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-tab-content" type="button" role="tab" aria-controls="login" aria-selected="true">Masuk</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-tab-content" type="button" role="tab" aria-controls="register" aria-selected="false">Daftar</button>
                                </li>
                            </ul>
                            <!-- Isi konten tab masuk dan pendaftaran -->
                            <div id="form-parent" class="tab-content">
                                <!-- Tab masuk -->
                                <div class="tab-pane fade show active" id="login-tab-content" role="tabpanel" aria-labelledby="login-tab">
                                    <form id="form-login">
                                        <div class="form-row mt-3">
                                            <div class="form-group col-md-12">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control my-1" name="email" placeholder="Masukkan email Anda..." required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="password">Kata Sandi</label>
                                                <input type="password" class="form-control my-1" name="password" placeholder="Masukkan kata sandi Anda..." required>
                                            </div>
                                        </div>
                                        <div class="my-3">
                                            <button class="btn btn-primary full-width" type="submit">Masuk</button>
                                        </div>
                                    </form>
                                    <div class="text-center">
                                        <hr>
                                        <h4 class="text-primary mb-0">Atau</h4>
                                        <p class="mb-1">Masuk lewat sosial media</p>
                                        <ul class="ps-0 mb-0">
                                            <li class="me-3" style="display: inline-block;">
                                                <a href="#"><i class="bi bi-google fs-4" style="color: #DB4A39;"></i></a>
                                            </li>
                                            <li class="me-3" style="display: inline-block;">
                                                <a href="#"><i class="bi bi-facebook fs-4" style="color: #4267B2;"></i></a>
                                            </li>
                                            <li style="display: inline-block;">
                                                <a href="#"><i class="bi bi-twitter fs-4" style="color: #1DA1F2;"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Tab pendaftaran -->
                                <div class="tab-pane fade" id="register-tab-content" role="tabpanel" aria-labelledby="register-tab">
                                    <form id="form-register">
                                        <div class="form-row mt-3">
                                            <div class="form-group col-md-12">
                                                <label for="name">Nama</label>
                                                <input type="text" class="form-control my-1" name="name" placeholder="Masukkan nama Anda..." required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control my-1" name="email" placeholder="Masukkan email Anda..." required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="password">Kata Sandi</label>
                                                <input type="password" class="form-control mt-1 mb-3" name="password" placeholder="Masukkan kata sandi Anda..." required>
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="agreement" checked disabled>
                                            <label class="form-check-label" for="agreement">Saya setuju dengan syarat dan ketentuan</label>
                                        </div>
                                        <div class="my-3">
                                            <button class="btn btn-primary full-width" type="submit">Daftar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Script tambahan (harus di akhir body) -->
    <script src="js/index.js"></script>
</body>
</html>