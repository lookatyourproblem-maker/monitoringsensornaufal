<?php
require("koneksi.php");

$result = mysqli_query($koneksi, "SELECT read_status FROM kontrol WHERE id=1");
$row = mysqli_fetch_assoc($result);
echo $row['read_status'];
