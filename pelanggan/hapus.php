<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? 0;

// Hapus data pelanggan (kendaraan & servis akan otomatis terhapus karena CASCADE)
$sql = "DELETE FROM pelanggan WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: index.php?pesan=hapus");
} else {
    header("Location: index.php?pesan=error");
}
exit();
?>
