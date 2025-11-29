<?php
session_start();

/*hapus semua item di cart*/
unset($_SESSION['cart']);

/* redirect ke menu atau cart */
header("Location: cart.php");
exit;
