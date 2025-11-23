<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "WEH bukan admin kok mau masuk?!";
    exit;
}

$username = $_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body class="body admin profile">
    <button onclick="history.back()">Back</button>
    <h2>Username: <?php echo $username?></h2>
    <a href="logout.php">Logout</a>
</body>
</html>