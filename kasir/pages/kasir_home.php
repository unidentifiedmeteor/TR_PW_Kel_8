<?php
session_start();
include "../../koneksiDB.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'kasir') {
    echo "Anda bukan kasir!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kasir Panel — Westo</title>
    <link rel="stylesheet" href="../assets/kasir_home.css">
</head>
<body>

<header>
    <div class="nav-left">
        <div class="logo">Westo</div>
        <nav>
            <a href="kasir_home.php" class="active">Home</a>
            <a href="orders.php">Orders</a>
        </nav>
    </div>

    <form action="../../logout.php" method="POST">
        <button class="btn-logout">Logout</button>
    </form>
</header>


<section class="hero">
    <h1>Selamat Datang di Panel Kasir! 😊</h1>
    <p>Kelola pesanan pelanggan di sini</p>

    <a href="orders.php" class="btn-main">Lihat Pesanan Masuk</a>
</section>


<footer>
    <p>© <?php echo date("Y"); ?> Westo — Kasir Panel</p>
</footer>

</body>
</html>
