<?php
// Konfigurasi database
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "dblatihan";

// Membuat koneksi ke database
$koneksi = mysqli_connect($servername, $username, $password, $dbname);

// Mengecek koneksi
if (mysqli_connect_errno()) {
    echo "Gagal melakukan koneksi ke Database: " . mysqli_connect_error();
    exit();
}
