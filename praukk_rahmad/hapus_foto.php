<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit;
}

include "koneksi.php";
if (isset($_GET['fotoid'])) {
    $fotoid = mysqli_real_escape_string($conn, $_GET['fotoid']);
    
    $sql = mysqli_query($conn, "DELETE FROM foto WHERE fotoid='$fotoid'");

    if ($sql) {
        echo "<script>alert('Foto berhasil dihapus.'); window.location.href='foto.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus foto.'); window.location.href='foto.php';</script>";
    }
}
?>
