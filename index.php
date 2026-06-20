<?php
date_default_timezone_set('Asia/Jakarta');

$conn = new mysqli("localhost", "root", "", "trp_quality");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// ================= FITUR SEARCH =================
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$where_clause = "";
if (!empty($search)) {
    $where_clause = "WHERE q.query_text LIKE '%$search%' OR r.web_label LIKE '%$search%' OR r.lp_link LIKE '%$search%'";
}

// ================= PAGINATION =================
$limit = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$total_result = $conn->query("SELECT COUNT(*) as total FROM results r LEFT JOIN queries q ON q.query_id = r.query_id $where_clause");
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $limit);

// ================= SELECT DATA =================
$sql = "SELECT r.result_id, q.query_text, r.web_label, r.lp_link, nm.rating AS nm_rating, r.image,
               nm.nm_comment, pq.rating AS pq_rating, pq.pq_comment 
        FROM results r
        LEFT JOIN queries q ON q.query_id = r.query_id
        LEFT JOIN needs_met nm ON r.result_id = nm.result_id
        LEFT JOIN page_quality pq ON r.result_id = pq.result_id
        $where_clause
        ORDER BY r.result_id DESC 
        LIMIT $start, $limit";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quality Explorer | TRP Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --bg: #f1f5f9;
            --white: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header & Search */
        .header {
            background: var(--white);
            padding: 0.75rem 2rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-left { display: flex; align-items: center; gap: 10px; }
        
        .btn-nav {
            text-decoration: none;
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 8px 14px;
            border-radius: 6px;
            background: #f1f5f9;
            transition: 0.2s;
            border: 1px solid var(--border);
        }
        .btn-nav:hover { background: #e2e8f0; }
        .btn-admin { background: #1e293b; color: white; border: none; }
        .btn-admin:hover { background: #0f172a; color: white; }

        .search-box form { display: flex; gap: 8px; }
        .search-box input {
            padding: 9px 15px;
            width: 320px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: #f8fafc;
            font-family: inherit;
        }
        .btn-search {
            background: var(--primary);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }
        .btn-search:hover { background: var(--primary-hover); }

        .container {
            width: 95%;
            max-width: 1800px;
            margin: 1.5rem auto;
            flex: 1;
        }

        .card {
            background: var(--white);
            border-radius: 8px;
            border: 1px solid var(--border);
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; }
        th {
            background: #f8fafc;
            text-align: left;
            padding: 1rem;
            font-weight: 600;
            color: var(--text-muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            border-bottom: 1px solid var(--border);
        }

        td { padding: 1rem; border-bottom: 1px solid var(--border); vertical-align: top; }

        /* Efek Hover pada Tabel */
        tbody tr { transition: background-color 0.2s; }
        tbody tr:hover { background-color: #fbed272e; }

        .raw-link {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
            word-break: break-all;
            margin-bottom: 4px;
        }
        .raw-link:hover { text-decoration: underline; }

        .btn-open {
            font-size: 0.75rem;
            font-weight: 500;
            color: #10b981;
            background: #ecfdf5;
            padding: 2px 8px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-nm { background: #dbeafe; color: #1e40af; }
        .badge-pq { background: #fef3c7; color: #92400e; }

        .comment {
            display: block;
            margin-top: 6px;
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.4;
        }

        footer {
            background: var(--white);
            border-top: 1px solid var(--border);
            padding: 1.5rem 0;
            text-align: center;
            margin-top: 2rem;
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        .heart { color: #ef4444; }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.4rem;
            margin: 1.5rem 0;
        }
        .pagination a {
            padding: 6px 12px;
            border-radius: 6px;
            background: white;
            border: 1px solid var(--border);
            text-decoration: none;
            color: var(--text-main);
            font-size: 0.85rem;
        }
        .pagination a.active { background: var(--primary); color: white; border-color: var(--primary); }
    </style>
</head>
<body>

<header class="header">
    <div class="nav-left">
        <h1 style="font-size: 1.2rem; margin-right:15px;">📊 TRP Explorer</h1>
        <a href="index.php" class="btn-nav">🏠 HOME</a>
        <a href="admin/index.php" class="btn-nav btn-admin">⚙️ PANEL ADMIN</a>
    </div>

    <div class="search-box">
        <form method="GET">
            <input type="text" name="search" placeholder="Cari Query atau Link..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn-search">Cari</button>
        </form>
    </div>
</header>

<div class="container">
    <div class="card">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th width="40">No</th>
                        <th width="25%">Landing Page Link (URL)</th>
                        <th>Query & Label</th>
                        <th width="20%">Needs Met</th>
                        <th width="20%">Page Quality</th>
                        <th width="100" style="text-align: center;">Image</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = $start + 1;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td style="color: #64748b; font-weight: 500;"><?= $no++ ?></td>
                                <td>
                                    <a href="<?= htmlspecialchars($row['lp_link']) ?>" target="_blank" class="raw-link">
                                        <?= htmlspecialchars($row['lp_link']) ?>
                                    </a>
                                    <a href="<?= htmlspecialchars($row['web_label']) ?>" target="_blank" class="btn-open">
                                        <?= htmlspecialchars($row['web_label']) ?>
                                    </a>
                                </td>
                                <td>
                                    <div style="font-size: 14px; font-weight: 600; color: #1e293b;"><?= htmlspecialchars($row['query_text']) ?></div>
                                </td>
                                <td>
                                    <span class="badge badge-nm"><?= $row['nm_rating'] ?></span>
                                    <span class="comment"><?= htmlspecialchars($row['nm_comment']) ?></span>
                                </td>
                                <td>
                                    <span class="badge badge-pq"><?= $row['pq_rating'] ?></span>
                                    <span class="comment"><?= htmlspecialchars($row['pq_comment']) ?></span>
                                </td>
                                <td style="text-align: center;">
                                    <?php if (!empty($row['image'])): ?>
                                        <a href="uploads/<?= $row['image'] ?>" target="_blank">
                                            <img src="uploads/<?= $row['image'] ?>" alt="Evidence" style="width: 70px; height: auto; border-radius: 6px; border: 1px solid #e2e8f0; transition: transform 0.2s;">
                                        </a>
                                    <?php else: ?>
                                        <span style="color: #cbd5e1; font-size: 0.75rem;">No Image</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center; padding: 4rem; color: #94a3b8;'>Data tidak ditemukan.</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a class="<?= ($i == $page) ? "active" : "" ?>" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>

<footer>
    &copy; <?= date('Y') ?> <b>TRP Quality Dashboard</b>. Made with <span class="heart">❤</span> by <b>RPL Digital Team</b>
</footer>

</body>
</html>