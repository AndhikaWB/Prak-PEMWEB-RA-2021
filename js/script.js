$(document).ready(function() {
    // Workaround delegate event handler untuk menangani perubahan elemen dinamis
    // https://stackoverflow.com/questions/41694535/
    // https://api.jquery.com/on/

    $.fn.mixon = function(events) {
        Object.keys(events).forEach(function(selector) {
            let entry = events[selector];
            Object.keys(entry).forEach(function(event) {
                this.on(event, selector, entry[event]);
            }, this);
        }, this);
        return this;
    };

    // ==============================
    // Halaman index.html
    // ==============================

    $("#form-parent").mixon({
        "#form-login": {
            // Jika form login di submit
            submit: function(event) {
                $.ajax({
                    type: "POST",
                    url: "php/login.php",
                    data: $("#form-login").serialize() + "&type=login",
                    dataType: "json",
                    success: function(data) {
                        if (data["success"] === false) {
                            alert("Email atau kata sandi akun salah!");
                        } else {
                            window.location.replace("/manage.html");
                        }
                    }
                });
                // Cegah refresh halaman
                event.preventDefault();
            }
        },
        "#form-register": {
            // Jika form register di submit
            submit: function(event) {
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
                        }
                    }
                });
                // Cegah refresh halaman
                //event.preventDefault();
            }
        }
    });

    // ==============================
    // Halaman manage.html
    // ==============================

    // Ketika form stok barang di submit
    $("#form-goods").on({
        submit: function(event) {
            $.ajax({
                type: "POST",
                url: "php/manage.php",
                // Tambah barang, perbarui data jika barang sudah ada
                data: $("#form-goods").serialize() + "&type=add",
                dataType: "json",
                success: function(data) {
                    if (data["success"] === false) {
                        alert("Status barang gagal diperbarui!");
                    } else {
                        alert("Status barang berhasil diperbarui!");
                        // Bersihkan data barang pada tabel
                        $("#table-goods").find("tr:has(td)").remove();
                        if (data["result"].length) {
                            // Tambahkan baris-baris baru pada tabel barang
                            data["result"].forEach(function(row) {
                                $("#table-goods")
                                    .append("<tr>" + 
                                            "<td>" + row["id"] + "</td>" +
                                            "<td>" + row["name"] + "</td>" +
                                            "<td>" + row["stock"] + "</td>" +
                                            "<td>" + row["desc"] + "</td>" +
                                            "<td><i class=\"bi bi-pencil-fill\"></i></td>" +
                                            "<td><i class=\"bi bi-trash-fill\"></i></td>" +
                                            "<tr>");
                            });
                            // Hilangkan kemungkinan adanya baris kosong
                            $("#table-goods tr:empty").remove();
                        }
                    }
                }
            });
            // Cegah refresh halaman
            event.preventDefault();
        }
    });

    $("#table-goods").mixon({
        ".bi-pencil-fill": {
            mouseenter: function() {
                // Ubah warna pensil menjadi merah jika sedang hover
                $(this).addClass("text-primary");
            },mouseleave: function() {
                // Ubah warna pensil seperti semula jika selesai hover
                $(this).removeClass("text-primary");
            },click: function() {
                // Simpan objek tiap-tiap child <td> dari parent <tr> terdekat
                let data = $(this).closest("tr").children("td");
                $("#form-goods").find("input").each(function(index,form) {
                    // Cari form barang lalu isi tiap-tiap input berdasarkan teks dari <td>
                    form.value = data[index].textContent;
                });
            }
        },
        ".bi-trash-fill": {
            mouseenter: function() {
                // Ubah warna tong sampah menjadi merah ketika sedang hover
                $(this).addClass("text-danger");
            },mouseleave: function() {
                // Ubah warna tong sampah seperti semula ketika selesai hover
                $(this).removeClass("text-danger");
            },click: function() {
                if (confirm("Ingin menghapus baris ini?")) {
                    $.ajax({
                        type: "POST",
                        url: "php/manage.php",
                        data: { id: $(this).closest("tr").children("td").first().text(), type: "delete" },
                        dataType: "json",
                        success: function(data) {
                            if (data["success"] === false) {
                                // Tampilkan pesan gagal bila nilainya false
                                //alert("Data barang gagal dihapus!")
                            } else {
                                // Tampilkan pesan sukses bila nilainya selain false
                                //alert("Data barang sukses dihapus!")
                            }
                        }
                    });
                    // Cari parent <tr> terdekat dari child <td> lalu hapus parent tersebut
                    $(this).closest("tr").remove();
                }
            }
        }
    });
});