<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <style>
        /* CSS untuk halaman registrasi */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #000; /* Mengubah latar belakang menjadi hitam */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #fff; /* Warna teks putih untuk kontras */
            margin-bottom: 20px;
            text-shadow: 1px 1px 5px rgba(255, 255, 255, 0.2);
        }

        form {
            background-color: rgba(255, 255, 255, 0.1); /* Latar belakang form semi-transparan */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(255, 255, 255, 0.2);
            width: 300px;
            text-align: left;
        }

        table {
            width: 100%;
        }

        table td {
            padding: 10px;
            color: #fff; /* Warna teks putih untuk kontras */
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 6px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="email"]:focus {
            border-color: #6a11cb;
            outline: none;
        }

        /* Tombol Register */
        input[type="submit"] {
            width: 30%;
            background-color: #28a745;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        /* Tombol Kembali */
        .button-wrapper {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .button-wrapper a {
            display: inline-block;
            padding: 12px;
            background-color: #007bff;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .button-wrapper a:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
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
                font-size: 1.5em;
            }

            input[type="text"],
            input[type="password"],
            input[type="email"],
            input[type="submit"],
            .button-wrapper a {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <form action="proses_register.php" method="post">
        <h1>Halaman Registrasi</h1>
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
                <td>Email</td>
                <td><input type="email" name="email" required></td>
            </tr>
            <tr>
                <td>Nama Lengkap</td>
                <td><input type="text" name="namalengkap" required></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td><input type="text" name="alamat" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="button-wrapper">
                        <!-- Tombol Register -->
                        <input type="submit" value="Register">
                        
                        <!-- Tombol Kembali -->
                        <a href="index.php">Kembali</a>
                    </div>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
