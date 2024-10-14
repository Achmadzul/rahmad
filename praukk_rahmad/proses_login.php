<?php
include "koneksi.php";
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// Escape input untuk menghindari SQL Injection
$username = mysqli_real_escape_string($conn, $username); // Menggunakan $conn
$password = mysqli_real_escape_string($conn, $password); // Menggunakan $conn

$sql = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND password='$password'");

// Cek apakah query berhasil dijalankan
if ($sql) {
    $cek = mysqli_num_rows($sql);

    if ($cek == 1) {
        while ($data = mysqli_fetch_array($sql)) {
            $_SESSION['userid'] = $data['userid'];
            $_SESSION['namalengkap'] = $data['namalengkap'];
            $_SESSION['role'] = $data['role']; // Pastikan 'role' disimpan
        }
        header("Location: index.php?message=Login berhasil!"); // Notifikasi berhasil login
    } else {
        header("Location: login.php?message=Login%20gagal!%20Periksa%20username%20dan%20password."); // Notifikasi gagal login
    }
} else {
    // Jika query gagal, tampilkan pesan error
    echo "Error: " . mysqli_error($conn);
}
?>
