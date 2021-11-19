<?php
    // Semua variabel PHP secara default adalah global
    // Kecuali bila diletakkan di dalam fungsi

    class Buah {
        public function __construct($nama, $harga, $berat) {
            $this->nama = $nama;
            $this->harga = $harga;
            $this->berat = $berat;
            $this->total = $berat * $harga;
        }

        // Konversi kelas menjadi string bila dibutuhkan
        public function __toString() {
            return $this->nama . ": " .  $this->berat . " x " . $this->harga .
                   " = Rp " . $this->total . "\n";
        }
    }

    echo $mangga = new Buah("Mangga", $_POST["harga-mgg"], $_POST["berat-mgg"]);
    echo $jambu = new Buah("Jambu", $_POST["harga-jmb"], $_POST["berat-jmb"]);
    echo $salak = new Buah("Salak", $_POST["harga-slk"], $_POST["berat-slk"]);

    echo "------------------------------\n";
    foreach ([$mangga, $jambu, $salak] as $buah) $total += $buah->total;
    echo "Total Harga: Rp " . $total;
?>