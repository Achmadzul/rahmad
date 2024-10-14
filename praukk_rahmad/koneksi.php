<?php
// Koneksi ke database
$host = 'localhost'; // atau IP database server Anda
$user = 'root'; // username database
$password = ''; // password database
$dbname = 'galery'; // ganti dengan nama database Anda

// Membuat koneksi
$conn = mysqli_connect($host, $user, $password, $dbname);

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
