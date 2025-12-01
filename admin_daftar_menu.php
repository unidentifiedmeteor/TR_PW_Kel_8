<?php
require "koneksiDB.php";

session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("HTTP/1.1 403 Forbidden");
    echo "WEH bukan admin kok mau masuk?!";
    exit;
}

// --- KONSTANTA & SETUP UPLOAD ---
define('UPLOAD_DIR_FS', __DIR__ . '/user/food_img/');
define('UPLOAD_DIR_URL', 'user/food_img/');
if (!is_dir(UPLOAD_DIR_FS)) {
    @mkdir(UPLOAD_DIR_FS, 0755, true); 
}


function safeUnlink($filePath) {
    if ($filePath) { // Cek apakah ada nama file
        $fullPath = UPLOAD_DIR_FS . $filePath; 
        
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}

function handleUpload($fileFieldName, &$err = null) {
    if (!isset($_FILES[$fileFieldName])) return null;
    $file = $_FILES[$fileFieldName];

    if ($file['error'] === UPLOAD_ERR_NO_FILE) return null;
    if ($file['error'] !== UPLOAD_ERR_OK) { $err = "Upload error code {$file['error']}"; return false; }
    if ($file['size'] > 5 * 1024 * 1024) { $err = "File too large (max 5MB)"; return false; }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    $allowed = ['image/jpeg'=>'.jpg','image/png'=>'.png','image/webp'=>'.webp','image/gif'=>'.gif'];
    if (!isset($allowed[$mime])) { $err = "Invalid image type"; return false; }

    $base = bin2hex(random_bytes(8));
    $ext = $allowed[$mime];
    $filename = $base . $ext;
    $dest = UPLOAD_DIR_FS . $filename;

    if (!move_uploaded_file($file['tmp_name'], $dest)) { $err = "Gagal save file"; return false; }

    
    return $filename;
}


// --- ADD DATA & UPDATE DATA & DELETE DATA
$errMsg = null; 
if (isset($_POST['tambah'])) {
    $nama = trim($_POST['nama']);
    $harga = (float)$_POST['harga']; 
    $gambarPath = handleUpload('gambar', $err);
    
    if ($gambarPath === false) { $errMsg = $err; } 
    elseif (!$nama || $harga <= 0) { 
        $errMsg = "Nama & harga harus diisi dengan benar.";
        if ($gambarPath) safeUnlink($gambarPath); 
    } else {
        $stmt = $conn->prepare("INSERT INTO menu (nama, harga, image_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $nama, $harga, $gambarPath);
        if ($stmt->execute()) {
            $stmt->close();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $errMsg = "❌ Gagal menambah data: " . $stmt->error;
            $stmt->close();
            if ($gambarPath) safeUnlink($gambarPath); 
        }
    }
}

// ... Logika UPDATE dan DELETE
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $nama = trim($_POST['nama']);
    $harga = (float)$_POST['harga'];
    $gambarPath = handleUpload('gambar', $err);
    
    if ($gambarPath === false) { $errMsg = $err; } 
    elseif (!$nama || $harga <= 0) { 
        $errMsg = "Nama & harga harus diisi dengan benar.";
        if ($gambarPath) safeUnlink($gambarPath); 
    } else {
        $stmt = $conn->prepare("SELECT image_path FROM menu WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $oldImage = $res['image_path'] ?? null;
        $imagePath = ($gambarPath === null) ? $oldImage : $gambarPath; 
        $stmt = $conn->prepare("UPDATE menu SET nama=?, harga=?, image_path=? WHERE id=?"); 
        $stmt->bind_param("sdsi", $nama, $harga, $imagePath, $id);        if ($stmt->execute()) {
            if ($gambarPath !== null && $oldImage) { safeUnlink($oldImage); }
            $stmt->close();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $errMsg = "❌ Gagal update data: " . $stmt->error;
            $stmt->close();
            if ($gambarPath) safeUnlink($gambarPath);
        }
    }
}
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?"); 
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $result = $stmt->get_result(); 
    $editData = $result->fetch_assoc(); 
    $stmt->close();
}
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $stmt = $conn->prepare("SELECT image_path FROM menu WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $oldImage = $res['image_path'] ?? null;
    $stmt->close();
    $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?"); 
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $stmt->close();
    if ($oldImage) safeUnlink($oldImage);
    header("Location: admin_daftar_menu.php");
    exit;
}


$result = $conn->query("SELECT * FROM menu ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Menu Admin</title>
    <link rel="stylesheet" href="admin_menu.css"> 
    </head>
<body class="body menu">
    <header>
        <div class="nav-left">
            <div class="logo">Westo</div>
            <nav>
                <a href="admin_home.php">Home</a>
                <a href="admin_daftar_menu.php" class="active">Menu</a>
            </nav>
        </div>
        <a href="logout.php" class="btn-logout">Logout</a>
    </header>
    
    <div class="content-wrapper">
        <h2>Daftar Menu Makanan</h2>
        
        <?php if (!empty($errMsg)): ?>
            <p class="status-msg error-msg"><?= htmlspecialchars($errMsg); ?></p>
        <?php endif; ?>

        <?php if (isset($_GET['edit']) && $editData): ?>
            <p class="status-msg info-msg">Anda sedang dalam mode Edit ID: <?= htmlspecialchars($editData['id']); ?></p>
        <?php endif; ?>
        
        <div class="adminhome menu-wrapper"> 
            <div class="formCon signupAdmin">
                <h2><?= $editData ? "Edit Data: " . htmlspecialchars($editData['nama']) : "Tambah Menu Baru"; ?></h2>
                <form method="post" enctype="multipart/form-data">
                    <?php if ($editData): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($editData['id']); ?>">
                    <?php endif; ?>
    
                    <label for="nama">Nama Menu</label>
                    <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($editData['nama'] ?? ''); ?>" required>
                    
                    <label for="harga">Harga (Rp)</label>
                    <input type="number" step="any" name="harga" id="harga" value="<?= htmlspecialchars($editData['harga'] ?? ''); ?>" required>
                    
                    <label for="gambar">Gambar</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*" <?= empty($editData) ? 'required' : '' ?> >
    
                    <?php if (!empty($editData) && !empty($editData['image_path'])): ?>
                        <div style="margin-top:10px;">
                            <p style="font-size:12px; color:#aaa; margin-bottom:5px;">Gambar Saat Ini:</p>
                            <img src="<?= htmlspecialchars(UPLOAD_DIR_URL . $editData['image_path']); ?>" style="width:100px; height:auto; border-radius:5px;">
                        </div>
                    <?php endif; ?>

                    <div style="margin-top: 20px;">
                        <?php if (!empty($editData)): ?>
                            <button type="submit" name="update" class="btn-main">Update Data</button>
                            <a href="admin_daftar_menu.php" class="btn-secondary">Batal Edit</a>
                        <?php else: ?>
                            <button type="submit" name="tambah" class="btn-main">Tambah Menu</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        
            <div class="tabel-menu tabel-roles">
                <h2>Daftar Menu</h2>
                <table cellpadding="5" cellspacing="0">
                    <tr>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']); ?></td>
                            <td>
                                <?php if (!empty($row['image_path'])): ?>
                                    <img src="<?= htmlspecialchars(UPLOAD_DIR_URL . $row['image_path']); ?>" alt="<?= htmlspecialchars($row['nama']); ?>" style="width:70px;height:50px;object-fit:cover; border-radius:3px;">
                                <?php else: ?>
                                    <span style="color:#777;">(no img)</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['nama']); ?></td>
                            <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td class="action-links">
                                <a href="?edit=<?= htmlspecialchars($row['id']); ?>" class="action-edit">Edit</a> |
                                <a href="?hapus=<?= htmlspecialchars($row['id']); ?>" onclick="return confirm('Yakin ingin hapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>