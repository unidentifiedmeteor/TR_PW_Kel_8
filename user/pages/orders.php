<?php
session_start();
include "../../koneksiDB.php";

/* jika user belum login diarahkan ke halaman login */
if (!isset($_SESSION['id'])) {
    header("Location: ../../login.php");
    exit;
}

/* ambil id user dari session */
$user_id = $_SESSION['id'];

/*ambil semua pesanan berdasarkan user login */
$orders = mysqli_query($conn,"
    SELECT tr_orders.*, menu.nama, menu.image_path 
    FROM tr_orders 
    JOIN menu ON menu.id = tr_orders.menu_id
    WHERE order_by_user_id='$user_id'
    ORDER BY tr_orders.id DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Orders — Westo</title>
    <link rel="stylesheet" href="../assets/orders.css">
</head>
<body>

<header>
    <div class="logo">Westo</div>
    <nav>
        <a href="../../user_home.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="orders.php" class="active">Orders</a>
    </nav>

    <div class="header-icons">
        <a href="cart.php">
            <img src="../assets/carticon.png" class="icon-img">
        </a>
    </div>
</header>


<section class="orders-section">
    <h1>Your Orders</h1>

    <?php if (mysqli_num_rows($orders) == 0) { ?>
        <p class="empty">Belum ada pesanan 🫣</p>
    <?php } else { ?>

    <div class="orders-container">

        <!-- loop untuk tampilkan setiap item order -->
        <?php while ($row = mysqli_fetch_assoc($orders)) { ?>
            <div class="order-card">

                <img src="../food_img/<?php echo $row['image_path']; ?>" class="order-img">

                <div class="order-info">
                    <h3><?php echo $row['nama']; ?></h3>

                    <p>Qty: <?php echo $row['quantity']; ?></p>
                    <p>Total:
                        <b>Rp <?php echo number_format($row['total_price'],0,',','.'); ?></b>
                    </p>

                     <!-- status pesanan pending/done -->
                    <span class="status <?php echo $row['status']; ?>">
                        <?php echo ucfirst($row['status']); ?>
                    </span>
                </div>

            </div>
        <?php } ?>

    </div>
    <?php } ?>

</section>

<footer class="footer">
    <p>© <?php echo date("Y"); ?> Westo — All Rights Reserved</p>
</footer>

</body>
</html>
