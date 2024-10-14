<?php
session_start();
ob_start();
include "koneksi.php"; // Pastikan koneksi database sudah diatur dengan benar

// Cek apakah pengguna sudah login
if (!isset($_SESSION['userid'])) {
    echo "<script>
        alert('Anda harus login terlebih dahulu untuk melihat halaman ini.');
        window.location.href = 'index.php'; // Alihkan ke halaman index
    </script>";
    exit(); // Hentikan eksekusi kode lebih lanjut
}

$userid = $_SESSION['userid']; // Pastikan pengguna sudah login

if (!isset($_GET['fotoid'])) {
    die("ID foto tidak ditemukan!");
}

$fotoid = $_GET['fotoid'];

// Ambil detail foto
$sql = "SELECT foto.*, user.namalengkap FROM foto 
        JOIN user ON foto.userid = user.userid 
        WHERE fotoid = '$fotoid'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query error: " . mysqli_error($conn) . " | SQL: " . $sql);
}

$data = mysqli_fetch_array($result);

if (!$data) {
    die("Foto tidak ditemukan!");
}

// Ambil komentar untuk foto ini
$komentarSql = "SELECT komentarfoto.*, user.namalengkap FROM komentarfoto 
                JOIN user ON komentarfoto.userid = user.userid 
                WHERE fotoid = '$fotoid'";
$komentarResult = mysqli_query($conn, $komentarSql);
if (!$komentarResult) {
    die("Query error: " . mysqli_error($conn) . " | SQL: " . $komentarSql);
}

// Ambil jumlah like
$likeSql = "SELECT COUNT(*) AS jumlah_like FROM likefoto WHERE fotoid = '$fotoid'";
$likeResult = mysqli_query($conn, $likeSql);
if (!$likeResult) {
    die("Query error: " . mysqli_error($conn) . " | SQL: " . $likeSql);
}
$jumlahLike = mysqli_fetch_assoc($likeResult)['jumlah_like'];

// Cek apakah pengguna sudah menyukai foto ini
$checkLikeSql = "SELECT * FROM likefoto WHERE fotoid = '$fotoid' AND userid = '$userid'";
$checkLikeResult = mysqli_query($conn, $checkLikeSql);
$isLiked = mysqli_num_rows($checkLikeResult) > 0;

// Handle AJAX request untuk like, unlike, dan komentar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['action']) && $input['action'] == 'like') {
        // Proses Like
        if ($isLiked) {
            // Jika sudah like, maka unlike
            $deleteLikeSql = "DELETE FROM likefoto WHERE fotoid = '$fotoid' AND userid = '$userid'";
            if (mysqli_query($conn, $deleteLikeSql)) {
                // Ambil jumlah like setelah dihapus
                $likeSql = "SELECT COUNT(*) AS jumlah_like FROM likefoto WHERE fotoid = '$fotoid'";
                $likeResult = mysqli_query($conn, $likeSql);
                $jumlahLike = mysqli_fetch_assoc($likeResult)['jumlah_like'];
                echo json_encode(['success' => true, 'message' => 'Like berhasil dihapus', 'jumlah_like' => $jumlahLike, 'isLiked' => false]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal menghapus like']);
            }
        } else {
            // Jika belum like, maka like
            $insertLikeSql = "INSERT INTO likefoto (fotoid, userid) VALUES ('$fotoid', '$userid')";
            if (mysqli_query($conn, $insertLikeSql)) {
                // Ambil jumlah like setelah ditambahkan
                $likeSql = "SELECT COUNT(*) AS jumlah_like FROM likefoto WHERE fotoid = '$fotoid'";
                $likeResult = mysqli_query($conn, $likeSql);
                $jumlahLike = mysqli_fetch_assoc($likeResult)['jumlah_like'];
                echo json_encode(['success' => true, 'message' => 'Like berhasil ditambahkan', 'jumlah_like' => $jumlahLike, 'isLiked' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal menambahkan like']);
            }
        }
    } elseif (isset($input['action']) && $input['action'] == 'comment') {
        // Proses Komentar
        $isiKomentar = $input['isi'];
        if (!empty($isiKomentar)) {
            $insertKomentarSql = "INSERT INTO komentarfoto (fotoid, userid, isikomentar) VALUES ('$fotoid', '$userid', '$isiKomentar')";
            if (mysqli_query($conn, $insertKomentarSql)) {
                $userSql = "SELECT namalengkap FROM user WHERE userid = '$userid'";
                $userResult = mysqli_query($conn, $userSql);
                if ($userResult) {
                    $user = mysqli_fetch_assoc($userResult);
                    echo json_encode(['success' => true, 'namapengguna' => $user['namalengkap'], 'isi' => $isiKomentar]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Gagal mendapatkan nama pengguna']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal menambahkan komentar: ' . mysqli_error($conn)]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Komentar tidak boleh kosong']);
        }
    }
    exit();
}

ob_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($data['judulfoto']) ? $data['judulfoto'] : 'Judul tidak tersedia' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #000000; /* Ubah menjadi hitam */
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        color: #ffffff; /* Ubah warna teks menjadi putih */
    }

    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .bg-white {
        background-color: #333; /* Ubah warna latar belakang kartu menjadi gelap */
        border: 1px solid #555; /* Ubah warna border menjadi lebih gelap */
    }

    .rounded-lg {
        border-radius: 0; /* Instagram-style: no rounded corners */
    }

    .shadow-lg {
        box-shadow: none; /* No shadow to resemble Instagram feed */
    }

    .p-5 {
        padding: 15px; /* Reduce padding to make it more compact */
    }

    .mb-5 {
        margin-bottom: 10px; /* Reduce margin for tighter layout */
    }

    .flex {
        display: flex;
        align-items: center;
    }

    .items-center {
        align-items: center;
    }

    .w-10, .h-10 {
        width: 40px;
        height: 40px;
        border-radius: 50%; /* Instagram-style: Circular profile picture */
    }

    .mr-2 {
        margin-right: 10px;
    }

    .font-bold {
        font-weight: 600;
    }

    .text-lg {
        font-size: 14px;
    }

    .text-gray-500 {
        color: #bbb; /* Ubah warna teks menjadi lebih cerah */
    }

    .w-96 {
        width: 100%;
    }

    .rounded-lg {
        border-radius: 4px;
    }

    .mt-2 {
        margin-top: 8px;
    }

    .text-center {
        text-align: center;
    }

    .flex.space-x-4 {
        display: flex;
        gap: 10px;
    }

    .mt-4 {
        margin-top: 16px;
    }

    .btn {
        padding: 8px 12px;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        border: none;
        background-color: transparent;
        color: #ffffff; /* Ubah warna tombol menjadi putih */
    }

    .btn img.icon {
        width: 18px;
        height: 18px;
    }

    .btn-like {
        color: #ffffff;
    }

    .liked {
        background-color: #ff0000;
        color: white;
        border: 1px solid red;
    }

    .not-liked {
        color: #ffffff;
    }

    textarea {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #555; /* Ubah warna border menjadi lebih gelap */
        border-radius: 3px;
        resize: none;
        background-color: #222; /* Latar belakang textarea menjadi gelap */
        color: #ffffff; /* Teks textarea menjadi putih */
    }

    textarea:focus {
        border-color: #777; /* Warna border saat fokus */
    }

    .btn-primary {
        background-color: #0095f6;
        color: white;
        padding: 8px 15px;
        font-size: 14px;
        font-weight: bold;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #007bb5;
    }

    h3 {
        font-size: 14px;
        font-weight: bold;
        margin-top: 15px;
        color: #ffffff; /* Ubah warna h3 menjadi putih */
    }

    #comments-container p {
        font-size: 13px;
        margin: 5px 0;
        color: #ffffff; /* Ubah warna komentar menjadi putih */
    }

    #comments-container p b {
        color: #ffffff; /* Ubah warna nama pengguna menjadi putih */
    }

</style>

</head>
<body>
    <div class="container mx-auto p-5">
        <div class="bg-white rounded-lg shadow-lg p-5 mb-5">
            <div class="flex items-center mb-4">
                <img class="rounded-full w-10 h-10 mr-2" src="https://storage.googleapis.com/a1aa/image/GuRIjoTIGrYsCFgMVIgrn6kQBKJQbThZZYj3bfmqHntYwnyJA.jpg" alt="Profile picture">
                <div>
                    <h2 class="font-bold text-lg"><?= isset($data['judulfoto']) ? $data['judulfoto'] : 'Judul tidak tersedia' ?></h2>
                    <p class="text-gray-500">Dari: <?= isset($data['namalengkap']) ? $data['namalengkap'] : 'Nama tidak tersedia' ?></p>
                </div>
            </div>
            <img class="w-96 rounded-lg mx-auto" src="foto/<?= $data['lokasifile'] ?>" alt="<?= isset($data['judulfoto']) ? $data['judulfoto'] : 'Gambar tidak tersedia' ?>">
            <p class="mt-2"><?= isset($data['deskripsifoto']) ? $data['deskripsifoto'] : 'Deskripsi tidak tersedia' ?></p>
            <p class="text-gray-500">Tanggal: <?= isset($data['tanggalupload']) ? $data['tanggalupload'] : 'Tanggal tidak tersedia' ?></p>
            <div class="flex space-x-4 mt-4">
                <!-- Tombol Like dan Komentar -->
                <button onclick="likePhoto(<?= $data['fotoid'] ?>)" class="btn btn-like <?= $isLiked ? 'liked' : 'not-liked' ?>">
                    <img class="icon" src="https://cdn-icons-png.flaticon.com/512/1077/1077035.png" alt="Like">
                    <span><?= $isLiked ? 'Suka' : 'Suka' ?> (<?= $jumlahLike ?>)</span>
                </button>
                <button onclick="commentPhoto(<?= $data['fotoid'] ?>)" class="btn">
                    <img class="icon" src="https://cdn-icons-png.flaticon.com/512/2462/2462719.png" alt="Comment">
                    <span>Komentar</span>
                </button>
            </div>
            <h3 class="font-bold mt-4">Komentar:</h3>
            <div id="comments-container">
                <?php while ($komentar = mysqli_fetch_assoc($komentarResult)): ?>
                    <p><b><?= $komentar['namalengkap'] ?>:</b> <?= $komentar['isikomentar'] ?></p>
                <?php endwhile; ?>
            </div>
            <textarea id="comment-text" class="w-full p-2 mt-2 border border-gray-300 rounded-md" placeholder="Tulis komentar Anda..."></textarea>
            <button onclick="submitComment(<?= $data['fotoid'] ?>)" class="btn btn-primary mt-2 bg-blue-500 text-white p-2 rounded-lg">Kirim Komentar</button>
        </div>
    </div>

    <script>
        function likePhoto(fotoid) {
            fetch('view.php?fotoid=' + fotoid, {
                method: 'POST',
                body: JSON.stringify({ action: 'like' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector('.btn-like span').textContent = 'Suka (' + data.jumlah_like + ')';
                    document.querySelector('.btn-like').classList.toggle('liked', data.isLiked);
                    document.querySelector('.btn-like').classList.toggle('not-liked', !data.isLiked);
                } else {
                    alert(data.message);
                }
            });
        }

        function submitComment(fotoid) {
            const isiKomentar = document.getElementById('comment-text').value;
            fetch('view.php?fotoid=' + fotoid, {
                method: 'POST',
                body: JSON.stringify({ action: 'comment', isi: isiKomentar })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const commentContainer = document.getElementById('comments-container');
                    const newComment = `<p><b>${data.namapengguna}:</b> ${data.isi}</p>`;
                    commentContainer.insertAdjacentHTML('beforeend', newComment);
                    document.getElementById('comment-text').value = '';
                } else {
                    alert(data.message);
                }
            });
        }
    </script>
</body>
</html>

<?php
ob_end_flush();
?>
