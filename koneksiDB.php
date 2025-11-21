<?php
$host="localhost";
$user="root";
$pass="";
$db = "tr_pwrestoran";

$conn = new mysqli(hostname: $host, username: $user, password: $pass, database:$db);

if($conn){
    echo "Koneksi berhasil";
} else {
    echo "Koneksi gagal";
}
?>