<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>FORM PENDAFTARAN</h1>
    <form action="halaman2.php" method="POST">
        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama" required><br><br>

        <label for="alamat">Alamat:</label><br>
        <input type="text" id="alamat" name="alamat" required><br><br>

        <label for="jenis_kelamin">Jenis Kelamin:</label><br>
        <input type="radio" id="laki-laki" name="jenis_kelamin" value="Laki-laki" required>
        <label for="laki-laki">Laki-laki</label><br>
        <input type="radio" id="perempuan" name="jenis_kelamin" value="Perempuan">
        <label for="perempuan">Perempuan</label><br><br>

        <label for="agama">Agama:</label><br>
        <select id="agama" name="agama" required>
            <option value="">Pilih Agama</option>
            <option value="Islam">Islam</option>
            <option value="Kristen">Kristen</option>
            <option value="Hindu">Hindu</option>
            <option value="Budha">Budha</option>
            <option value="Konghucu">Konghucu</option>
        </select><br><br>

        <label for="sekolah_asal">Sekolah Asal:</label><br>
        <input type="text" id="sekolah_asal" name="sekolah_asal" required><br><br>

        <input type="submit" value="Submit">
    
</body>
</html>