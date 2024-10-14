<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:login.php");
    exit;
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
    <title>Halaman Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Reset dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Styling untuk body */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding-top: 60px; /* Memberi ruang untuk navbar */
            padding-bottom: 60px; /* Memberi ruang untuk footer */
            position: relative;
            min-height: 100vh;
        }

        /* Styling Navbar */
        nav {
            background-color: #fff; /* Warna latar belakang navbar */
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

        nav ul {
            list-style: none; /* Menghapus bullet list */
            display: flex; /* Menggunakan flexbox untuk menu */
            gap: 20px; /* Jarak antar item menu */
        }

        nav ul li a {
            text-decoration: none; /* Menghapus garis bawah */
            color: #333; /* Warna teks menu */
            padding: 8px 15px; /* Padding untuk item menu */
            border-radius: 20px; /* Sudut membulat */
            transition: background-color 0.3s; /* Efek transisi saat hover */
        }

        nav ul li a:hover {
            background-color: #e60023; /* Warna latar belakang saat hover */
            color: #fff; /* Warna teks saat hover */
        }
/* Header utama */
h1 {
    font-size: 3em; /* Ukuran font */
    color: #007BFF; /* Warna teks */
    margin-bottom: 20px; /* Jarak bawah */
    animation: fadeIn 1.5s ease-in-out; /* Animasi */
    text-align: center; /* Memusatkan teks */
    width: 100%; /* Memastikan elemen memiliki lebar penuh */
}


        .add-photo-button {
            display: inline-block;
            background-color: blue;
            color: white;
            padding: 10px 20px;
            text-align: center;
            margin-right: 10px; /* Jarak antara tombol dan input pencarian */
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-photo-button:hover {
            background-color: darkblue;
        }

        .search-container {
            text-align: center;
            margin: 20px 0;
        }

        .search-container input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 2px solid #333;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s;
        }

        .search-container input[type="text"]:focus {
            border-color: #007bff;
        }

        .search-container button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s;
        }

        .search-container button:hover {
            background-color: #0056b3;
        }

        .print-button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #28a745;
            color: white;
            cursor: pointer;
            text-align: center;
            float: right; /* Pindahkan tombol ke kanan */
            margin: 20px 0; /* Jarak atas dan bawah tombol */
            transition: background-color 0.3s;
        }

        .print-button:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #333;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        table img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
            cursor: pointer;
        }

      /* Styling Footer */
footer {
    background-color: #fff; /* Ubah latar belakang menjadi putih */
    color: #333; /* Ubah warna teks menjadi gelap */
    text-align: center; /* Pusatkan teks */
    padding: 10px 0; /* Padding atas dan bawah */
    position: fixed; /* Membuat footer tetap di bawah */
    bottom: 0; /* Posisi footer di bawah */
    left: 0; /* Posisi di kiri */
    width: 100%; /* Lebar penuh */
    z-index: 1000; /* Pastikan footer di atas konten lain */
}

footer a {
    color: #333; /* Warna link footer */
    text-decoration: none; /* Menghapus garis bawah */
    margin: 0 15px; /* Jarak antar link */
    transition: color 0.3s; /* Efek transisi untuk hover */
}

footer a:hover {
    color: #e60023; /* Warna saat hover */
}


        /* Responsif untuk tampilan mobile */
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column; /* Susun menu secara vertikal */
                align-items: center; /* Pusatkan item menu */
            }

            body {
                padding-top: 120px; /* Menyesuaikan ruang pada tampilan mobile */
                padding-bottom: 100px; /* Menyesuaikan ruang footer */
            }

            .print-button {
                float: none; /* Buat tombol tidak mengapung pada tampilan mobile */
                display: block; /* Ubah tombol menjadi block */
                margin: 10px auto; /* Pusatkan tombol */
            }
        }
    </style>
    <script>
        function printPhoto(imgSrc) {
            const printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>Cetak Foto</title></head><body>');
            printWindow.document.write('<img src="' + imgSrc + '" style="max-width: 100%;"/>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }

        function printPage() {
            window.print();
        }
    </script>
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

    <h1>Halaman Foto</h1>
    <p>Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>
    
    <div class="search-container">
        <a href="tambah_foto.php" class="add-photo-button">Tambah Foto</a>
        <form method="GET" action="" style="display: inline-block;">
            <input type="text" name="search" placeholder="Cari foto..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Cari</button>
        </form>
        <button class="print-button" onclick="printPage()">Print</button> <!-- Pindahkan tombol Print di sini -->
    </div>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Tanggal Unggah</th>
            <th>FOTO</th>
            <th>Album</th>
            <th>Disukai</th>
            <th>Aksi</th>
        </tr>
        <?php
        $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
        
        if ($isAdmin) {
            $sql = mysqli_query($conn, "SELECT foto.*, album.namaalbum FROM foto INNER JOIN album ON foto.albumid = album.albumid WHERE 
                judulfoto LIKE '%$search%' OR 
                deskripsifoto LIKE '%$search%' OR 
                album.namaalbum LIKE '%$search%'");
        } else {
            $userid = $_SESSION['userid'];
            $sql = mysqli_query($conn, "SELECT foto.*, album.namaalbum FROM foto INNER JOIN album ON foto.albumid = album.albumid WHERE 
                foto.userid = '$userid' AND (
                judulfoto LIKE '%$search%' OR 
                deskripsifoto LIKE '%$search%' OR 
                album.namaalbum LIKE '%$search%')");
        }

        $no = 1;
        while ($data = mysqli_fetch_array($sql)) {
        ?>
            <tr>
                <td><?=$no?></td>
                <td><?=$data['judulfoto']?></td>
                <td><?=$data['deskripsifoto']?></td>
                <td><?=$data['tanggalunggah']?></td>
                <td>
                    <img src="foto/<?=$data['lokasifile']?>" width="200px" onclick="printPhoto('foto/<?=$data['lokasifile']?>')">
                </td>
                <td><?=$data['namaalbum']?></td>
                <td class="text-center">
                    <?php
                    $fotoid = $data['fotoid'];
                    $sql2 = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                    echo mysqli_num_rows($sql2);
                    ?>
                </td>
                <td>
                    <?php if ($isAdmin) { ?>
                        <a href="hapus_foto.php?fotoid=<?=$data['fotoid']?>">Hapus</a>
                    <?php } ?>
                    <a href="update_foto.php?fotoid=<?=$data['fotoid']?>">Edit</a>
                </td>
            </tr>
        <?php
            $no++;
        }
        ?>
    </table>

    <footer>
        &copy; 2024 Galeri Foto. All Rights Reserved.
    </footer>
</body>
</html>
