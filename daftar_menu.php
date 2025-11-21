<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "WEH bukan admin kok mau masuk?!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Menu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="menu-body">
    <div class="navbar-admin">
        <a href="admin_home.php">Home</a>
        <a href="daftar_menu.php">Menu</a>
        <a href="admin_profile.php">Profile</a>
    </div>
    <h1>Daftar menu</h1>    
</body>
</html>