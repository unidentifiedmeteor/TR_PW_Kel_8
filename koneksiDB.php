<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "tr_pwrestoran";

$conn = new mysqli($host, $user, $pass, $db);

// Jika koneksi gagal
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
