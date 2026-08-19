<?php
$title = "Data Kendaraan";
require_once '../config/database.php';
require_once '../includes/header.php';

// Ambil semua data kendaraan beserta nama pelanggannya (JOIN)
$query  = "SELECT k.*, p.nama AS nama_pelanggan
           FROM kendaraan k
           JOIN pelanggan p ON k.id_pelanggan = p.id
           ORDER BY k.id DESC";
$result = mysqli_query($conn, $query);

$pesan = '';
if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == 'tambah') $pesan = '<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>Data kendaraan berhasil ditambahkan! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    if ($_GET['pesan'] == 'edit')   $pesan = '<div class="alert alert-info alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>Data kendaraan berhasil diubah! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    if ($_GET['pesan'] == 'hapus')  $pesan = '<div class="alert alert-warning alert-dismissible fade show"><i class="bi bi-trash me-2"></i>Data kendaraan berhasil dihapus! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
}
?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h4><i class="bi bi-car-front-fill me-2 text-info"></i>Data Kendaraan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Kendaraan</li>
            </ol>
        </nav>
    </div>
    <a href="tambah.php" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Kendaraan
    </a>
</div>

<?= $pesan ?>

<!-- TABEL DATA -->
<div class="card table-card">
    <div class="card-header">
        <i class="bi bi-table me-2"></i>Daftar Kendaraan
        <span class="badge bg-info ms-2"><?= mysqli_num_rows($result) ?> data</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pemilik</th>
                        <th>Jenis</th>
                        <th>Merk & Model</th>
                        <th>Plat Nomor</th>
                        <th>Tahun</th>
                        <th style="width:160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if (mysqli_num_rows($result) > 0):
                        while ($row = mysqli_fetch_assoc($result)):
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                        <td>
                            <?php if ($row['jenis'] == 'Motor'): ?>
                                <span class="badge bg-success"><i class="bi bi-bicycle me-1"></i>Motor</span>
                            <?php else: ?>
                                <span class="badge bg-info"><i class="bi bi-car-front me-1"></i>Mobil</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?= htmlspecialchars($row['merk']) ?></strong>
                            <?= htmlspecialchars($row['model']) ?>
                        </td>
                        <td>
                            <span class="badge bg-secondary fs-6 fw-normal"><?= htmlspecialchars($row['plat_nomor']) ?></span>
                        </td>
                        <td><?= $row['tahun'] ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning text-white">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                            <button onclick="konfirmasiHapus('../kendaraan/hapus.php?id=<?= $row['id'] ?>', '<?= addslashes($row['merk'] . ' ' . $row['model']) ?>')"
                                    class="btn btn-sm btn-danger">
                                <i class="bi bi-trash me-1"></i>Hapus
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr>
                        <td colspan="7" class="no-data">
                            <i class="bi bi-car-front"></i>
                            Belum ada data kendaraan. <a href="tambah.php">Tambah sekarang!</a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
