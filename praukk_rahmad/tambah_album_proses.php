<?php
// tambah_album_proses.php

session_start();
include "koneksi.php";

// Cek apakah user sudah login
if(!isset($_SESSION['userid'])){
    header("location:login.php");
    exit();
}

// Ambil data dari form tambah album
$namaalbum = mysqli_real_escape_string($conn, $_POST['namaalbum']);
$deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
$userid = $_SESSION['userid'];

// Validasi input form
if(empty($namaalbum) || empty($deskripsi)){
    echo "Nama album dan deskripsi tidak boleh kosong.";
    exit();
}

// Query untuk memasukkan data album ke database
$sql = "INSERT INTO album (namaalbum, deskripsi, userid, tanggaldibuat) VALUES ('$namaalbum', '$deskripsi', '$userid', NOW())";

// Eksekusi query
if(mysqli_query($conn, $sql)){
    // Jika berhasil, redirect ke halaman album.php
    header("Location: album.php");
    exit();
} else {
    // Jika ada kesalahan, tampilkan pesan error
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>
