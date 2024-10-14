<?php
session_start();
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!');</script>";
    echo "<script>window.location='login.php';</script>";
    exit();
}

include "koneksi.php";

// Cek apakah user adalah admin
$isAdmin = ($_SESSION['role'] === 'admin'); // Sesuaikan dengan cara Anda menyimpan role

// Pastikan untuk memeriksa dan memproses upload foto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judulfoto = $_POST['judulfoto'];
    $deskripsifoto = $_POST['deskripsifoto'];
    $albumid = $_POST['albumid'];

    // Proses upload file
    $lokasifile = $_FILES['lokasifile']['tmp_name'];
    $nama_file = $_FILES['lokasifile']['name'];
    $target_directory = "foto/"; // Pastikan folder uploads ada
    $target_file = $target_directory . basename($nama_file);

    // Pindahkan file ke folder target
    if (move_uploaded_file($lokasifile, $target_file)) {
        // Simpan informasi foto ke database
        $sql = "INSERT INTO foto (judul, deskripsi, lokasifile, albumid, userid) VALUES ('$judulfoto', '$deskripsifoto', '$target_file', '$albumid', '{$_SESSION['userid']}')";

        if (mysqli_query($conn, $sql)) {
            // Redirect ke foto.php setelah sukses
            header("Location: foto.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Maaf, terjadi kesalahan saat mengupload file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Foto</title>
    <style>
        /* Resetting some default browser styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #000; /* Warna latar belakang hitam */
    color: #f5f5f5; /* Warna teks terang untuk kontras */
    line-height: 1.6;
    padding: 20px;
}

/* Header styling */
h1 {
    color: #8f94fb; /* Warna heading yang cerah */
    text-align: center;
    margin: 20px 0;
}

/* Welcome message styling */
p {
    text-align: center;
    font-size: 18px;
    margin-bottom: 20px;
}

/* Form styling */
form {
    background-color: rgba(255, 255, 255, 0.1); /* Transparan untuk memberikan efek latar belakang */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    margin: 0 auto;
    max-width: 600px;
}

form table {
    width: 100%;
    margin: 20px 0;
}

form table td {
    padding: 10px;
}

form input[type="text"],
form input[type="file"],
form select {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    background-color: #fff; /* Latar belakang input solid putih */
    color: #000; /* Warna teks hitam */
}

/* Mengubah warna teks dropdown select */
form select {
    color: #000; /* Warna teks dropdown menjadi hitam */
    background-color: #fff; /* Latar belakang select solid putih */
}

/* Mengubah warna teks untuk setiap option dalam select */
form select option {
    color: #000; /* Warna teks option menjadi hitam */
}

form input[type="submit"],
.btn-back {
    background-color: #8f94fb; /* Warna tombol */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
    margin-top: 10px;
}

form input[type="submit"]:hover,
.btn-back:hover {
    background-color: #6c70dd; /* Warna saat hover */
}

/* Styling untuk tombol kembali */
.btn-back {
    background-color: #ff4757; /* Warna merah untuk tombol kembali */
    float: right; /* Agar tombol kembali berada di kanan */
}

/* Responsive design */
@media (max-width: 600px) {
    form {
        padding: 10px;
    }

    form input[type="submit"], .btn-back {
        width: 100%; /* Membuat tombol penuh pada layar kecil */
        float: none; /* Menghapus float untuk responsif */
        margin-top: 10px; /* Memisahkan tombol pada layar kecil */
    }
}

    </style>
</head>
<body>
    <h1>Tambah Foto</h1>
    <p>Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>

    <form action="tambah_foto_proses.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Judul</td>
                <td><input type="text" name="judulfoto" required></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td><input type="text" name="deskripsifoto" required></td>
            </tr>
            <tr>
                <td>Lokasi File</td>
                <td><input type="file" name="lokasifile" required></td>
            </tr>
            <tr>
                <td>Album</td>
                <td>
                    <select name="albumid" required>
                    <?php
                        // Modifikasi query berdasarkan role
                        if ($isAdmin) {
                            // Jika admin, ambil semua album dari semua user
                            $sql = mysqli_query($conn, "SELECT * FROM album");
                        } else {
                            // Jika bukan admin, ambil album milik user yang login
                            $userid = $_SESSION['userid'];
                            $sql = mysqli_query($conn, "SELECT * FROM album WHERE userid='$userid'");
                        }

                        while ($data = mysqli_fetch_array($sql)) {
                    ?>
                            <option value="<?=$data['albumid']?>"><?=$data['namaalbum']?></option>
                    <?php
                        }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Tambah">
                    <button type="button" class="btn-back" onclick="window.history.back();">Kembali</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
