<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION["userid"])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
} elseif (!isset($_GET["fotoid"])) {
    echo json_encode(['status' => 'error', 'message' => 'Foto ID is missing']);
} else {
    $FotoID = $_GET["fotoid"];
    $UserID = $_SESSION["userid"];

    // Cek apakah user sudah like foto ini sebelumnya
    $sql = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$FotoID' AND userid='$UserID'");
    
    if (mysqli_num_rows($sql) == 1) {
        // Jika sudah like, hapus like (Unlike)
        mysqli_query($conn, "DELETE FROM likefoto WHERE fotoid='$FotoID' AND userid='$UserID'");
        
        // Ambil jumlah like terbaru setelah unlike
        $result = mysqli_query($conn, "SELECT COUNT(*) as jumlah_like FROM likefoto WHERE fotoid='$FotoID'");
        $data = mysqli_fetch_assoc($result);
        
        // Kembalikan status sukses beserta jumlah like terbaru
        echo json_encode(['status' => 'unliked', 'like_count' => $data['jumlah_like']]);
    } else {
        // Jika belum, tambahkan like
        $TanggalLike = date("Y-m-d");
        mysqli_query($conn, "INSERT INTO likefoto (fotoid, userid, tanggallike) VALUES ('$FotoID', '$UserID', '$TanggalLike')");
        
        // Ambil jumlah like terbaru setelah like
        $result = mysqli_query($conn, "SELECT COUNT(*) as jumlah_like FROM likefoto WHERE fotoid='$FotoID'");
        $data = mysqli_fetch_assoc($result);
        
        // Kembalikan status sukses beserta jumlah like terbaru
        echo json_encode(['status' => 'liked', 'like_count' => $data['jumlah_like']]);
    }
}
?>
