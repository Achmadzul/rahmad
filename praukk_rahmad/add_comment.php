<?php
session_start();
include 'koneksi.php';

if (isset($_POST['fotoid']) && isset($_POST['comment'])) {
    $fotoid = intval($_POST['fotoid']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $userid = $_SESSION['userid']; // Asumsi user sudah login

    $sql = "INSERT INTO komentar (fotoid, userid, text, date) VALUES ($fotoid, $userid, '$comment', NOW())";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Data tidak valid.']);
}
?>
