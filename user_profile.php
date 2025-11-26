<?php
session_start();

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "user") {
    echo "Anda bukan user!";
    exit;
}

$username = $_SESSION["username"];
$role     = $_SESSION["role"];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="coret.css">
</head>
<body>

<div class="container">

    <a href="user_home.php" class="back" >←</a>

    <h2>Profil Pengguna</h2>

    <div class="profile-card">
        <img src="gambar_makanan/profil2.jpg" class="avatar">

        <h1><?php echo htmlspecialchars($username); ?></h1>
        <p><?php echo ucfirst($role); ?></p>

        <a href="loading.php" class="logout-btn">Log Out</a>
    </div>

</div>

</body>
</html>
