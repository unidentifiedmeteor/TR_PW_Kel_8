<?php
session_start();

// koneksi
require_once "koneksiDB.php";

// kalau tombol login ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM roles WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        $_SESSION["id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];

        // redirect sesuai role
        if ($user["role"] == "admin") {
            header("Location: admin_home.php");
        } 
        else if ($user["role"] == "kasir") {
            header("Location: kasir/pages/kasir_home.php");
        } 
        else {
            header("Location: user_home.php");
        }
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Westo - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="main-box">

        <div class="left">
            <h1 class="logo">Westo</h1>
            <img src="gambar_makanan/img1.png" class="food-img">
        </div>

        <div class="right">
            <div class="login-card">

                <h2 class="title">Sign In</h2>

                <?php if (isset($error)) { ?>
                    <p style="color:red; margin-bottom:10px;">
                        <?php echo $error; ?>
                    </p>
                <?php } ?>

                <form method="post">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Username" required>

                    <label>Password</label>
                    <input type="password" name="password" placeholder="Password" required>

                    <button type="submit" class="btn-login">Sign In</button>

                    <p class="signup-prompt">
                        Belum punya akun? 
                        <a href="signup.php" class="signup-link">Sign Up</a>
                    </p>

                    <div class="divider">or sign in with</div>
                    <div class="icons">
                        <img src="gambar_makanan/fb.png">
                        <img src="gambar_makanan/gugel.png">
                    </div>

                </form>            

            </div>
        </div>
    </div>
</div>
</body>
</html>
