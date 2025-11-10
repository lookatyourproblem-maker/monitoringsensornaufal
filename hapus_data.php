<?php
require("koneksi.php");
mysqli_query($koneksi, "TRUNCATE TABLE datasensor"); // hapus semua isi tabel
header("Location: index.php");
exit;
