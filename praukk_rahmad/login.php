<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <style>
        /* Reset dasar */
        body, h1, form, table, input {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            box-sizing: border-box;
        }

        /* Styling untuk body */
        body {
            background-color: #000; /* Mengubah latar belakang menjadi hitam */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        /* Styling untuk container */
        form {
            background: rgba(255, 255, 255, 0.1); /* Latar belakang form semi-transparan */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(255, 255, 255, 0.2);
        }

        /* Styling untuk heading */
        h1 {
            font-size: 2.5em; /* Ukuran font lebih besar */
            color: white;
            margin-bottom: 20px;
            text-align: center;
            text-shadow: 1px 1px 5px rgba(255, 255, 255, 0.2);
        }

        /* Styling untuk tabel */
        table {
            width: 100%;
        }

        table td {
            padding: 10px;
            color: white; /* Warna teks putih untuk kontras */
        }

        /* Styling untuk input */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-top: 5px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #6a11cb;
            outline: none;
        }

        /* Styling untuk tombol submit */
        input[type="submit"] {
            width: 35%;
            padding: 10px;
            background-color: #2575fc;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1em;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s, transform 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #1a5fc4;
            transform: translateY(-2px);
        }

        /* Styling untuk tombol Kembali */
        .button-wrapper {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
        }

        .button-wrapper a {
            display: inline-block;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
            width: 30%; /* Mengatur lebar untuk menjaga konsistensi dengan tombol login */
        }

        .button-wrapper a:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        /* Styling untuk notifikasi */
        .notification {
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }

        /* Animasi untuk halaman */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        body, h1, form {
            animation: fadeIn 0.8s ease-in-out;
        }

        /* Responsif */
        @media (max-width: 600px) {
            h1 {
                font-size: 2em;
            }

            input[type="text"],
            input[type="password"],
            input[type="submit"],
            .button-wrapper a {
                font-size: 0.9em;
            }
        }
    </style>
    <script>
        // JavaScript untuk menampilkan alert jika ada pesan error
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('message');
            if (message) {
                alert(message);
            }
        };
    </script>
</head>
<body>
    <form action="proses_login.php" method="post">
        <h1>Halaman Login</h1>

        <!-- Notifikasi untuk hasil login -->
        <?php if (isset($_GET['message'])): ?>
            <div class="notification">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <table>
            <tr>
                <td>Username</td>
                <td><input type="text" name="username" required></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="button-wrapper">
                        <!-- Tombol Login -->
                        <input type="submit" value="Login">
                        
                        <!-- Tombol Kembali -->
                        <a href="index.php">Kembali</a>
                    </div>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
