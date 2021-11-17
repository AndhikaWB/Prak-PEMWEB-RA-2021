<?php
    if ($_POST["tipe"] == "#form-calc") {
        echo calc($_POST["bil1"],$_POST["bil2"],$_POST["opr"]);
    } elseif ($_POST["tipe"] == "#form-nama") {
        echo urutNama($_POST["nama"]);
    } elseif ($_POST["tipe"] == "#form-prima") {
        echo bilPrima($_POST["bawah"],$_POST["atas"]);
    }

    function calc($bil1, $bil2, $opr) {
        if (is_numeric($bil1) && is_numeric($bil2)) {
            switch($opr) {
                case "+": return $bil1 + $bil2;
                case "-": return $bil1 - $bil2;
                case "/": return $bil1 / $bil2;
                case "*": return $bil1 * $bil2;
                case "%": return $bil1 % $bil2;
            }
        }
        // Bukan angka
        return "NaN";
    }

    function urutNama($nama) {
        // Konversi nama dari textarea menjadi array
        $hasil = explode("\n",str_replace("\r","",$nama));

        // Insertion sort
        for ($i = 1; $i < count($hasil); $i++) {
            for ($j = $i; $j > 0; $j--) {
                if ($hasil[$j-1] > $hasil[$j]) {
                    $temp = $hasil[$j];
                    $hasil[$j] = $hasil[$j-1];
                    $hasil[$j-1] = $temp;
                // Data sebelum (j) sudah pasti terurut
                } else break;
            }
        }

        // Gabungkan array kembali menjadi satu teks (textarea)
        return implode("\n",array_filter($hasil,"strlen"));
    }

    function bilPrima($bawah, $atas) {
        if (is_numeric($bawah) && is_numeric($atas)) {
            // Batas minimal adalah angka 2
            if ($bawah < 2) $bawah = 2;
            // Array bilangan prima mula-mula
            $hasil = [];

            for ($i = $bawah; $i <= $atas; $i++) {
                $prima = true;
                for ($j = $bawah; $j * $j <= $i; $j++) {
                    if ($i % $j == 0) {
                        $prima = false;
                        break;
                    }
                }
                // Tambahkan bilangan prima ke hasil
                if ($prima) $hasil[] = $i;
            }

            // Gabungkan array kembali menjadi satu teks (textarea)
            return implode("\n",array_filter($hasil,"strlen"));
        }
        // Bukan angka
        return "NaN";
    }
?>