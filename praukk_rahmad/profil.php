<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION['userid'];
$query = "SELECT * FROM user WHERE userid = '$userid'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
</head>
<body>
    <h1>Profil Pengguna</h1>
    <p>Nama Lengkap: <?= htmlspecialchars($user['namalengkap']) ?></p>
    <p>Email: <?= htmlspecialchars($user['email']) ?></p>
    <!-- Tampilkan informasi lainnya jika diperlukan -->
</body>
</html>
