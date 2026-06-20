<?php
$conn = new mysqli("localhost", "root", "", "trp_quality");
$id = $_GET['id'];

if ($id) {
    // Karena ada foreign key, sebaiknya hapus child dulu atau gunakan ON DELETE CASCADE
    $conn->query("DELETE FROM needs_met WHERE result_id = '$id'");
    $conn->query("DELETE FROM page_quality WHERE result_id = '$id'");
    
    // Ambil nama gambar untuk dihapus dari folder
    $img = $conn->query("SELECT image FROM results WHERE result_id = '$id'")->fetch_assoc();
    if($img['image']) unlink("../uploads/" . $img['image']);

    $conn->query("DELETE FROM results WHERE result_id = '$id'");
}

header("Location: index.php"); // Kembali ke halaman admin
exit();
?>