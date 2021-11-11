$(document).ready(function() {
    // Perbarui tabel berdasarkan data mahasiswa pada database
    perbaruiTabel();

    /****************************************/

    // Workaround delegate event handler untuk menangani perubahan tabel dinamis
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

    /****************************************/

    $("#table-mhs").mixon({
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
                $("#form-mhs").find("input").each(function(index,form) {
                    // Cari form mahasiswa lalu isi tiap-tiap input berdasarkan teks dari <td>
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
                    // Hapus mahasiswa dari database (tidak perlu cek tabel kembali)
                    hapusMahasiswa($(this).closest("tr").children("td").first().text());
                    // Cari parent <tr> terdekat dari child <td> lalu hapus parent tersebut
                    $(this).closest("tr").remove();
                }
            }
        }
    });

    /****************************************/

    $("#form-mhs").on({
        submit: function(event) {
            // Tambah mahasiswa ke database
            tambahMahasiswa();
            // Cegah terjadinya refresh halaman
            event.preventDefault();
            // Perbarui tabel berdasarkan data pada database
            // Workaround karena fungsi tambah dan perbarui digabung
            perbaruiTabel();
        }
    });

    /****************************************/

    function perbaruiTabel() {
        // Bersihkan data mahasiswa pada tabel
        $("#table-mhs").find("tr:has(td)").remove();
        
        // Simpan data mahasiswa yang diperoleh dari database
        let response = lihatMahasiswa()

        // Jika data tidak kosong maka...
        if (response.length) {
            // Tambahkan baris-baris baru pada tabel
            response.forEach(function(data) {
                $("#table-mhs")
                    .append("<tr>" + 
                            "<td>" + data["nim"] + "</td>" +
                            "<td>" + data["nama"] + "</td>" +
                            "<td>" + data["prodi"] + "</td>" +
                            "<td>" + data["angkatan"] + "</td>" +
                            "<td><i class=\"bi bi-pencil-fill\"></i></td>" +
                            "<td><i class=\"bi bi-trash-fill\"></i></td>" +
                            "<tr>");
            });
            // Hilangkan kemungkinan adanya baris kosong
            $("#table-mhs tr:empty").remove();
        }
    }

    /****************************************/

    function lihatMahasiswa() {
        // Buat array untuk menyimpan respons data
        let response;

        $.ajax({
            type: "GET",
            // Workaround response undefined
            async: false,
            url: "php/baca.php",
            // Gunakan JSON agar konversi tipe data terjadi otomatis
            dataType: "json",
            success: function(data) {
                // Gunakan "===" untuk mencegah undefined tergolong ke false
                if (data["success"] === false) {
                    // Tampilkan pesan gagal bila nilainya false
                    //alert("Data mahasiswa tidak dapat dibaca!")
                } else {
                    // Tampilkan pesan sukses bila nilainya selain false
                    //alert("Data mahasiswa sukses sukses terbaca!")
                    response = data;
                }
                // Cetak respons data ke konsol browser
                console.log(data)
            }
        });

        // Kembalikan respons data
        return response;
    }

    /****************************************/

    // Perbarui atau tambah mahasiswa baru (ubah nim = tambah mahasiswa baru)
    function tambahMahasiswa() {
        // Buat array untuk menyimpan respons data
        let response;

        $.ajax({
            type: "POST",
            // Workaround response undefined
            async: false,
            url: "php/tambah.php",
            // Ambil name dan value dari semua input pada form
            data: $("#form-mhs").serialize(),
            // Gunakan JSON agar konversi tipe data terjadi otomatis
            dataType: "json",
            success: function(data) {
                // Gunakan "===" untuk mencegah undefined tergolong ke false
                if (data["success"] === false) {
                    // Tampilkan pesan gagal bila nilainya false
                    alert("Data mahasiswa gagal diperbarui!")
                } else {
                    // Tampilkan pesan sukses bila nilainya selain false
                    alert("Data mahasiswa sukses diperbarui!")
                    response = data;
                }
                // Cetak respons data ke konsol browser
                console.log(data)
            }
        });

        // Kembalikan respons data
        return response;
    }

    /****************************************/

    function hapusMahasiswa(nim) {
        // Buat array untuk menyimpan respons data
        let response;

        $.ajax({
            type: "POST",
            // Workaround response undefined
            async: false,
            url: "php/hapus.php",
            // Ambil name dan value dari semua input pada form
            data: { nim: nim },
            // Gunakan JSON agar konversi tipe data terjadi otomatis
            dataType: "json",
            success: function(data) {
                // Gunakan "===" untuk mencegah undefined tergolong ke false
                if (data["success"] === false) {
                    // Tampilkan pesan gagal bila nilainya false
                    //alert("Data mahasiswa gagal dihapus!")
                } else {
                    // Tampilkan pesan sukses bila nilainya selain false
                    //alert("Data mahasiswa sukses dihapus!")
                    response = data;
                }
                // Cetak respons data ke konsol browser
                console.log(data)
            }
        });

        // Kembalikan respons data
        return response;
    }
});