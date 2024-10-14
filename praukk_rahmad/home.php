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
    <title>Halaman Home</title>
    <style>
        /* Reset dasar */
        body, h1, p, ul {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }

        /* Styling untuk body */
        body {
            background-color: #f8f9fa;
            color: #343a40;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        /* Header utama */
        h1 {
            font-size: 2.5em;
            color: #007BFF;
            margin-bottom: 20px;
        }

        /* Styling untuk paragraf selamat datang */
        p {
            font-size: 1.2em;
            margin-bottom: 20px;
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Navigasi */
        ul {
            list-style-type: none;
            margin-bottom: 30px;
            display: flex;
            gap: 15px;
        }

        ul li a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        ul li a:hover {
            background-color: #007BFF;
            color: white;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            h1 {
                font-size: 2em;
            }
            ul {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <h1>Halaman Home</h1>
    <p>Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>
    
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="album.php">Album</a></li>
        <li><a href="foto.php">Foto</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>
