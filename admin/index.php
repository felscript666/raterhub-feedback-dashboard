<?php
$conn = new mysqli("localhost", "root", "", "trp_quality");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$message = "";

// --- PROSES INPUT DATA ---
if (isset($_POST['submit'])) {
    $query_text = $conn->real_escape_string($_POST['query_text']);
    $web_label = $conn->real_escape_string($_POST['web_label']);
    $lp_link = $conn->real_escape_string($_POST['lp_link']);
    $nm_rating = $conn->real_escape_string($_POST['nm_rating']);
    $nm_comment = $conn->real_escape_string($_POST['nm_comment']);
    $pq_rating = $conn->real_escape_string($_POST['pq_rating']);
    $pq_comment = $conn->real_escape_string($_POST['pq_comment']);
    
    $image_name = "";
    if (!empty($_FILES['image_file']['name'])) {
        $target_dir = "../uploads/"; 
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $image_name = time() . "_" . basename($_FILES['image_file']['name']);
        move_uploaded_file($_FILES['image_file']['tmp_name'], $target_dir . $image_name);
    }

    $conn->query("INSERT INTO queries (query_text, locale) VALUES ('$query_text', 'id_ID')");
    $new_q_id = $conn->insert_id;
    $conn->query("INSERT INTO results (query_id, web_label, lp_link, image) VALUES ('$new_q_id', '$web_label', '$lp_link', '$image_name')");
    $new_r_id = $conn->insert_id;
    $conn->query("INSERT INTO needs_met (result_id, rating, nm_comment) VALUES ('$new_r_id', '$nm_rating', '$nm_comment')");
    $conn->query("INSERT INTO page_quality (result_id, rating, pq_comment) VALUES ('$new_r_id', '$pq_rating', '$pq_comment')");
    
    $message = "<div class='alert alert-success shadow-sm'>Data Berhasil Ditambahkan!</div>";
}

// --- LOGIKA PENCARIAN (SERVER SIDE) ---
$search = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';
$where_sql = "";
if ($search != '') {
    $where_sql = "WHERE q.query_text LIKE '%$search%' OR r.web_label LIKE '%$search%' OR r.lp_link LIKE '%$search%'";
}

// --- LOGIKA PAGINATION ---
$limit = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$total_res = $conn->query("SELECT COUNT(*) as total FROM results r JOIN queries q ON r.query_id = q.query_id $where_sql");
$total_data = $total_res->fetch_assoc()['total'];
$total_pages = ceil($total_data / $limit);

// --- AMBIL DATA ---
$res = $conn->query("SELECT r.result_id, q.query_text, r.web_label, r.lp_link, r.image FROM results r 
                     JOIN queries q ON r.query_id = q.query_id 
                     $where_sql
                     ORDER BY r.result_id DESC LIMIT $start, $limit");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - TRP Quality</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f1f5f9; font-family: 'Inter', sans-serif; display: flex; flex-direction: column; min-height: 100vh; }
        .container { flex: 1; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 2rem; }
        .section-title { font-weight: bold; color: #1e293b; border-left: 4px solid #2563eb; padding-left: 10px; margin-bottom: 20px; }
        footer { background: #fff; padding: 20px 0; border-top: 1px solid #e2e8f0; text-align: center; margin-top: 50px; }
        .pagination { justify-content: center; gap: 5px; }
        .table img { width: 60px; height: auto; border-radius: 4px; cursor: pointer; }
        .domain-text { font-size: 0.85rem; color: #64748b; font-weight: 600; }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark m-0">TRP Admin Panel</h3>
            <span class="badge bg-primary">v2.0 Beta</span>
        </div>
        <div class="d-flex gap-2">
            <a href="index.php" class="btn btn-primary shadow-sm px-4">🛠 Admin Panel</a>
            <a href="../index.php" class="btn btn-outline-dark shadow-sm px-4">🏠 Home</a>
        </div>
    </div>

    <div class="card p-4">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h5 class="section-title mb-0">Daftar Data TRP</h5>
            </div>
            <div class="col-md-6">
                <form action="" method="GET" class="d-flex">
                    <input type="text" name="q" class="form-control me-2" placeholder="Cari Query, Label, atau URL..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn btn-primary px-4">Cari</button>
                    <?php if($search != ''): ?>
                        <a href="index.php" class="btn btn-light ms-1">Reset</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">No.</th>
                        <th>Domain</th>
                        <th>Query</th>
                        <th>Label</th>
                        <th class="text-center">Aksi</th>
                        <th class="text-end">Evidence</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($res->num_rows > 0): 
                        $no = $start + 1;
                        while($row = $res->fetch_assoc()): 
                            // Ekstrak Nama Domain
                            $url_info = parse_url($row['lp_link']);
                            $domain = isset($url_info['host']) ? str_replace('www.', '', $url_info['host']) : '-';
                    ?>
                    <tr>
                        <td class="text-muted fw-bold"><?= $no++ ?></td>
                        <td class="domain-text"><?= htmlspecialchars($domain) ?></td>
                        <td><?= htmlspecialchars($row['query_text']) ?></td>
                        <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($row['web_label']) ?></span></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="edit.php?id=<?= $row['result_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete.php?id=<?= $row['result_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
                            </div>
                        </td>
                        <td class="text-end">
                            <?php if(!empty($row['image'])): ?>
                                <a href="../uploads/<?= $row['image'] ?>" target="_blank">
                                    <img src="../uploads/<?= $row['image'] ?>" alt="Evidence">
                                </a>
                            <?php else: ?>
                                <small class="text-muted italic">No Image</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center text-muted py-5">Data tidak ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($total_pages > 1): ?>
        <nav class="mt-4">
            <ul class="pagination">
                <?php for($i=1; $i<=$total_pages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&q=<?= urlencode($search) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>

    <div class="card p-4">
        <h5 class="section-title">Tambah Data Baru</h5>
        <?= $message ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 border-end">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Query</label>
                        <textarea name="query_text" class="form-control" rows="2" placeholder="Masukkan teks kueri..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Web Label</label>
                        <input type="text" name="web_label" class="form-control" placeholder="Contoh: Wikipedia" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Landing Page URL</label>
                        <textarea name="lp_link" class="form-control" rows="2" placeholder="https://..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Upload Gambar Evidence</label>
                        <input type="file" name="image_file" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Needs Met Analysis</label>
                        <input type="text" name="nm_rating" class="form-control mb-2" placeholder="Rating (e.g. MM to HM)">
                        <textarea name="nm_comment" class="form-control" rows="3" placeholder="Komentar analisis..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Page Quality Analysis</label>
                        <input type="text" name="pq_rating" class="form-control mb-2" placeholder="Rating (e.g. Medium+)">
                        <textarea name="pq_comment" class="form-control" rows="3" placeholder="Komentar analisis..."></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary w-100 py-3 fw-bold shadow">💾 SIMPAN DATA KE DATABASE</button>
                </div>
            </div>
        </form>
    </div>
</div>

<footer>
    © 2026 <b>TRP Quality Dashboard</b>. Made with <span style="color: #e11d48;">❤</span> by <b>RPL Digital Team</b>
</footer>

</body>
</html>