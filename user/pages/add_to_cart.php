<?php
session_start();

/* ambil data dari form yg dikirim dari menu.php */
$id = $_POST['id'];
$nama = $_POST['nama'];
$harga = $_POST['harga'];
$image = $_POST['image'];

/* cek apakah item ini sudah pernah dimasukkan ke cart sebelumnya */
if (!isset($_SESSION['cart'][$id])) {

    /* jika belum ada, buat item baru di session cart */
    $_SESSION['cart'][$id] = [
        'id' => $id,
        'nama' => $nama,
        'harga' => $harga,
        'image' => $image,
        'qty' => 1 /* qty default 1 saat baru dimasukkan */
    ];
} else {

    /* kalau item sudah ada di cart, cukup tambahkan jumlahnya */
    $_SESSION['cart'][$id]['qty'] += 1;
}

/* redirect balik ke halaman menu setelah item ditambahkan */
header("Location: menu.php");
exit;
