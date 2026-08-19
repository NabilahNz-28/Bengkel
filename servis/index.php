<?php
$title = "Data Servis";
require_once '../config/database.php';
require_once '../includes/header.php';

// Ambil semua data servis dengan JOIN ke kendaraan, pelanggan, dan mekanik
$query = "SELECT s.id, s.tanggal_masuk, s.tanggal_selesai, s.keluhan, s.pekerjaan, s.biaya, s.status,
                 k.merk, k.model, k.plat_nomor, k.jenis,
                 p.nama AS nama_pelanggan,
                 m.nama AS nama_mekanik
          FROM servis s
          JOIN kendaraan k ON s.id_kendaraan = k.id
          JOIN pelanggan p ON k.id_pelanggan = p.id
          JOIN mekanik m ON s.id_mekanik = m.id
          ORDER BY s.id DESC";
$result = mysqli_query($conn, $query);

$pesan = '';
if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == 'tambah') $pesan = '<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>Data servis berhasil ditambahkan! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    if ($_GET['pesan'] == 'edit')   $pesan = '<div class="alert alert-info alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>Data servis berhasil diubah! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    if ($_GET['pesan'] == 'hapus')  $pesan = '<div class="alert alert-warning alert-dismissible fade show"><i class="bi bi-trash me-2"></i>Data servis berhasil dihapus! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
}
?>

<div class="page-header">
    <div>
        <h4><i class="bi bi-wrench-adjustable-circle-fill me-2 text-success"></i>Data Servis</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Servis</li>
            </ol>
        </nav>
    </div>
    <a href="tambah.php" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Servis
    </a>
</div>

<?= $pesan ?>

<div class="card table-card">
    <div class="card-header">
        <i class="bi bi-table me-2"></i>Daftar Transaksi Servis
        <span class="badge bg-success ms-2"><?= mysqli_num_rows($result) ?> data</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelanggan & Kendaraan</th>
                        <th>Mekanik</th>
                        <th>Keluhan</th>
                        <th>Tgl Masuk</th>
                        <th>Biaya</th>
                        <th>Status</th>
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
                        <td>
                            <strong><?= htmlspecialchars($row['nama_pelanggan']) ?></strong><br>
                            <small class="text-muted">
                                <?= htmlspecialchars($row['merk']) . ' ' . htmlspecialchars($row['model']) ?>
                                &bull; <?= htmlspecialchars($row['plat_nomor']) ?>
                            </small>
                        </td>
                        <td><?= htmlspecialchars($row['nama_mekanik']) ?></td>
                        <td>
                            <span title="<?= htmlspecialchars($row['keluhan']) ?>">
                                <?= htmlspecialchars(strlen($row['keluhan']) > 40 ? substr($row['keluhan'], 0, 40) . '...' : $row['keluhan']) ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y', strtotime($row['tanggal_masuk'])) ?></td>
                        <td class="fw-semibold">Rp <?= number_format($row['biaya'], 0, ',', '.') ?></td>
                        <td>
                            <?php if ($row['status'] == 'Proses'): ?>
                                <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Proses</span>
                            <?php else: ?>
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Selesai</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning text-white">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                            <button onclick="konfirmasiHapus('../servis/hapus.php?id=<?= $row['id'] ?>', 'servis #<?= $row['id'] ?>')"
                                    class="btn btn-sm btn-danger">
                                <i class="bi bi-trash me-1"></i>Hapus
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr>
                        <td colspan="8" class="no-data">
                            <i class="bi bi-wrench"></i>
                            Belum ada data servis. <a href="tambah.php">Tambah sekarang!</a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
