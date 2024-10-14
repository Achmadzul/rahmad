<?php
session_start();
include "koneksi.php"; // Sesuaikan jalur ke file koneksi database Anda

// Ambil data dari form
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$namalengkap = mysqli_real_escape_string($conn, $_POST['namalengkap']);
$alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

// Cek apakah email sudah terdaftar
$email_check_query = "SELECT * FROM user WHERE email='$email' LIMIT 1";
$result = mysqli_query($conn, $email_check_query);
$user = mysqli_fetch_assoc($result);

if ($user) { // Jika email sudah ada di database
    echo "<script>alert('Email sudah terdaftar. Silakan gunakan email lain.'); window.history.back();</script>";
    exit();
}

// Simpan password dalam bentuk plaintext (tidak disarankan)
$sql = "INSERT INTO user (username, password, email, namalengkap, alamat) 
        VALUES ('$username', '$password', '$email', '$namalengkap', '$alamat')";

if (mysqli_query($conn, $sql)) {
    // Jika registrasi berhasil, simpan sesi pengguna dan alihkan ke halaman utama
    $_SESSION['userid'] = mysqli_insert_id($conn);
    $_SESSION['username'] = $username;
    $_SESSION['namalengkap'] = $namalengkap;
    header("Location: login.php"); // Alihkan ke halaman utama setelah registrasi
    exit();
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Tutup koneksi
mysqli_close($conn);
?>
