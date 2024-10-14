<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Album</title>
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #121212;
            color: #ffffff;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        /* Form styling */
        form {
            max-width: 500px;
            margin: 50px auto;
            background: #1f1f1f;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(255, 255, 255, 0.1);
        }

        form input[type="text"], form input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
        }

        form input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: #218838;
        }

        /* Header styling */
        h1 {
            color: #fff;
            margin-bottom: 20px;
        }

        /* Button container styling */
        .button-container {
            display: flex;
            justify-content: space-between;
        }

        .button-container a, .button-container input[type="submit"] {
            width: 48%;
        }

        /* Navigation link */
        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ffc107;
            color: #000;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        a:hover {
            background-color: #e0a800;
        }
    </style>
    <script>
        function showAlert(event) {
            event.preventDefault(); // Mencegah submit form
            alert('Album berhasil ditambahkan!');
            document.querySelector("form").submit(); // Melanjutkan submit form setelah alert
        }
    </script>
</head>
<body>
    <h1>Tambah Album Baru</h1>
    <form action="tambah_album_proses.php" method="post" onsubmit="showAlert(event)">
        <input type="text" name="namaalbum" placeholder="Nama Album" required>
        <input type="text" name="deskripsi" placeholder="Deskripsi Album" required>
        <div class="button-container">
            <input type="submit" value="Tambah Album">
            <a href="album.php">Kembali ke Album</a>
        </div>
    </form>
</body>
</html>
