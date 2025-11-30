<?php
// PASTIKAN LOKASI FILE KONEKSIDB.PHP BENAR
require "koneksiDB.php"; 
session_start();

// Cek autentikasi admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "WEH bukan admin kok mau masuk?!";
    exit;
}

// LOGIKA TAMBAH PENGGUNA BARU
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Pastikan koneksi ($conn) berhasil sebelum menggunakan prepare
    if ($conn) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $role = $_POST["role"];

        // Cek apakah username sudah ada
        $result = $conn->prepare("SELECT id FROM roles WHERE username = ?");
        $result->bind_param("s", $username);
        $result->execute();
        $result->store_result();

        if($result->num_rows > 0){
            $status_message = "Username sudah ada yang pakai";
        } else {
            // Hash password sebelum disimpan
            // $hashed_password = password_hash($password, PASSWORD_DEFAULT); 
            // NOTE: Karena kode Anda tidak menggunakan hash, saya biarkan password asli.
            
            $stmt = $conn->prepare("INSERT INTO roles (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $password, $role);
            $stmt->execute();
            $status_message = "Anggota baru berhasil ditambahkan";
        }
    } else {
        $status_message = "Koneksi database gagal. Cek XAMPP/koneksiDB.php.";
    }
}

// AMBIL DAFTAR PENGGUNA UNTUK DITAMPILKAN
if ($conn) {
    $result = $conn->query("SELECT id, username, role FROM roles ORDER BY id ASC");
} else {
    $result = null; // Agar tidak error jika koneksi gagal
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Westo</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body class="body admin">
    <header>
        <div class="nav-left">
            <div class="logo">Westo</div>
            <nav>
                <a href="admin_home.php" class="active">Home</a>
                <a href="admin_daftar_menu.php">Menu</a>
            </nav>
        </div>
    
        <a href="logout.php" class="btn-logout">Logout</a>
    </header>

    <div class="content-wrapper">
        <?php if (isset($status_message)): ?>
            <p class="status-msg"><?= $status_message; ?></p>
        <?php endif; ?>

        <h2>Panel Administrasi</h2>

        <div class="adminhome">
            <div class="tabel-roles">
                <h2>Daftar Pengguna</h2>
                <table cellspacing="0" cellpadding="5">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        </tr>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row=$result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['username']; ?></td>
                            <td><?= ucfirst($row['role']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3" style="text-align: center;">Tidak ada pengguna terdaftar.</td></tr>
                    <?php endif; ?>
                </table>
            </div>

            <div class="signupAdmin">
                <h2>Daftarkan Pengguna Baru</h2>
                <form method="post">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                    
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    
                    <label for="role">Role</label>
                    <select name="role" id="role">
                        <option value="admin">Admin</option>
                        <option value="kasir">Kasir</option>
                    </select>
                    
                    <button type="submit" class="btn-main">Add User</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>