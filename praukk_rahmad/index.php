<?php
session_start();
include "koneksi.php"; // Pastikan koneksi database sudah diatur dengan benar

// Cek apakah pengguna sudah login
if (!isset($_SESSION['userid'])) {
    // Hanya arahkan ke index.php jika pengguna tidak sedang berada di index.php
    if (basename($_SERVER['PHP_SELF']) !== 'index.php') {
        header("Location: index.php"); // Alihkan ke halaman index
        exit(); // Hentikan eksekusi kode lebih lanjut
    }
}

// Ambil foto dari database dengan pencarian (jika ada)
$searchKeyword = ''; // Inisialisasi variabel pencarian
if (isset($_POST['search'])) {
    $searchKeyword = $_POST['search'];
}

// Query untuk mengambil foto
$sql = "SELECT foto.* FROM foto 
        JOIN user ON foto.userid = user.userid";

// Tambahkan kondisi pencarian jika ada
if (!empty($searchKeyword)) {
    $sql .= " WHERE judulfoto LIKE '%" . mysqli_real_escape_string($conn, $searchKeyword) . "%'";
}

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query error: " . mysqli_error($conn) . " | SQL: " . $sql);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SELAMAT DATANG DI GALERI AnimeGaze</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Gaya untuk navbar */
        nav {
            background-color: #fff; /* Warna latar belakang navbar */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Bayangan untuk efek depth */
            padding: 10px 20px; /* Padding di sekitar navbar */
            position: sticky; /* Membuat navbar tetap di atas saat scroll */
            top: 0; /* Posisi di atas */
            z-index: 1000; /* Menjaga navbar tetap di atas konten lain */
        }

        .nav-container {
            display: flex; /* Menggunakan flexbox untuk tata letak */
            justify-content: space-between; /* Spasi antara logo dan menu */
            align-items: center; /* Vertikal tengah */
            width: 100%; /* Memastikan lebar penuh */
            max-width: 1200px; /* Maks lebar untuk konten */
            margin: 0 auto; /* Menyusun secara center */
        }

        .nav-logo a {
            font-size: 1.8em; /* Ukuran font untuk logo */
            font-weight: bold; /* Menebalkan font */
            color: #e60023; /* Warna logo */
            text-decoration: none; /* Menghapus garis bawah */
        }

        nav ul {
            list-style: none; /* Menghapus bullet list */
            display: flex; /* Menggunakan flexbox untuk menu */
            gap: 20px; /* Jarak antar item menu */
            align-items: center; /* Vertikal tengah */
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

        /* Gaya untuk galeri */
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        /* Gaya untuk item galeri */
        .gallery-item {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.2s;
            position: relative;
        }

        .gallery-item img {
            width: 100%;
            height: 220px; /* Ukuran tinggi yang sama untuk semua gambar */
            object-fit: cover; /* Menjaga rasio gambar tetap */
        }

        /* Efek hover pada item galeri */
        .gallery-item:hover {
            transform: scale(1.05);
        }

        /* Styling untuk dark mode */
        body.dark {
            background-color: #121212;
            color: #ddd;
        }

        nav.dark {
            background-color: #333;
        }

        /* Gaya untuk judul galeri */
        .gallery-title {
            text-align: center; /* Mengatur teks ke tengah */
            margin: 20px 0; /* Margin atas dan bawah */
            font-size: 2em; /* Ukuran font */
            font-weight: bold; /* Menebalkan font */
        }

        /* Gaya untuk form pencarian */
        .search-form {
            display: flex; /* Menggunakan flexbox */
            align-items: center; /* Vertikal tengah */
            margin-right: 20px; /* Margin di sebelah kanan */
        }

        .search-form input {
            padding: 8px; /* Padding untuk input */
            border-radius: 5px 0 0 5px; /* Sudut membulat hanya di sisi kiri */
            border: 1px solid #ccc; /* Border input */
        }

        .search-form button {
            padding: 8px 15px; /* Padding untuk tombol */
            border-radius: 0 5px 5px 0; /* Sudut membulat hanya di sisi kanan */
            background-color: #e60023; /* Warna latar belakang tombol */
            color: white; /* Warna teks tombol */
            border: none; /* Menghapus border tombol */
            cursor: pointer; /* Menunjukkan kursor pointer */
        }

        .search-form button:hover {
            background-color: #c7001e; /* Warna latar belakang tombol saat hover */
        }

        /* Gaya untuk footer */
        footer {
            background-color: #f8f8f8; /* Warna latar belakang footer */
            padding: 20px; /* Padding untuk footer */
            text-align: center; /* Teks di tengah */
            margin-top: 40px; /* Margin atas untuk jarak dengan konten */
            border-top: 1px solid #e1e1e1; /* Garis atas footer */
        }
    </style>
</head>
<body class="light">

    <!-- Navbar -->
    <nav>
        <div class="nav-container">
            <div class="nav-logo"><a href="index.php">AnimeGaze</a></div>
            <div class="search-form">
                <form method="POST" action="">
                    <input type="text" name="search" value="<?= htmlspecialchars($searchKeyword) ?>" placeholder="Cari foto..." />
                    <button type="submit">Cari</button>
                </form>
            </div>
            <ul>
                <?php if (!isset($_SESSION['userid'])) { ?>
                    <li><a href="register.php">Daftar</a></li>
                    <li><a href="login.php">Masuk</a></li>
                <?php } else { ?>
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="album.php">Album</a></li>
                    <li><a href="foto.php">Foto</a></li>
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href="logout.php">Keluar</a></li>
                <?php } ?>
            </ul>
            <!-- Tombol untuk mengganti mode -->
            <button id="theme-toggle" class="theme-btn">🌙</button>
        </div>
    </nav>

    <div class="container mx-auto p-5">
        <h1 class="gallery-title">SELAMAT DATANG DI GALERI AnimeGaze</h1>

        <div class="gallery">
            <?php while ($data = mysqli_fetch_assoc($result)): ?>
                <div class="gallery-item">
                    <a href="view.php?fotoid=<?= $data['fotoid'] ?>">
                        <img src="foto/<?= $data['lokasifile'] ?>" alt="<?= $data['judulfoto'] ?>">
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; <?= date('Y') ?> AnimeGaze. All Rights Reserved.. | <a href="kontak.php">Kontak Kami</a></p>
    </footer>

    <!-- JavaScript untuk mode terang/gelap -->
    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const currentTheme = localStorage.getItem('theme') || 'light';

        document.body.classList.add(currentTheme);

        themeToggle.addEventListener('click', function() {
            let theme = document.body.classList.contains('light') ? 'dark' : 'light';
            document.body.classList.toggle('light');
            document.body.classList.toggle('dark');
            localStorage.setItem('theme', theme);
        });
    </script>
</body>
</html>
