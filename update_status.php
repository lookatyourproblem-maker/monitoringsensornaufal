<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? 'OFF';
    file_put_contents("status.txt", $status);
    header("Location: index.php");
    exit;
}
