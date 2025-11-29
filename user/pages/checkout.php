<?php
session_start();

/* reset cart kalau user klik tombol kembali */
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
    header("Location: menu.php");
    exit;
}

/* jika cart belum ada atau kosong, user dikembalikan ke cart */
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

/* hitung total harga semua item di cart */
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['harga'] * $item['qty'];
}

/* ambil username sebagai kode pesanan */
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout — Westo</title>
    <link rel="stylesheet" href="../assets/checkout.css">
</head>
<body>

<div class="checkout-header">
    <div class="logo">Westo</div>
</div>

<section class="checkout-section">
    <h1>Order Summary</h1>

    <!-- tampilkan nama pelanggan -->
    <div class="code">
        Pelanggan:
        <span><?php echo $username; ?></span>
    </div>

    <!-- container daftar makanan -->
    <div class="checkout-container">

        <?php foreach ($_SESSION['cart'] as $item) { ?>
            <div class="list">

                <!-- nama makanan -->
                <strong><?php echo $item['nama']; ?></strong>

                <!-- harga x qty -->
                <span>
                    Rp <?php echo number_format($item['harga'],0,',','.'); ?>
                    x <?php echo $item['qty']; ?>
                </span>

            </div>
        <?php } ?>

        <!-- total harga keseluruhan -->
        <div class="total">
            Total:
            <span>
                Rp <?php echo number_format($total,0,',','.'); ?>
            </span>
        </div>
    </div>

    <!-- info instruksi -->
    <p class="info">
        Tunjukkan halaman ini ke kasir untuk melanjutkan pembayaran.
    </p>

    <!-- tombol kembali ke menu (reset cart) -->
    <a href="checkout.php?clear=1" class="btn-back">Kembali</a>

</section>

<footer class="footer">
    <p>© <?php echo date("Y"); ?> Westo — All Rights Reserved</p>
</footer>

</body>
</html>
