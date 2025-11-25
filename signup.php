<?php
session_start();
require "koneksiDB.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Cek username sudah digunakan atau belum
    $result = $conn->prepare("SELECT id FROM roles WHERE username = ?");
    $result->bind_param("s", $username);
    $result->execute();
    $result->store_result();

    if($result->num_rows > 0){
        $error = "Username sudah dipakai!";
    } else {
        // Insert user baru dengan role otomatis "user"
        $stmt = $conn->prepare("INSERT INTO roles (username, password, role) VALUES (?, ?, 'user')");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        echo "Berhasil Sign Up! Pindah ke login...";
        echo "<script>
            setTimeout(function(){
                window.location.href = 'login.php';
            }, 2000);
        </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Westo</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">
    <div class="main-box">

        <!-- Bagian kiri -->
        <div class="left">
            <h1 class="logo">Westo</h1>
            <img src="gambar_makanan/img1.png" class="food-img">
        </div>

        <!-- Bagian kanan -->
        <div class="right">
            <div class="login-card">

                <h2 class="title">Sign Up</h2>

                <?php if(isset($error)) : ?>
                    <div class="error"><?= $error ?></div>
                <?php endif; ?>

                <form method="post">

                    <label>Username</label>
                    <input type="text" name="username" placeholder="Buat username" required>

                    <label>Password</label>
                    <input type="password" name="password" placeholder="Buat password" required>

                    <button type="submit" class="btn-login">Sign Up</button>

                    <div class="divider">sudah punya akun?</div>

                    <div class="icons">
                        <a href="login.php" style="color:orange; text-decoration:none; font-size: 22px; font-weight: bold;">Login</a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

</body>
</html>
