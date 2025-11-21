<?php
session_start();
require "koneksiDB.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT*FROM roles
    WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows>0){
        $user = $result->fetch_assoc();

        $_SESSION["id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];

        if($user["role"]=="admin"){
            header("Location: admin_home.php");
        } else if($user["role"]=="kasir"){
            header("Location: kasir_home.php");
        }
        else {
            header("Location: user_home.php");
        }

    } else {
        echo "Username atau password salah";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="body-login">
    <div class="login">
        <h2>Login</h2>
        <form method="post">
            <label for="username">Username</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password</label><br>
            <input type="text" id="password" name="password" required><br><br>
            <button type="submit">Login</button>
        </form>

    </div>
</body>

</html>