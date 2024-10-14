<?php
    session_start();
    if(!isset($_SESSION['userid'])){
        header("location:login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Edit Album</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Reset dasar */
        body, h1, p, table, input {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        /* Styling untuk body */
        body {
            background-color: #000; /* Warna latar belakang hitam */
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            color: #f5f5f5; /* Warna teks putih untuk kontras yang lebih baik */
        }

        /* Styling untuk container */
        form {
            background: rgba(255, 255, 255, 0.1); /* Transparan untuk memberikan efek latar belakang */
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 600px;
            margin-top: 20px;
        }

        /* Styling untuk heading */
        h1 {
            font-size: 2.5em;
            color: #8f94fb; /* Warna heading yang cerah */
            margin-bottom: 20px;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.2);
        }

        /* Styling untuk tabel */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td {
            padding: 10px;
        }

        /* Styling untuk input */
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-top: 5px;
            font-size: 1em;
            background-color: rgba(255, 255, 255, 0.2); /* Latar belakang input transparan */
            color: #fff; /* Warna teks input */
        }

        /* Styling untuk tombol submit dan kembali */
        input[type="submit"], .btn-back {
            padding: 12px;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1.1em;
            cursor: pointer;
            margin-top: 15px;
            transition: background-color 0.3s, transform 0.2s;
        }

        input[type="submit"] {
            background-color: #8f94fb;
            width: 48%; /* Lebar tombol ubah */
        }

        input[type="submit"]:hover {
            background-color: #6c70dd;
            transform: scale(1.02);
        }

        .btn-back {
            background-color: #ff4757; /* Warna merah untuk tombol kembali */
            width: 48%; /* Lebar tombol kembali */
            float: right; /* Agar tombol kembali berada di kanan */
        }

        .btn-back:hover {
            background-color: #e84118; /* Warna merah lebih gelap saat hover */
        }

        /* Animasi untuk halaman */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        body, h1, form {
            animation: fadeIn 1s ease-in-out;
        }

        /* Responsif */
        @media (max-width: 600px) {
            h1 {
                font-size: 1.8em;
            }

            input[type="text"],
            input[type="submit"], .btn-back {
                font-size: 1em;
                width: 100%; /* Membuat tombol penuh pada layar kecil */
                float: none; /* Menghapus float untuk responsif */
                margin-top: 10px; /* Memisahkan tombol pada layar kecil */
            }
        }
    </style>

</head>
<body>
    <h1>Halaman Edit Album</h1>
    <p>Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>
    
    <form action="update_album.php" method="post">
        <?php
            include "koneksi.php";
            $albumid=$_GET['albumid'];
            $sql=mysqli_query($conn,"select * from album where albumid='$albumid'");
            while($data=mysqli_fetch_array($sql)){
        ?>
        <input type="text" name="albumid" value="<?=$data['albumid']?>" hidden>
        <table>
            <tr>
                <td>Nama Album</td>
                <td><input type="text" name="namaalbum" value="<?=$data['namaalbum']?>"></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td><input type="text" name="deskripsi" value="<?=$data['deskripsi']?>"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Ubah">
                    <button type="button" class="btn-back" onclick="window.history.back();">Kembali</button>
                </td>
            </tr>
        </table>
        <?php
            }
        ?>
    </form>
    
</body>
</html>
