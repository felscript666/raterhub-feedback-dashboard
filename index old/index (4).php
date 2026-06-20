<?php
$conn = new mysqli("localhost", "root", "", "trp_quality");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ================= INSERT =================
if (isset($_POST['submit'])) {

    $query = $_POST['query'];
    $intent = $_POST['intent'];
    $web_label = $_POST['web_label'];
    $lp_link = $_POST['lp_link'];
    $nm_rating = $_POST['nm_rating'];
    $nm_comment = $_POST['nm_comment'];
    $pq_rating = $_POST['pq_rating'];
    $pq_comment = $_POST['pq_comment'];

    // insert query
    $conn->query("INSERT INTO queries (query_text, locale, user_intent) 
                  VALUES ('$query', 'id_ID', '$intent')");
    $query_id = $conn->insert_id;

    // insert result
    $conn->query("INSERT INTO results (query_id, web_label, lp_link) 
                  VALUES ($query_id, '$web_label', '$lp_link')");
    $result_id = $conn->insert_id;

    // insert needs met
    $conn->query("INSERT INTO needs_met (result_id, rating, nm_comment) 
                  VALUES ($result_id, '$nm_rating', '$nm_comment')");

    // insert page quality
    $conn->query("INSERT INTO page_quality (result_id, rating, pq_comment) 
                  VALUES ($result_id, '$pq_rating', '$pq_comment')");
}

// ================= PAGINATION =================
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$total_result = $conn->query("SELECT COUNT(*) as total FROM results");
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $limit);

// ================= SELECT =================
$sql = "
SELECT 
    q.query_text, 
    r.web_label,
    r.lp_link, 
    nm.rating AS nm_rating,
    nm.nm_comment,
    pq.rating AS pq_rating,
    pq.pq_comment
FROM results r
LEFT JOIN queries q ON q.query_id = r.query_id
LEFT JOIN needs_met nm ON r.result_id = nm.result_id
LEFT JOIN page_quality pq ON r.result_id = pq.result_id
LIMIT $start, $limit
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>TRP Quality Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f6f9;
            margin: 0;
        }

        .container {
            width: 95%;
            margin: auto;
        }

        h2 {
            margin-top: 30px;
            color: #333;
        }

        .card {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 6px 0;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #45a049;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
        }

        th {
            background: #2c3e50;
            color: white;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        tr:hover {
            background: #f1f1f1;
        }

        a {
            color: #3498db;
            text-decoration: none;
            word-break: break-all;
        }

        .pagination {
            margin-top: 10px;
        }

        .pagination a {
            padding: 6px 12px;
            margin: 2px;
            border-radius: 6px;
            border: 1px solid #ddd;
            text-decoration: none;
            background: white;
        }

        .pagination a.active {
            background: #2c3e50;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>📥 Input Data</h2>
    <div class="card">
        <form method="POST">

            <label>Query</label>
            <input type="text" name="query" required>

            <label>User Intent</label>
            <textarea name="intent" required></textarea>

            <label>Web Info (Label)</label>
            <input type="text" name="web_label" placeholder="contoh: gramedia / wikipedia / halodoc" required>

            <label>LP Link</label>
            <input type="text" name="lp_link" required>

            <label>Needs Met Rating</label>
            <select name="nm_rating">
                <option>FailsM</option>
                <option>SM</option>
                <option>MM</option>
                <option>HM</option>
                <option>FullyM</option>
            </select>

            <label>Komentar Needs Met</label>
            <textarea name="nm_comment"></textarea>

            <label>Page Quality Rating</label>
            <select name="pq_rating">
                <option>Lowest</option>
                <option>Low</option>
                <option>Medium</option>
                <option>High</option>
                <option>Highest</option>
            </select>

            <label>Komentar Page Quality</label>
            <textarea name="pq_comment"></textarea>

            <button type="submit" name="submit">💾 Simpan</button>
        </form>
    </div>

    <h2>📊 Data View</h2>
    <div class="card">

        <!-- PAGINATION -->
        <div class="pagination">
        <?php
        for ($i = 1; $i <= $total_pages; $i++) {
            $active = ($i == $page) ? "active" : "";
            echo "<a class='$active' href='?page=$i'>$i</a>";
        }
        ?>
        </div>

        <table>
        <tr>
            <th>No</th>
            <th>Query</th>
            <th>LP Link</th>
            <th>Web Info</th>
            <th>Needs Met</th>
            <th>Komentar NM</th>
            <th>Page Quality</th>
            <th>Komentar PQ</th>
        </tr>

        <?php
        $no = $start + 1;

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>$no</td>
                <td>{$row['query_text']}</td>
                <td><a href='{$row['lp_link']}' target='_blank'>{$row['lp_link']}</a></td>
                <td>{$row['web_label']}</td>
                <td>{$row['nm_rating']}</td>
                <td>{$row['nm_comment']}</td>
                <td>{$row['pq_rating']}</td>
                <td>{$row['pq_comment']}</td>
            </tr>";
            $no++;
        }
        ?>

        </table>

    </div>

</div>

</body>
</html>