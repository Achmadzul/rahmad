<?php
include "koneksi.php"; // Sesuaikan jalur jika perlu

if (isset($_GET['fotoid'])) {
    $fotoid = $_GET['fotoid'];
    $sql = "SELECT foto.*, user.namalengkap FROM foto 
            JOIN user ON foto.userid = user.userid 
            WHERE foto.fotoid = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $fotoid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    echo json_encode($data);
} else {
    echo json_encode([]);
}

mysqli_close($conn);
?>
