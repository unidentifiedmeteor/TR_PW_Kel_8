<?php
session_start();
include "../../koneksiDB.php";

if (!isset($_SESSION['id'])) {
    die("Error: user belum login");
    /* memastikan hanya user login yang bisa akses cart */
}

$user_id = $_SESSION['id'];
/* simpan id user dari session */

/* jika tombol checkout ditekan */
if (isset($_POST['checkout'])) {

    /* lakukan insert ke tabel tr_orders untuk setiap item keranjang */
    foreach ($_SESSION['cart'] as $item) {

        $menu_id = $item['id'];
        $qty = $item['qty'];
        $subtotal = $item['harga'] * $item['qty'];

        mysqli_query($conn,"INSERT INTO tr_orders(menu_id, quantity, order_by_user_id, order_date, total_price, status)
            VALUES('$menu_id','$qty','$user_id',NOW(),'$subtotal','pending')");
    }

    /*  keranjang dihapus setelah kasir memproses pembayaran */
    // unset($_SESSION['cart']);

    /* diarahkan ke halaman checkout */
    header("Location: checkout.php");
    exit;
}


/* bagian update qty atau hapus item */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    $id = $_POST['id']; /* id menu yang akan diubah */

    switch ($_POST['action']) {
        case 'increment':
            $_SESSION['cart'][$id]['qty']++;
            break;

        case 'decrement':
            $_SESSION['cart'][$id]['qty']--;
            if ($_SESSION['cart'][$id]['qty'] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
            break;

        case 'remove': /* hapus item */
            unset($_SESSION['cart'][$id]);
            break;
    }

    /* refresh halaman biar qty langsung berubah */
    header("Location: cart.php");
    exit;
}

/* hitung total harga semua item */
$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['harga'] * $item['qty'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart — Westo</title>
    <link rel="stylesheet" href="../assets/cart.css">
</head>
<body>

<header>
    <div class="logo">Westo</div>
    <nav>
        <a href="../../user_home.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="orders.php">Orders</a>
    </nav>

    <div class="header-icons">
        <a href="cart.php" class="active">
            <img src="../assets/carticon.png" class="icon-img">
        </a>
    </div>
</header>

<section class="cart-section">
    <h1>Your Cart</h1>

    <!-- klo keranjang kosong -->
    <?php if (empty($_SESSION['cart'])) { ?>
        <p class="empty">Cart kamu masih kosong</p>
    
     <!-- klo keranjang ada isinya -->
    <?php } else { ?>

        <!-- container semua item di cart -->
        <div class="cart-container">

            <!-- looping setiap item yang ada di session cart -->
            <?php foreach ($_SESSION['cart'] as $item) { ?>

                <!-- satu items -->
                <div class="cart-item">
                    <img src="../food_img/<?php echo $item['image']; ?>" class="cart-img">

                    <!-- info menu -->
                    <div class="cart-info">

                        <!-- harga satuan x qty -->
                        <h3><?php echo $item['nama']; ?></h3>
                        <p>Rp <?php echo number_format($item['harga'],0,',','.'); ?> × 
                            <?php echo $item['qty']; ?> =
                            <b>Rp <?php echo number_format($item['harga']*$item['qty'],0,',','.'); ?></b>
                        </p>

                        <!-- tombol untuk tambah qty, kurang qty, hapus item -->
                        <div class="cart-buttons">
                            <form method="post">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="action" value="increment">
                                <button class="btn-qty">+</button>
                            </form>

                            <form method="post">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="action" value="decrement">
                                <button class="btn-qty">-</button>
                            </form>

                            <form method="post">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="action" value="remove">
                                <button class="btn-remove">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>

         <!-- bagian total harga & checkout -->
        <div class="cart-summary">
            <a href="menu.php" class="btn-back">Kembali</a>

            <div>
                <!-- total harga seluruh isi cart -->
                <h3>Total: Rp <?php echo number_format($total,0,',','.'); ?></h3>
            </div>

            <form method="POST">
                <!-- tombol checkout -->
               <button type="submit" name="checkout" value="1" class="btn-checkout">

                    Checkout
                </button>
            </form>
        </div>
    <?php } ?>

</section>

<footer class="footer">
    <p>© <?php echo date("Y"); ?> Westo — All Rights Reserved</p>
</footer>

</body>
</html>