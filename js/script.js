// Tunggu sampai halaman dimuat sepenuhnya
document.addEventListener("DOMContentLoaded", function() {
    // Aksi ketika tombol submit (perbarui pesanan) di klik
    document.querySelector("#submit").addEventListener("click", function(event) {
        // Cegah refresh halaman
        event.preventDefault();
        // Kirim data form ke backend
        postOrder(document.querySelector("#form-order")).then(data => {
            // Isi total harga berdasarkan respons backend
            document.querySelector("#total").value = data;
        })
    });

    async function postOrder(form) {
        // Konversi data form menjadi query URL (tidak di support semua browser)
        let formData = new URLSearchParams(new FormData(form)).toString();

        let response = await fetch("php/checkout.php", {
            method: "POST",
            body: formData,
            headers: {
                // Ubah tipe konten agar data terbaca di backend
                "Content-Type": "application/x-www-form-urlencoded"
            }
        });

        // Kembalikan promise
        return response.text();
    }
});