$(document).ready(function() {
    $("#form-login").on("submit", function(event) {
        $.ajax({
            type: "POST",
            url: "php/login.php",
            data: $("#form-login").serialize() + "&type=login",
            dataType: "json",
            success: function(data) {
                if (data["success"] === false) {
                    alert("Email atau kata sandi akun salah!");
                } else {
                    // Alihkan ke beranda
                    window.location.replace("/home.html");
                }
            }
        });
        // Cegah refresh halaman
        event.preventDefault();
    });

    $("#form-register").on("submit", function(event) {
        $.ajax({
            type: "POST",
            url: "php/login.php",
            data: $("#form-register").serialize() + "&type=register",
            dataType: "json",
            success: function(data) {
                if (data["success"] === false) {
                    alert("Gagal menambahkan akun baru!");
                } else {
                    alert("Sukses menambahkan akun baru!");
                    // Reset isi form pendaftaran
                    $("#form-register")[0].reset();
                }
            }
        });
        // Cegah refresh halaman
        event.preventDefault();
    });
});