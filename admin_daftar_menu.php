<?php
require "koneksiDB.php";

session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "WEH bukan admin kok mau masuk?!";
    exit;
}

define('UPLOAD_DIR_FS', __DIR__ . '/gambar_makanan/');
define('UPLOAD_DIR_URL', 'gambar_makanan/');
if (!is_dir(UPLOAD_DIR_FS)) mkdir(UPLOAD_DIR_FS, 0755, true);

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

    return UPLOAD_DIR_URL . $filename;
}


// --- ADD DATA ---
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $err = null;
    $gambarPath = handleUpload('gambar', $err);
    if ($gambarPath === false) {
        $errMsg = $err; // upload failed
    } elseif (!$nama || $harga <= 0) {
        $errMsg = "Nama & harga harus diisi dengan benar.";
        // cleanup if file was uploaded but validation failed
        if ($gambarPath && is_file(__DIR__ . '/' . $gambarPath)) @unlink(__DIR__ . '/' . $gambarPath);
    } else {
        $stmt = $conn->prepare("INSERT INTO menu (nama, harga, image_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $nama, $harga, $gambarPath);
        if ($stmt->execute()) {
            // Successful insert -> redirect to avoid form re-submit
            $stmt->close();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $errMsg = "❌ Gagal menambah data: " . $stmt->error;
            $stmt->close();
            // cleanup uploaded file if DB insert failed
            if ($gambarPath && is_file(__DIR__ . '/' . $gambarPath)) @unlink(__DIR__ . '/' . $gambarPath);
        }
    }
}

// --- UPDATE DATA ---
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $err = null;
    $gambarPath = handleUpload('gambar', $err);
    if ($gambarPath === false) {
        $errMsg = $err;
    } 
    elseif (!$nama || $harga == '') {
        $errMsg = "Nama & harga harus diisi dengan benar.";
        if ($gambarPath && is_file(__DIR__ . '/' . $gambarPath)) @unlink(__DIR__ . '/' . $gambarPath);
    } 

 else {

        //ambil gambar lama
        $stmt = $conn->prepare("SELECT image_path FROM menu WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();                                                    
        $res = $stmt->get_result()->fetch_assoc();                           
        $stmt->close();                                                      

        $oldImage = $res['image_path'] ?? null;  

        $imagePath = ($gambarPath === null) ? $oldImage : $gambarPath; 

        $stmt = $conn->prepare("UPDATE menu SET nama=?, harga=?, image_path=? WHERE id=?"); 
        $stmt->bind_param("sssi", $nama, $harga, $imagePath, $id);                           

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: " . $_SERVER['PHP_SELF']); 
            exit;
        } 
        else {
            $errMsg = "❌ Gagal update data: " . $stmt->error;
            $stmt->close();

            if ($gambarPath && is_file(__DIR__ . '/' . $gambarPath)) @unlink(__DIR__ . '/' . $gambarPath);
        }
    }
}

// --- MODE EDIT ---
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    
    $stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?"); 
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $result = $stmt->get_result(); 
    $editData = $result->fetch_assoc(); 
    $stmt->close();
}

// Buat READ
$result = $conn->query("SELECT * FROM menu ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Menu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="menu-body">
    <div class="navbar-admin">
        <a href="admin_home.php">Home</a>
        <a href="admin_daftar_menu.php">Menu</a>
        <a href="admin_profile.php">Profile</a>
    </div>
    <h1>Daftar menu</h1>
    <div class="semuanya">
        <div class="formCon">
            <h2><?= $editData ? "Edit Data" : "Tambah Data"; ?></h2>
            <form method="post" enctype="multipart/form-data">
                <?php if ($editData): ?>
                    <input type="hidden" name="id" value="<?= $editData['id']; ?>">
                <?php endif; ?>
    
                Nama:<br>
                <input type="text" name="nama" value="<?= $editData['nama'] ?? ''; ?>" required><br>
                Harga:<br>
                <input type="text" name="harga" value="<?= $editData['harga'] ?? ''; ?>" required><br>
                Gambar:<br>
                <input type="file" name="gambar" accept="image/*" <?= empty($editData) ? 'required' : '' ?> ><br>
    
                <?php if (!empty($editData)): ?>
                    <button type="submit" name="update">Update</button>
                    <a href="admin_daftar_menu.php">Batal</a>
                <?php else: ?>
                    <button type="submit" name="tambah">Tambah</button>
                <?php endif; ?>
            </form>
        </div>
    
        <div class="tabel-menu">
            <h2>Menu Makanan</h2>
            <table border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $row['harga']; ?></td>
                        <td>
                            <?php if (!empty($row['image_path'])): ?>
                                <img src="<?= htmlspecialchars($row['image_path']); ?>" style="width:100px;height:70px;object-fit:cover">
                            <?php else: ?>
                                (no image)
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="?edit=<?= $row['id']; ?>">Edit</a> |
                            <a href="?hapus=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin hapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>