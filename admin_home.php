<?php
require "koneksiDB.php";
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "WEH bukan admin kok mau masuk?!";
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    $result = $conn->prepare("SELECT id FROM roles WHERE username = ?");
    $result->bind_param("s", $username);
    $result->execute();
    $result->store_result();

    if($result->num_rows > 0){
        echo "<br>"."Username sudah ada yang pakai";
    } else {
        $stmt = $conn->prepare("INSERT INTO roles (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $role);
        $stmt->execute();
        echo "Anggota baru berhasil ditambahkan";
    }
}

$result = $conn->query("SELECT * FROM roles ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="body admin">
    <div class="navbar-admin">
        <a href="admin_home.php">Home</a>
        <a href="admin_daftar_menu.php">Menu</a>
        <a href="admin_profile.php">Profile</a>
    </div>
    <h2>Ini halaman admin</h2>
    <div class="adminhome">
        <div class="tabel-roles">
            <h2>Daftar Pengguna</h2>
            <table border="1" cellspacing="0" cellpadding="5">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                </tr>
                <?php while($row=$result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['username']; ?></td>
                    <td><?= $row['role']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <div class="signupAdmin">
            <h2>Daftarkan Pengguna (Admin/Kasir)</h2>
            <form method="post">
                <label for="username">Username</label><br>
                <input type="text" id="username" name="username" required><br>
                <label for="password">Password</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <select name="role" id="role">
                    <option value="admin">Admin</option>
                    <option value="kasir">Kasir</option>
                </select><br><br>
                <button type="submit">Add</button>
            </form>
        </div>
    </div>
</body>
</html>