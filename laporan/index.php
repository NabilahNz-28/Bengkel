<?php
$title = "Laporan Rekap Servis";
require_once '../config/database.php';
require_once '../includes/header.php';

// Filter dari form
$filter_status      = isset($_GET['status'])       ? $_GET['status']       : '';
$filter_tgl_awal    = isset($_GET['tgl_awal'])     ? $_GET['tgl_awal']     : '';
$filter_tgl_akhir   = isset($_GET['tgl_akhir'])    ? $_GET['tgl_akhir']    : '';

// Bangun query dengan kondisi filter
$where = "WHERE 1=1";

if (!empty($filter_status)) {
    $where .= " AND s.status = '$filter_status'";
}
if (!empty($filter_tgl_awal)) {
    $where .= " AND s.tanggal_masuk >= '$filter_tgl_awal'";
}
if (!empty($filter_tgl_akhir)) {
    $where .= " AND s.tanggal_masuk <= '$filter_tgl_akhir'";
}

$query = "SELECT s.id, s.tanggal_masuk, s.tanggal_selesai, s.keluhan, s.pekerjaan, s.biaya, s.status,
                 k.merk, k.model, k.plat_nomor, k.jenis,
                 p.nama AS nama_pelanggan,
                 m.nama AS nama_mekanik
          FROM servis s
          JOIN kendaraan k ON s.id_kendaraan = k.id
          JOIN pelanggan p ON k.id_pelanggan = p.id
          JOIN mekanik m ON s.id_mekanik = m.id
          $where
          ORDER BY s.tanggal_masuk DESC";

$result = mysqli_query($conn, $query);

// Hitung total biaya dari hasil filter
$query_total = "SELECT SUM(s.biaya), COUNT(*) FROM servis s
                JOIN kendaraan k ON s.id_kendaraan = k.id
                $where AND s.status = 'Selesai'";
$row_total   = mysqli_fetch_row(mysqli_query($conn, $query_total));
$total_biaya = $row_total[0] ?? 0;
$total_selesai = $row_total[1] ?? 0;
?>

<div class="page-header">
    <div>
        <h4><i class="bi bi-file-earmark-bar-graph-fill me-2 text-primary"></i>Laporan Rekap Servis</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan</li>
            </ol>
        </nav>
    </div>
    <button onclick="window.print()" class="btn btn-outline-secondary">
        <i class="bi bi-printer me-2"></i>Cetak Laporan
    </button>
</div>

<!-- FILTER -->
<div class="card table-card mb-3">
    <div class="card-header"><i class="bi bi-funnel me-2"></i>Filter Laporan</div>
    <div class="card-body">
        <form method="GET" action="" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Status Servis</label>
                <select class="form-select" name="status">
                    <option value="">-- Semua Status --</option>
                    <option value="Proses"  <?= $filter_status == 'Proses'  ? 'selected' : '' ?>>Proses</option>
                    <option value="Selesai" <?= $filter_status == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Masuk (Dari)</label>
                <input type="date" class="form-control" name="tgl_awal" value="<?= $filter_tgl_awal ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Masuk (Sampai)</label>
                <input type="date" class="form-control" name="tgl_akhir" value="<?= $filter_tgl_akhir ?>">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
                <a href="index.php" class="btn btn-outline-secondary">
                    <i class="bi bi-x"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- RINGKASAN -->
<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-list-check"></i>
                </div>
                <div>
                    <div class="stat-number text-primary"><?= mysqli_num_rows($result) ?></div>
                    <div class="stat-label">Total Data Servis</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div>
                    <div class="stat-number text-success"><?= $total_selesai ?></div>
                    <div class="stat-label">Servis Selesai</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card" style="background: linear-gradient(135deg, #198754, #146c43); color:white">
            <div class="card-body">
                <div class="text-white-50 small mb-1"><i class="bi bi-cash-coin me-1"></i>Total Pendapatan</div>
                <div class="fs-4 fw-bold">Rp <?= number_format($total_biaya, 0, ',', '.') ?></div>
                <div class="text-white-50 small">Dari servis selesai</div>
            </div>
        </div>
    </div>
</div>

<!-- TABEL LAPORAN -->
<div class="card table-card">
    <div class="card-header">
        <i class="bi bi-table me-2"></i>Detail Laporan Servis
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tgl Masuk</th>
                        <th>Tgl Selesai</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Mekanik</th>
                        <th>Keluhan</th>
                        <th>Pekerjaan</th>
                        <th>Biaya</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Reset pointer result ke awal
                    mysqli_data_seek($result, 0);
                    $no = 1;
                    if (mysqli_num_rows($result) > 0):
                        while ($row = mysqli_fetch_assoc($result)):
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d/m/Y', strtotime($row['tanggal_masuk'])) ?></td>
                        <td><?= $row['tanggal_selesai'] ? date('d/m/Y', strtotime($row['tanggal_selesai'])) : '<span class="text-muted">-</span>' ?></td>
                        <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                        <td>
                            <?= htmlspecialchars($row['merk'] . ' ' . $row['model']) ?><br>
                            <small class="badge bg-secondary"><?= htmlspecialchars($row['plat_nomor']) ?></small>
                        </td>
                        <td><?= htmlspecialchars($row['nama_mekanik']) ?></td>
                        <td><?= htmlspecialchars($row['keluhan']) ?></td>
                        <td><?= htmlspecialchars($row['pekerjaan'] ?? '-') ?></td>
                        <td class="fw-semibold">Rp <?= number_format($row['biaya'], 0, ',', '.') ?></td>
                        <td>
                            <?php if ($row['status'] == 'Proses'): ?>
                                <span class="badge bg-warning text-dark">Proses</span>
                            <?php else: ?>
                                <span class="badge bg-success">Selesai</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr>
                        <td colspan="10" class="no-data">
                            <i class="bi bi-search"></i>
                            Tidak ada data yang sesuai dengan filter.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                <tfoot>
                    <tr class="table-light fw-bold">
                        <td colspan="8" class="text-end">Total Pendapatan (Selesai):</td>
                        <td>Rp <?= number_format($total_biaya, 0, ',', '.') ?></td>
                        <td></td>
                    </tr>
                </tfoot>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>

<!-- CSS Cetak -->
<style>
@media print {
    .sidebar, .navbar, .page-header button, .card-header button, form, .btn { display: none !important; }
    body { background: white; }
    .main-content { padding: 0 !important; }
}
</style>

<?php require_once '../includes/footer.php'; ?>
