<?php
session_start();
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!');</script>";
    echo "<script>window.location='login.php';</script>";
    exit();
}

// Memasukkan file koneksi database
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_SESSION['userid'];
    $judulfoto = $_POST['judulfoto'];
    $deskripsifoto = $_POST['deskripsifoto'];
    $albumid = $_POST['albumid'];

    // Proses upload file
    $lokasifile = $_FILES['lokasifile']['name'];
    $tmp_file = $_FILES['lokasifile']['tmp_name'];

    // Menentukan lokasi penyimpanan file
    $upload_dir = 'foto/';
    $upload_file = $upload_dir . basename($lokasifile);

    // Memindahkan file yang diupload ke folder yang ditentukan
    if (move_uploaded_file($tmp_file, $upload_file)) {
        // Mendapatkan tanggal saat ini
        $tanggalunggah = date('Y-m-d H:i:s'); // Format tanggal untuk MySQL

        // Menyimpan data ke database
        $sql = "INSERT INTO foto (judulfoto, deskripsifoto, lokasifile, tanggalunggah, albumid, userid) VALUES ('$judulfoto', '$deskripsifoto', '$lokasifile', '$tanggalunggah', '$albumid', '$userid')";

        if (mysqli_query($conn, $sql)) {
            // Alert untuk pesan sukses
            echo "<script>alert('Foto berhasil ditambahkan!'); window.location='foto.php';</script>";
        } else {
            // Alert untuk pesan error saat menyimpan data ke database
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        // Alert untuk pesan gagal upload file
        echo "<script>alert('Gagal mengupload file.');</script>";
    }
}

mysqli_close($conn);
?>
