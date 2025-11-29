<?php
session_start();
include "../../koneksiDB.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'kasir') {
    echo "Anda bukan kasir!";
    exit;
}

$orders = mysqli_query($conn,"
    SELECT order_by_user_id,
           SUM(total_price) AS total,
           roles.username
    FROM tr_orders
    JOIN roles ON roles.id = tr_orders.order_by_user_id
    WHERE status='pending'
    GROUP BY order_by_user_id
    ORDER BY order_by_user_id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Masuk — Kasir</title>
    <link rel="stylesheet" href="../assets/orders.css">
</head>
<body>

<header>
    <div class="nav-left">
        <div class="logo">Westo</div>
        <nav>
            <a href="kasir_home.php">Home</a>
            <a class="active" href="orders.php">Orders</a>
        </nav>
    </div>

    <form method="POST" action="../../logout.php">
        <button class="btn-logout">Logout</button>
    </form>
</header>

<section class="orders-section">
    <h1>Pesanan Masuk</h1>
    <?php if (mysqli_num_rows($orders) == 0) { ?>
        <p class="empty">Belum ada pesanan</p>
    <?php } else { ?>

    <div class="orders-container">
        <?php while ($row = mysqli_fetch_assoc($orders)) { ?>
        <div class="order-card">

            <div class="order-left">
                <h2><?php echo $row['username']; ?></h2>
                
                <p>Total Tagihan:
                    <b>Rp <?php echo number_format($row['total'],0,',','.'); ?></b>
                </p>
            </div>

            <form action="pay.php" method="GET">
                <input type="hidden" name="user_id" value="<?php echo $row['order_by_user_id']; ?>">
                <button class="btn-proses">Proses</button>
            </form>

        </div>
        <?php } ?>
    </div>

    <?php } ?>
</section>

</body>
</html>
