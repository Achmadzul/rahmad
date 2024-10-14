<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:login.php");
    exit;
}

include "koneksi.php";

$fotoid = $_GET['fotoid']; // Mendapatkan ID foto dari URL
$userid = $_SESSION['userid']; // User ID yang sedang login
$role = $_SESSION['role']; // Peran user (admin atau user biasa)

// Mengecek apakah foto tersebut milik user yang login atau user adalah admin
$sql = mysqli_query($conn, "SELECT * FROM foto WHERE fotoid='$fotoid'");
$data = mysqli_fetch_array($sql);

// Jika foto tidak ditemukan atau user bukan admin dan bukan pemilik foto, akses ditolak
if (!$data || ($data['userid'] != $userid && $role != 'admin')) {
    echo "Akses ditolak. Anda tidak memiliki izin untuk mengedit foto ini.";
    exit;
}

// Menambahkan daftar album
$album_options = '';
if ($role == 'admin') {
    $album_sql = mysqli_query($conn, "SELECT * FROM album");
} else {
    $album_sql = mysqli_query($conn, "SELECT * FROM album WHERE userid='$userid'");
}

while ($album_data = mysqli_fetch_array($album_sql)) {
    $selected = ($album_data['albumid'] == $data['albumid']) ? 'selected' : '';
    $album_options .= "<option value='{$album_data['albumid']}' $selected>{$album_data['namaalbum']}</option>";
}

if (isset($_POST['update'])) {
    $judul = $_POST['judulfoto'];
    $deskripsi = $_POST['deskripsifoto'];
    $albumid = $_POST['albumid']; // Mengambil albumid dari form

    // Proses upload file jika ada gambar baru
    if ($_FILES['lokasifile']['name']) {
        // Dapatkan ekstensi file
        $ext = pathinfo($_FILES['lokasifile']['name'], PATHINFO_EXTENSION);
        // Buat nama file baru menggunakan uniqid dan tambahkan ekstensi
        $lokasi_file = uniqid() . '.' . $ext;

        // Pindahkan file ke folder dengan nama baru
        move_uploaded_file($_FILES['lokasifile']['tmp_name'], "foto/$lokasi_file");
    } else {
        $lokasi_file = $data['lokasifile']; // Gunakan gambar lama jika tidak ada yang baru diupload
    }

    $update = mysqli_query($conn, "UPDATE foto SET judulfoto='$judul', deskripsifoto='$deskripsi', albumid='$albumid', lokasifile='$lokasi_file' WHERE fotoid='$fotoid'");

    if ($update) {
        echo "<script>alert('Data foto berhasil diperbarui!'); window.location='foto.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data foto.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Foto</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
     /* Body styling */
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #000000, #434343);
    margin: 0;
    padding: 20px;
    color: #fff; /* Teks putih */
    line-height: 1.6;
    text-align: center; /* Pusatkan semua teks di dalam body */
}

/* Form styling */
form {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background-color: #1f1f1f; /* Warna latar belakang form */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    border-radius: 10px;
    text-align: left; /* Teks dalam form tetap rata kiri */
}

/* Judul Edit Foto */
h1 {
    text-align: center; /* Pusatkan teks judul */
    font-size: 24px; /* Ukuran font untuk judul */
    margin-bottom: 20px;
    color: #00FFB5;
}

/* Teks Selamat Datang */
p {
    text-align: center; /* Pusatkan teks selamat datang */
    font-size: 16px; /* Ukuran font lebih kecil untuk selamat datang */
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: 600; /* Bold */
    color: #dddddd; /* Warna label */
}

input[type="text"], textarea, input[type="file"], select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: none;
    border-radius: 6px;
    background-color: #333; /* Warna latar belakang input */
    color: #fff; /* Teks putih */
    box-sizing: border-box;
    font-size: 14px; /* Ukuran font lebih kecil */
}

/* Button Styling */
.button-wrapper {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    margin-top: 20px;
}

.button-wrapper input[type="submit"], .button-wrapper a {
    background-color: #00FFB5; /* Warna tombol */
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.3s ease;
}

.button-wrapper input[type="submit"]:hover, .button-wrapper a:hover {
    background-color: #00e3a1; /* Warna tombol saat hover */
}

/* Image preview */
.image-preview {
    text-align: center;
    margin-top: 20px;
}

.image-preview img {
    max-width: 200px;
    border-radius: 5px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); /* Bayangan untuk gambar */
}

/* Footer */
footer {
    text-align: center;
    margin-top: 30px;
    color: #aaa; /* Warna footer */
    font-size: 14px; /* Ukuran font footer */
}

    </style>
</head>
<body>
    <h1>Edit Foto</h1>
    <p>Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>

    <!-- Form untuk mengedit foto -->
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="judulfoto">Judul Foto</label>
        <input type="text" name="judulfoto" value="<?=$data['judulfoto']?>" required>

        <label for="deskripsifoto">Deskripsi Foto</label>
        <textarea name="deskripsifoto" rows="4" required><?=$data['deskripsifoto']?></textarea>

        <label for="albumid">Album</label>
        <select name="albumid" required>
            <?= $album_options ?>
        </select>

        <label for="lokasifile">Gambar</label>
        <input type="file" name="lokasifile">
        
        <!-- Preview gambar yang sudah ada -->
        <div class="image-preview">
            <h3>Gambar Saat Ini</h3>
            <img src="foto/<?=$data['lokasifile']?>" alt="Foto saat ini">
        </div>

        <!-- Tombol Edit dan Kembali -->
        <div class="button-wrapper">
            <input type="submit" name="update" value="Edit">
            <a href="foto.php">Kembali</a>
        </div>
    </form>

    <footer>
        &copy;copyright 2024 Your Website
    </footer>
</body>
</html>
