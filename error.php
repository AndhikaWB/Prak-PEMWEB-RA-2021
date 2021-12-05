<?php
    if (http_response_code() == 500) {
        $title = " Internal Server";
        $error = "Terjadi kesalahan internal pada server";
    } else {
        http_response_code(404);
        $title = " Not Found";
        $error = "Halaman yang Anda tuju tidak ditemukan";
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo http_response_code() . $title ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</head>
<body style="height: 100vh;">
    <div class="container d-flex align-items-center justify-content-center" style="height: 100%;">
        <div class="row">
            <div class="col">
                <div class="card" style="width: 28rem;">
                    <div class="card-body text-center">
                        <h1 class="card-title"><?php echo http_response_code() ?></h1>
                        <!-- Sumber: https://www.freepik.com/free-vector/tiny-people-standing-near-prohibited-gesture-isolated-flat-illustration_11235950.htm -->
                        <img src="img/error.svg" class="img-fluid" alt="Background">
                        <p class="card-text"><?php echo $error ?></p>
                        <a href="index.php" class="btn btn-primary">Kembali ke beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>