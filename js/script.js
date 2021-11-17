$(document).ready(function() {
    function prosesAjax(formId) {
        $.ajax({
            type: "POST",
            url: "php/one-for-all.php",
            data: $(formId).serialize() + "&tipe=" + formId,
            success: function(hasil) {
                // Ubah nilai atau teks hasil pada form
                $(formId + " .form-control:last").val(hasil);
            }
        });
    }

    $("form .form-control").on("input change", function() {
        // Cari induk form terdekat dari child input form
        let form = $(this).closest("form");

        let terisi = true
        // Cek nilai dari tiap-tiap input form kecuali bagian hasil
        form.find(".form-control:not(:last)").each(function() {
            // Bila input masih kosong maka set ke false
            if (!this.value) terisi = false;
        });

        // Bila semua input telah terisi maka kirimkan AJAX
        if (terisi == true) {
            // Kirim id form yang sesuai sebagai parameter
            prosesAjax("#" + form[0].id);
        }
    });
});