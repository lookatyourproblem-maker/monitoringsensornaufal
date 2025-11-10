<?php
require("koneksi.php");
// Prepare the SQL statement

$result = mysqli_query($koneksi, "INSERT INTO datasensor
(data) VALUES ('" . $_GET["data"] . "')");

if (!$result) {
    die('Invalid query: ' . mysqli_error($koneksi));
}
