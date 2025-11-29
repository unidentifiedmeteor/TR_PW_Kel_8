<?php
session_start();
/* mulai session untuk menyimpan data user & cart */

include "../../koneksiDB.php";
/* include koneksi ke database */

// cek user harus login
if (!isset($_SESSION['id'])) {
    header("Location: ../../login.php");
    exit;
}/* jika tidak ada session user id → arahkan ke login */


$user_id = $_SESSION['id'];
/* simpan id user untuk kebutuhan lain seperti orders */

$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
/* menghitung jumlah item di cart untuk badge icon */


$search = isset($_GET['search']) ? trim($_GET['search']) : '';
/* menangkap inputan search user di URL */

if ($search !== '') {
     /* klo user masukin kata pencarian */
    $s = mysqli_real_escape_string($conn, $search);
    /* mengamankan input biar gak kena SQL injection */
    $menu = mysqli_query($conn, "SELECT * FROM menu WHERE nama LIKE '%$s%'");
    /* filter data menu berdasarkan nama */
} else {
    $menu = mysqli_query($conn, "SELECT * FROM menu");
    /* klo gak searching, ambil seluruh menu */
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu — Westo</title>
    <link rel="stylesheet" href="../assets/menu.css">
</head>

<body class="page">

<header>
    <!-- bagian navbar aplikasi -->
    <div class="logo">Westo</div>
    <nav>
        <a href="../../user_home.php">Home</a>
        <a href="menu.php" class="active">Menu</a>
        <a href="orders.php">Orders</a>
    </nav>

     <!-- bagian kanan header berisi search dan cart -->
    <div class="header-icons">

        <form class="search-area" action="" method="GET">
        <!-- form GET buat tampilin keyword di URL -->

            <input type="text" name="search" class="search" placeholder="Search menu..."
                value="<?php echo htmlspecialchars($search); ?>">
                <!-- input search dengan value yang tetap tersimpan -->
        </form>

        <div class="cart-wrapper">
        <!-- pembungkus cart icon dan badge -->

            <a href="cart.php">
                <img src="../assets/carticon.png" class="icon-img">
            </a>

            <?php if ($cart_count > 0) { ?>
                <span class="badge"><?php echo $cart_count; ?></span>
                <!-- badge jumlah item keranjang -->
            <?php } ?>
        </div>
    </div>
</header>


<section class="menu-section">
<!-- area konten utama -->

    <h1>Our Delicious Menu</h1>
    <p class="sub">Choose your favorite food</p>

    <div class="menu-container">
     <!-- grid yang berisi semua card menu -->

        <?php while($m = mysqli_fetch_array($menu)) { ?>
        <!-- loop semua menu dari database -->

        <div class="card">
         <!-- card individual -->

            <img src="../food_img/<?php echo $m['image_path']; ?>">
            <!-- menampilkan gambar makanan -->

            <h3><?php echo $m['nama']; ?></h3>
            <h4>Rp <?php echo number_format($m['harga'], 0, ',', '.'); ?></h4>
            <!-- harga makanan yg diformat -->

            <form action="add_to_cart.php" method="post">
            <!-- form kirim data ke keranjang -->
                <input type="hidden" name="id" value="<?php echo $m['id']; ?>">
                <input type="hidden" name="nama" value="<?php echo $m['nama']; ?>">
                <input type="hidden" name="harga" value="<?php echo $m['harga']; ?>">
                <input type="hidden" name="image" value="<?php echo $m['image_path']; ?>">
                <!-- data ditampung hidden agar user tidak ubah -->

                <button class="btn-order">Add to Cart</button>
                <!-- tombol untuk menambahkan produk ke keranjang -->
                
            </form>
        </div>
        <?php } ?>
    </div>
</section>

<footer class="footer">
    <p>© <?php echo date("Y"); ?> Westo — All Rights Reserved</p>
</footer>

</body>
</html>