$(document).ready(function() {
    // Tampilkan iklan jika cookie popup belum diset
    if (getCookie("popup") === "") {
        $("#modal-ads").modal("show");
    }

    // Tampilkan riwayat berita
    renderHistory()

    // Bersihkan sesi akun bila keluar diklik
    $("#logout").on({
        click: function() {
            $.ajax({
                type: "POST",
                url: "php/login.php",
                data: "type=logout",
                dataType: "json",
                success: function(data) {
                    if (data["success"] === true) {
                        // Alihkan ke beranda
                        let path = window.location.href;
                        let parentDir = path.substring(0, path.lastIndexOf("/") + 1); 
                        window.location.replace(parentDir + "index.php");
                    }
                }
            });
        }
    });

    // Tutup modal setelah link target dibuka
    $("#modal-ads #target-ads").on({
        click: function() {
            $("#modal-ads").modal("hide");
        }
    });

    // Sembunyikan popup iklan selama 7 hari bila diklik
    $("#modal-ads #hide-ads").on({
        click: function() {
            let date = new Date();
            date.setTime(date.getTime() + (1000*60*60*24*7));
            // TODO: Cari workaround set cookie untuk local page
            document.cookie("popup=false; expires=" + date.toUTCString());
        }
    });

    // Tambahkan berita ke riwayat bila diklik
    $(".news .card").on({
        mouseenter: function() {
            $(this).addClass("shadow");
        },mouseleave: function() {
            $(this).removeClass("shadow");
        },click: function() {
            addHistory($(this)[0].id);
        }
    });

    // Hapus riwayat berita bila diklik
    $(".history").on({
        mouseenter: function() {
            if ($(this)[0].id != "refresh") {
                $(this).addClass("list-group-item-danger");
            }
        },mouseleave: function() {
            $(this).removeClass("list-group-item-danger");
        },click: function() {
            deleteHistory($(this)[0].id.replace("-history", ""));
        }
    }, ".list-group-item");
    
    // *************************************************
    // Fungsi local storage riwayat berita
    // *************************************************

    function addHistory(id) {
        let history = JSON.parse(localStorage.getItem("history"));
        if (history) history.push(id); else history = [id];
        localStorage.setItem("history", JSON.stringify([...new Set(history)]));
        renderHistory();
    }

    function renderHistory() {
        let history = JSON.parse(localStorage.getItem("history"));
        $(".history .list-group").find("a").remove();
        if (history && history.length > 0) {
            for (id in history) {
                let title = $(".news #" + history[id] + " h5")[0].textContent;
                let content = $(".news #" + history[id] + " p")[0].textContent;
                $(".history .list-group").append(
                    '<a id="' + history[id] + '-history" class="list-group-item list-group-item-action flex-column align-items-start">' +
                        '<div class="d-flex w-100 justify-content-between">' +
                            '<h5 class="mb-1">' + title + '</h5>' +
                            '<small class="text-muted"><button type="button" class="btn-close" aria-label="Close"></button></small>' +
                        '</div>' +
                        '<p class="mb-1">' + content + '</p>' +
                    '</a>'
                );
            }
        } else {
            $(".history .list-group").append(
                '<a id="refresh" class="list-group-item list-group-item-action flex-column align-items-start">' +
                    '<div class="d-flex w-100 justify-content-between">' +
                        '<h5 class="mb-1">Whoops...</h5>' +
                        '<small class="text-muted"><span class="badge bg-primary">Refresh</span></small>' +
                    '</div>' +
                    '<p class="mb-1">Riwayat berita masih kosong.</p>' +
                '</a>'
            );
        }
    }

    function deleteHistory(id) {
        let history = JSON.parse(localStorage.getItem("history"));
        if (history) history = history.filter(value => value != id);
        localStorage.setItem("history", JSON.stringify(history));
        renderHistory();
    }

    // *************************************************
    // Pengecekan cookie dari string cookies
    // https://www.w3schools.com/js/js_cookies.asp
    // *************************************************
    
    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
});