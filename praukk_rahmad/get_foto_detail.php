<?php
include "koneksi.php";

if (isset($_GET['fotoid'])) {
    $fotoid = $_GET['fotoid'];
    $query = "SELECT foto.*, user.namalengkap, user.userid FROM foto JOIN user ON foto.userid = user.userid WHERE foto.fotoid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $fotoid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        
        // Ambil komentar terkait
        $comments = []; // Inisialisasi array komentar
        $commentQuery = "SELECT * FROM komentar WHERE fotoid = ?";
        $commentStmt = $conn->prepare($commentQuery);
        $commentStmt->bind_param("i", $fotoid);
        $commentStmt->execute();
        $commentResult = $commentStmt->get_result();

        while ($comment = $commentResult->fetch_assoc()) {
            $comments[] = [
                'text' => $comment['text'],
                'date' => $comment['tanggal']
            ];
        }

        // Kirim data dalam format JSON
        echo json_encode([
            'judulfoto' => $data['judulfoto'],
            'lokasifile' => $data['lokasifile'],
            'deskripsifoto' => $data['deskripsifoto'],
            'namalengkap' => $data['namalengkap'],
            'likes' => $data['likes'],
            'tanggal_upload' => $data['tanggal_upload'], // Tambahkan ini
            'comments' => $comments
        ]);
    }
}
?>
