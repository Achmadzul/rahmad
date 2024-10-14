<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:login.php");
    exit;
}

// Hanya admin yang bisa mengakses halaman edit foto
if ($_SESSION['role'] != 'admin') {
    echo "Akses ditolak. Halaman ini hanya bisa diakses oleh admin.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Foto</title>
</head>
<body>
    <h1>Edit Foto</h1>
    <!-- Form edit foto -->
</body>
</html>
