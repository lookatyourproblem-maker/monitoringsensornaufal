<?php
header("Content-Type: text/plain");
$status_file = "status.txt";

if (!file_exists($status_file)) {
    file_put_contents($status_file, "OFF");
}

echo trim(file_get_contents($status_file));
