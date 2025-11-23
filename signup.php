<?php
session_start();
require "koneksiDB.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = $conn->prepare("SELECT id FROM roles WHERE username = ?");
    $result->bind_param("s", $username);
    $result->execute();
    $result->store_result();

    if($result->num_rows > 0){
        echo "<br>"."Username sudah ada yang pakai";
    } else {
        $stmt = $conn->prepare("INSERT INTO roles (username, password, role) VALUES (?, ?, 'user')");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        echo "YES berhasil sign up! Kembali ke login...";
        echo "<script>
            setTimeout(function(){
                window.location.href = 'login.php';
            }, 3000);
        </script>";
        // Nunggu 3 detik habis gitu langsung pindah ke login
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="body-signup">
    <div class="signup">
        <h2>Sign Up</h2>
        <form method="post">
            <label for="username">Username</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit">Sign Up</button>
            <a href="login.php">Login</a>
            <p>Nanti admin sama kasir bisa ditambah dari admin. Jadi sign up rolenya auto jadi user.</p>
        </form>

    </div>
</body>

</html>