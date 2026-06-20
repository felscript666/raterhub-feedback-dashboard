<?php
// 1. KONEKSI DATABASE
$conn = new mysqli("localhost", "root", "", "trp_quality");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$message = "";

// 2. AMBIL ID DARI URL
$id = isset($_GET['id']) ? $conn->real_escape_string($_GET['id']) : null;

if (!$id) {
    header("Location: index.php");
    exit();
}

// 3. AMBIL DATA LAMA (JOIN 4 TABEL)
$sql_get = "SELECT r.*, q.query_text, nm.rating as nm_r, nm.nm_comment, pq.rating as pq_r, pq.pq_comment 
            FROM results r 
            LEFT JOIN queries q ON r.query_id = q.query_id 
            LEFT JOIN needs_met nm ON r.result_id = nm.result_id 
            LEFT JOIN page_quality pq ON r.result_id = pq.result_id 
            WHERE r.result_id = '$id'";

$result = $conn->query($sql_get);
$data = $result->fetch_assoc();

if (!$data) {
    die("<div style='padding:20px; background:#fee2e2; color:#b91c1c;'>Data tidak ditemukan di database untuk ID: " . htmlspecialchars($id) . "</div>");
}

// 4. LOGIKA HAPUS GAMBAR SAJA
if (isset($_POST['delete_image'])) {
    $target_dir = "../uploads/";
    $old_image = $data['image'];

    if ($old_image && file_exists($target_dir . $old_image)) {
        unlink($target_dir . $old_image);
    }

    $conn->query("UPDATE results SET image = NULL WHERE result_id = '$id'");
    $message = "<div class='alert alert-info shadow-sm'>Gambar berhasil dihapus!</div>";
    echo "<script>setTimeout(function(){ window.location.href='edit.php?id=$id'; }, 1000);</script>";
}

// 5. LOGIKA UPDATE DATA & UPLOAD GAMBAR
if (isset($_POST['update'])) {
    $query_text = $conn->real_escape_string($_POST['query_text']);
    $web_label  = $conn->real_escape_string($_POST['web_label']);
    $lp_link    = $conn->real_escape_string($_POST['lp_link']);
    $nm_rating  = $conn->real_escape_string($_POST['nm_rating']);
    $nm_comment = $conn->real_escape_string($_POST['nm_comment']);
    $pq_rating  = $conn->real_escape_string($_POST['pq_rating']);
    $pq_comment = $conn->real_escape_string($_POST['pq_comment']);
    
    // Proses Upload Gambar Baru
    $image_name = $data['image']; 
    if (!empty($_FILES['image_file']['name'])) {
        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        
        $new_image = time() . "_" . basename($_FILES['image_file']['name']);
        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target_dir . $new_image)) {
            // Hapus gambar lama jika ada
            if($image_name && file_exists($target_dir . $image_name)) unlink($target_dir . $image_name);
            $image_name = $new_image;
        }
    }

    // Jalankan Update ke Database
    $q_id = $data['query_id'];
    $conn->query("UPDATE queries SET query_text = '$query_text' WHERE query_id = '$q_id'");
    $conn->query("UPDATE results SET web_label = '$web_label', lp_link = '$lp_link', image = '$image_name' WHERE result_id = '$id'");
    $conn->query("UPDATE needs_met SET rating = '$nm_rating', nm_comment = '$nm_comment' WHERE result_id = '$id'");
    $conn->query("UPDATE page_quality SET rating = '$pq_rating', pq_comment = '$pq_comment' WHERE result_id = '$id'");

    $message = "<div class='alert alert-success shadow-sm'>Data berhasil diperbarui secara keseluruhan!</div>";
    echo "<script>setTimeout(function(){ window.location.href='edit.php?id=$id'; }, 1500);</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data TRP - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { background: #f8fafc; font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; flex-direction: column; }
        .container { flex: 1; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .section-title { font-weight: bold; color: #1e293b; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; margin-bottom: 20px; }
        .btn-primary { background: #2563eb; border: none; }
        footer { background: #fff; padding: 25px 0; border-top: 1px solid #e2e8f0; text-align: center; margin-top: 50px; color: #64748b; font-size: 0.9rem; }
        .preview-img { max-width: 100%; height: auto; border-radius: 10px; margin-bottom: 15px; border: 1px solid #e2e8f0; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-dark m-0">Edit Evidence Data</h3>
                    <p class="text-muted m-0">ID Result: #<?= $id ?></p>
                </div>
                <a href="index.php" class="btn btn-outline-secondary shadow-sm">
                   &larr; Kembali ke Panel Utama
                </a>
            </div>

            <div class="card p-4">
                <?= $message ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-5 border-end">
                            <h5 class="section-title">Informasi Dasar</h5>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Query Text</label>
                                <textarea name="query_text" class="form-control" rows="3" required><?= htmlspecialchars($data['query_text']) ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Web Label</label>
                                <input type="text" name="web_label" class="form-control" value="<?= htmlspecialchars($data['web_label']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Landing Page URL</label>
                                <textarea name="lp_link" class="form-control" rows="2" required><?= htmlspecialchars($data['lp_link']) ?></textarea>
                            </div>

                            <div class="mt-4 p-3 bg-light rounded border text-center">
                                <label class="form-label d-block fw-bold text-primary mb-3">Evidence Image</label>
                                
                                <?php if($data['image']): ?>
                                    <img src="../uploads/<?= $data['image'] ?>" class="preview-img shadow-sm">
                                    <button type="submit" name="delete_image" class="btn btn-sm btn-danger d-block mx-auto mb-3" onclick="return confirm('Hapus gambar ini saja?')">
                                        Hapus Gambar Ini
                                    </button>
                                <?php else: ?>
                                    <div class="py-4 text-muted">Tidak ada gambar yang diupload.</div>
                                <?php endif; ?>

                                <input type="file" name="image_file" class="form-control" accept=".jpg, .jpeg, .png">
                                <small class="text-muted d-block mt-2">Pilih file untuk mengganti/menambah gambar.</small>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <h5 class="section-title">Analisis Kualitas (Ratings)</h5>
                            
                            <div class="mb-4 bg-light p-3 rounded">
                                <label class="form-label fw-bold text-danger">Needs Met Analysis</label>
                                <textarea name="nm_rating" class="form-control mb-2" rows="1" placeholder="Contoh: MM to HM"><?= htmlspecialchars($data['nm_r']) ?></textarea>
                                <textarea name="nm_comment" class="form-control" rows="4" placeholder="Alasan rating Needs Met..."><?= htmlspecialchars($data['nm_comment']) ?></textarea>
                            </div>

                            <div class="mb-3 bg-light p-3 rounded">
                                <label class="form-label fw-bold text-primary">Page Quality Analysis</label>
                                <textarea name="pq_rating" class="form-control mb-2" rows="1" placeholder="Contoh: High+"><?= htmlspecialchars($data['pq_r']) ?></textarea>
                                <textarea name="pq_comment" class="form-control" rows="4" placeholder="Alasan rating Page Quality..."><?= htmlspecialchars($data['pq_comment']) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top text-end">
                        <button type="submit" name="update" class="btn btn-primary px-5 py-2 fw-bold shadow">
                            SIMPAN SEMUA PERUBAHAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<footer>
    © 2026 <b>TRP Quality Dashboard</b>. Made with <span style="color: #e11d48;">❤</span> by <b>RPL Digital Team</b>
</footer>

</body>
</html>