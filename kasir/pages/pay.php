<?php
session_start();
include "../../koneksiDB.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'kasir') {
    echo "Anda bukan kasir!";
    exit;
}

$user_id = $_GET['user_id'];

$q = mysqli_query($conn,"
    SELECT tr_orders.*, menu.nama, roles.username
    FROM tr_orders
    JOIN menu ON menu.id = tr_orders.menu_id
    JOIN roles ON roles.id = tr_orders.order_by_user_id
    WHERE order_by_user_id='$user_id' AND status='pending'
");

$total = 0;
$data = [];

while ($row = mysqli_fetch_assoc($q)) {
    $total += $row['total_price'];
    $data[] = $row;
}

$username = $data[0]['username'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran</title>
    <link rel="stylesheet" href="../assets/pay.css">
</head>
<body>

<a href="orders.php" class="back">← Kembali</a>

<div class="struk">
    <h2>Detail Pembelian</h2>

    <?php if (count($data) == 0) { ?>
        <div class="item">Tidak ada pesanan.</div>

    <?php } else { ?>

        <div class="buyer">Pelanggan: <b><?php echo $username; ?></b></div>
        <hr>

        <?php foreach($data as $d) { ?>
            <div class="item">
                <?php echo $d['nama']; ?> x<?php echo $d['quantity']; ?><br>
                Rp <?php echo number_format($d['total_price'],0,',','.'); ?>
            </div>
        <?php } ?>

        <div class="total">
            Total: <b>Rp <?php echo number_format($total,0,',','.'); ?></b>
        </div>

        <?php
        if (isset($_POST['btn_bayar'])) {

            $bayar = $_POST['bayar'];
            $kembalian = $bayar - $total;

            if ($kembalian < 0) {
                echo "<div class='notif error'>Uang kurang!</div>";
            } else {

                $now = date("Y-m-d H:i:s");

                mysqli_query($conn,"
                    UPDATE tr_orders SET status='done'
                    WHERE order_by_user_id='$user_id' AND status='pending'
                ");
                ?>

                <div class="result-box">
                    <h2>Westo</h2>
                    <h3>Pembayaran Sukses</h3>

                    <p><b>Pelanggan:</b> <?php echo $username; ?></p>
                    <p><b>Tanggal:</b> <?php echo $now; ?></p>
                    <p><b>Total:</b> Rp <?php echo number_format($total,0,',','.'); ?></p>
                    <p><b>Bayar:</b> Rp <?php echo number_format($bayar,0,',','.'); ?></p>
                    <p><b>Kembalian:</b> Rp <?php echo number_format($kembalian,0,',','.'); ?></p>

                    <button onclick="window.print()" class="btn-print">Print Struk</button>
                </div>

                <?php
                exit;
            }
        }
        ?>

        <form method="POST" class="input-area">
            <label>Uang Pembeli:</label>
            <input type="number" name="bayar" required>
            <button type="submit" name="btn_bayar">Selesaikan Pembayaran</button>
        </form>

    <?php } ?>
</div>

</body>
</html>
