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
            do {
                if ($result->num_rows > 0) {
                    // Dapatkan password murni pada database
                    $pasword = $conn->query($sql)->fetch_assoc()["password"];
                    // Bandingkan password murni dengan hash password
                    if (password_verify($pasword, $_SESSION["TYBEtdoU"])) {
                        break;
                    }
                }
                // Alihkan ke beranda bila email atau password tidak valid
                header("Location: index.php");
                // Hapus email dan password dari session storage
                unset($_SESSION["vYMDpfRD"]);
                unset($_SESSION["TYBEtdoU"]);
            } while (false);
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">AW</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    <a class="nav-item nav-link active" href="#">Terkini</a>
                    <a class="nav-item nav-link" href="#">Politik</a>
                    <a class="nav-item nav-link" href="#">Kesehatan</a>
                    <a class="nav-item nav-link" href="#">Teknologi</a>
                    <a id="logout" class="nav-item nav-link">Keluar</a>
                </div>
            </div>
        </div>
    </nav>
    <main class="container" role="main">
        <div class="row">
            <!-- Kartu Berita -->
            <div class="col-sm-8 mt-3">
                <div class="row news">
                    <div class="col-sm-4 mb-3">
                        <div id="card1" class="card h-100">
                            <div class="card-body p-3">
                                <h5 class="card-title text-center text-primary pb-2">Berita 1</h5>
                                <p>If you're visiting this page, you're likely here because you're searching for a random sentence.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div id="card2" class="card h-100">
                            <div class="card-body p-3">
                                <h5 class="card-title text-center text-primary pb-2">Berita 2</h5>
                                <p>Sometimes a random word just isn't enough, and that is where the sentence generator comes handy.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div id="card3" class="card h-100">
                            <div class="card-body p-3">
                                <h5 class="card-title text-center text-primary pb-2">Berita 3</h5>
                                <p>Producing random sentences can be helpful in a number of different ways.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div id="card4" class="card h-100">
                            <div class="card-body p-3">
                                <h5 class="card-title text-center text-primary pb-2">Berita 4</h5>
                                <p>For writers, a random sentence can help them get their creative juices flowing.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div id="card5" class="card h-100">
                            <div class="card-body p-3">
                                <h5 class="card-title text-center text-primary pb-2">Berita 5</h5>
                                <p>There are a number of different ways a writer can use the random sentence for creativity.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div id="card6" class="card h-100">
                            <div class="card-body p-3">
                                <h5 class="card-title text-center text-primary pb-2">Berita 6</h5>
                                <p>The most common way to use the sentence is to begin a story.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Riwayat Berita -->
            <div class="col-sm-4 my-3">
                <div class="card history">
                    <div class="card-body p-3">
                        <h5 class="card-title text-center text-primary pb-1">Riwayat Berita</h5>
                        <div class="list-group" style="max-height: 22rem; overflow-y: auto;">
                            <!-- <a class="list-group-item list-group-item-action flex-column align-items-start">
                              <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">List group item heading</h5>
                                <small class="text-muted"><button type="button" class="btn-close" aria-label="Close"></button></small>
                              </div>
                              <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                            </a>
                            <a class="list-group-item list-group-item-action flex-column align-items-start">
                              <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">List group item heading</h5>
                                <small class="text-muted"><button type="button" class="btn-close" aria-label="Close"></button></small>
                              </div>
                              <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                            </a>
                            <a class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                  <h5 class="mb-1">List group item heading</h5>
                                  <small class="text-muted"><button type="button" class="btn-close" aria-label="Close"></button></small>
                                </div>
                                <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                            </a>
                            <a class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                  <h5 class="mb-1">List group item heading</h5>
                                  <small class="text-muted"><button type="button" class="btn-close" aria-label="Close"></button></small>
                                </div>
                                <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                            </a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal iklan -->
        <div id="modal-ads" class="modal fade" tabindex="-1" aria-labelledby="modal-ads-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-ads-title">Ingin Belajar Cloud dan Back-End?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Daftar gratis <i>course cloud computing</i> sekarang juga! Pendaftaran tutup <b class="text-danger">31 Desember 2021</b>.</p>
                    </div>
                    <div class="modal-footer">
                        <button id="hide-ads" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Jangan tampilkan lagi</button>
                        <a id="target-ads" href="https://www.dicoding.com/programs/aws/registration/1100554" class="btn btn-primary" target="_blank">Ya, saya mau</a>
                    </div>
                </div>
            </div>
        </div>  
    </main>
    <!-- Script tambahan (harus di akhir body) -->
    <script src="js/home.js"></script>
</body>
</html>