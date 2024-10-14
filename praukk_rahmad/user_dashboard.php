<?php
session_start();

if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'user') {
    header('Location: login.html'); // Redirect ke halaman login jika bukan user
    exit();
}

echo "<h1>Dashboard User</h1>";
echo "<p>Selamat datang, {$_SESSION['username']}! Anda tidak memiliki akses untuk menghapus foto.</p>";
echo "<br><a href='logout.php'>Logout</a>"; // Link untuk logout
?>
