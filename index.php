<?php
$title = "Dashboard";
require_once 'config/database.php';
require_once 'includes/header.php';

// Hitung total data untuk statistik
$total_pelanggan = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM pelanggan"))[0];
$total_kendaraan = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM kendaraan"))[0];
$total_mekanik   = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM mekanik"))[0];
$total_servis    = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM servis"))[0];
$servis_proses   = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM servis WHERE status='Proses'"))[0];
$servis_selesai  = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM servis WHERE status='Selesai'"))[0];
$total_pendapatan = mysqli_fetch_row(mysqli_query($conn, "SELECT SUM(biaya) FROM servis WHERE status='Selesai'"))[0];

// 5 servis terbaru
$query_terbaru = "SELECT s.id, p.nama AS nama_pelanggan, k.merk, k.model, k.plat_nomor,
                         m.nama AS nama_mekanik, s.tanggal_masuk, s.biaya, s.status
                  FROM servis s
                  JOIN kendaraan k ON s.id_kendaraan = k.id
                  JOIN pelanggan p ON k.id_pelanggan = p.id
                  JOIN mekanik m ON s.id_mekanik = m.id
                  ORDER BY s.created_at DESC LIMIT 5";
$result_terbaru = mysqli_query($conn, $query_terbaru);
?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h4><i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Beranda</li>
            </ol>
        </nav>
    </div>
    <span class="text-muted small">Selamat datang di Sistem Bengkel Motor & Mobil</span>
</div>

<!-- STATISTIK CARDS -->
<div class="row g-3 mb-4">
    <!-- Pelanggan -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="stat-number text-primary"><?= $total_pelanggan ?></div>
                    <div class="stat-label">Total Pelanggan</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kendaraan -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-car-front-fill"></i>
                </div>
                <div>
                    <div class="stat-number text-info"><?= $total_kendaraan ?></div>
                    <div class="stat-label">Total Kendaraan</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mekanik -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <div>
                    <div class="stat-number text-warning"><?= $total_mekanik ?></div>
                    <div class="stat-label">Total Mekanik</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Servis -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-wrench-adjustable-circle-fill"></i>
                </div>
                <div>
                    <div class="stat-number text-success"><?= $total_servis ?></div>
                    <div class="stat-label">Total Servis</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- STATUS SERVIS & PENDAPATAN -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card stat-card h-100">
            <div class="card-body">
                <h6 class="text-muted mb-3"><i class="bi bi-bar-chart-fill me-2"></i>Status Servis</h6>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-warning text-dark badge-status">
                        <i class="bi bi-clock me-1"></i> Proses
                    </span>
                    <strong class="text-warning fs-4"><?= $servis_proses ?></strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-success badge-status">
                        <i class="bi bi-check-circle me-1"></i> Selesai
                    </span>
                    <strong class="text-success fs-4"><?= $servis_selesai ?></strong>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card stat-card h-100" style="background: linear-gradient(135deg, #0d6efd, #0056b3); color:white">
            <div class="card-body d-flex flex-column justify-content-center">
                <div class="text-white-50 mb-2"><i class="bi bi-cash-coin me-2"></i>Total Pendapatan</div>
                <div class="fs-3 fw-bold">
                    Rp <?= number_format($total_pendapatan ?? 0, 0, ',', '.') ?>
                </div>
                <div class="text-white-50 small mt-1">Dari servis yang sudah selesai</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                <h6 class="text-muted mb-3"><i class="bi bi-lightning-fill me-2 text-warning"></i>Menu Cepat</h6>
                <a href="servis/tambah.php" class="btn btn-primary btn-sm mb-2 w-100">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Servis Baru
                </a>
                <a href="pelanggan/tambah.php" class="btn btn-outline-secondary btn-sm w-100">
                    <i class="bi bi-person-plus me-2"></i>Tambah Pelanggan
                </a>
            </div>
        </div>
    </div>
</div>

<!-- TABEL SERVIS TERBARU -->
<div class="card table-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clock-history me-2 text-primary"></i>Servis Terbaru</span>
        <a href="servis/index.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Mekanik</th>
                        <th>Tanggal Masuk</th>
                        <th>Biaya</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if (mysqli_num_rows($result_terbaru) > 0):
                        while ($row = mysqli_fetch_assoc($result_terbaru)):
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                        <td>
                            <?= htmlspecialchars($row['merk']) . ' ' . htmlspecialchars($row['model']) ?><br>
                            <small class="text-muted"><?= htmlspecialchars($row['plat_nomor']) ?></small>
                        </td>
                        <td><?= htmlspecialchars($row['nama_mekanik']) ?></td>
                        <td><?= date('d/m/Y', strtotime($row['tanggal_masuk'])) ?></td>
                        <td>Rp <?= number_format($row['biaya'], 0, ',', '.') ?></td>
                        <td>
                            <?php if ($row['status'] == 'Proses'): ?>
                                <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Proses</span>
                            <?php else: ?>
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Selesai</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr>
                        <td colspan="7" class="no-data">
                            <i class="bi bi-inbox"></i>
                            Belum ada data servis
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
