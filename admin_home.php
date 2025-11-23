<?php
require "koneksiDB.php";
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "WEH bukan admin kok mau masuk?!";
    exit;
}


$result = $conn->query("SELECT * FROM roles ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="body admin">
    <div class="navbar-admin">
        <a href="admin_home.php">Home</a>
        <a href="admin_daftar_menu.php">Menu</a>
        <a href="admin_profile.php">Profile</a>
    </div>
    <h2>Ini halaman admin</h2>
    <div class="tabel-roles">
        <h2>Daftar Pengguna</h2>
        <table border="1" cellspacing="0" cellpadding="5">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
            </tr>
            <?php while($row=$result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['username']; ?></td>
                <td><?= $row['role']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>