<?php
session_start();
// Memanggil koneksiDB.php di sini (asumsi Anda sudah perbaiki masalah koneksi)
require "koneksiDB.php"; 

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "WEH bukan admin kok mau masuk?!";
    exit;
}

$username = $_SESSION["username"];
$role     = $_SESSION["role"]; // Ambil role untuk ditampilkan
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin</title>
    <link rel="stylesheet" href="profil.css"> </head>
<body>

<div class="container">

    <a href="admin_home.php" class="back" >←</a>

    <h2>Profil Admin</h2>

    <div class="profile-card">
        <img src="gambar_makanan/profil2.jpg" class="avatar">

        <h1><?php echo htmlspecialchars($username); ?></h1>
        <p><?php echo ucfirst($role); ?></p> 

        <a href="logout.php" class="logout-btn">Log Out</a>
    </div>

</div>

</body>
</html>