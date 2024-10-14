<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:login.php");
}

include "koneksi.php";

// Cek apakah user adalah admin
$isAdmin = ($_SESSION['role'] === 'admin');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Album</title>
    <style>
        /* Reset dasar */
        body, h1, p, ul, table, input, form, footer {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }

        /* Styling untuk body */
        body {
            background-color: #f0f0f0;
            color: #333;
            line-height: 1.6;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding-top: 60px; /* Memberi ruang untuk navbar */
            padding-bottom: 60px; /* Memberi ruang untuk footer */
        }

        /* Styling untuk navbar */
        nav {
            background-color: #fff; /* Ubah latar belakang navbar menjadi putih */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Bayangan untuk efek depth */
            position: fixed; /* Membuat navbar tetap di atas saat scroll */
            top: 0; /* Posisi di atas */
            left: 0; /* Posisi di kiri */
            width: 100%; /* Lebar penuh */
            z-index: 1000; /* Menjaga navbar tetap di atas konten lain */
        }

        .nav-container {
            display: flex; /* Menggunakan flexbox untuk tata letak */
            justify-content: center; /* Menyusun item secara horizontal */
            padding: 10px 0; /* Padding atas dan bawah */
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex; /* Menggunakan flexbox untuk menu */
            gap: 20px; /* Jarak antar item menu */
        }

        ul li a {
            text-decoration: none;
            color: #333; /* Warna teks menu */
            padding: 14px 20px;
            display: block;
            transition: background-color 0.3s; /* Efek transisi saat hover */
        }

        ul li a:hover {
            background-color: #e60023; /* Warna saat hover */
            color: #fff; /* Warna teks saat hover */
        }

        /* Header utama */
        h1 {
            font-size: 2.5em;
            color: #007BFF;
            margin-bottom: 20px;
            animation: fadeIn 1.5s ease-in-out;
        }

        /* Tabel data album */
        table {
            width: 100%;
            max-width: 800px;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
            animation: fadeIn 1.5s ease-in-out;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            color: #333;
        }

        table th {
            background-color: #333; /* Warna header tabel */
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Link aksi di tabel */
        table td a {
            text-decoration: none;
            color: #007BFF;
            margin-right: 10px;
        }

        table td a:hover {
            color: #0056b3;
        }

        /* Styling untuk footer */
        footer {
            background-color: #fff; /* Ubah latar belakang footer menjadi putih */
            color: #333; /* Ubah warna teks footer menjadi gelap */
            padding: 10px;
            width: 100%;
            text-align: center;
            box-shadow: 0px -2px 8px rgba(0, 0, 0, 0.1); /* Bayangan untuk footer */
            font-size: 0.9em;
            position: fixed; /* Membuat footer tetap di bawah */
            bottom: 0; /* Posisi footer di bawah */
            left: 0; /* Posisi di kiri */
            z-index: 1000; /* Menjaga footer tetap di atas konten lain */
        }

        /* Animasi untuk halaman */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        body, h1, p, ul, table, form, footer {
            animation: fadeIn 1s ease-in-out;
        }

        /* Styling untuk tombol Tambah Album */
        .add-album-btn {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 5px;
            background-color: #007BFF; /* Warna tombol biru */
            color: white;
            text-decoration: none;
            border-radius: 15px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .add-album-btn:hover {
            background-color: #0056b3; /* Warna tombol saat di hover */
        }

        /* Container untuk tombol dan tabel */
        .container {
            max-width: 800px;
            margin: 0 auto; /* Supaya berada di tengah halaman */
            padding: 20px;
            text-align: left; /* Supaya tombol berada di sebelah kiri */
        }

    </style>
</head>
<body>
    <nav>
        <div class="nav-container">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="album.php">Album</a></li>
                <li><a href="foto.php">Foto</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <h1>Halaman Album</h1>
    <p>Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>

    <div class="container">
        <!-- Tombol Tambah Album -->
        <a href="tambah_album.php" class="add-album-btn">Tambah Album</a>

        <!-- Tabel Album -->
        <table>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Tanggal Dibuat</th>
                <th>Aksi</th>
            </tr>
            <?php
                if ($isAdmin) {
                    $sql = mysqli_query($conn, "SELECT * FROM album ORDER BY tanggaldibuat DESC");
                } else {
                    $userid = $_SESSION['userid'];
                    $sql = mysqli_query($conn, "SELECT * FROM album WHERE userid='$userid' ORDER BY tanggaldibuat DESC");
                }

                while($data = mysqli_fetch_array($sql)){
            ?>
                    <tr>
                        <td><?=$data['albumid']?></td>
                        <td><?=$data['namaalbum']?></td>
                        <td><?=$data['deskripsi']?></td>
                        <td><?=$data['tanggaldibuat']?></td>
                        <td>
                            <a href="hapus_album.php?albumid=<?=$data['albumid']?>">Hapus</a>
                            <a href="edit_album.php?albumid=<?=$data['albumid']?>">Edit</a>
                        </td>
                    </tr>
            <?php
                }
            ?>
        </table>
    </div>

    <footer>
        &copy; 2024 MyPhotoAlbum. All rights reserved.
    </footer>
</body>
</html>
