<?php
// Tentukan path aktif untuk highlight menu
$current_page = basename($_SERVER['PHP_SELF']);
$current_dir  = basename(dirname($_SERVER['PHP_SELF']));

// Hitung kedalaman folder untuk path relatif
$depth = ($current_dir == 'bengkel' || $current_dir == '.') ? '' : '../';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - Bengkel Motor & Mobil' : 'Sistem Bengkel Motor & Mobil' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= $depth ?>assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- NAVBAR TOP -->
<nav class="navbar navbar-dark bg-primary navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= $depth ?>index.php">
            <i class="bi bi-tools me-2"></i> BengkelKu
        </a>
        <span class="navbar-text text-white-50 small">
            <i class="bi bi-calendar3 me-1"></i>
            <?= date('l, d F Y') ?>
        </span>
    </div>
</nav>

<!-- LAYOUT UTAMA -->
<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- SIDEBAR -->
        <div class="col-md-2 sidebar">
            <div class="sidebar-heading">Menu Utama</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= ($current_dir == 'bengkel' || $current_dir == '.') ? 'active' : '' ?>"
                       href="<?= $depth ?>index.php">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
            </ul>

            <div class="sidebar-heading mt-2">Master Data</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= ($current_dir == 'pelanggan') ? 'active' : '' ?>"
                       href="<?= $depth ?>pelanggan/index.php">
                        <i class="bi bi-people"></i> Pelanggan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_dir == 'kendaraan') ? 'active' : '' ?>"
                       href="<?= $depth ?>kendaraan/index.php">
                        <i class="bi bi-car-front"></i> Kendaraan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_dir == 'mekanik') ? 'active' : '' ?>"
                       href="<?= $depth ?>mekanik/index.php">
                        <i class="bi bi-person-badge"></i> Mekanik
                    </a>
                </li>
            </ul>

            <div class="sidebar-heading mt-2">Transaksi</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= ($current_dir == 'servis') ? 'active' : '' ?>"
                       href="<?= $depth ?>servis/index.php">
                        <i class="bi bi-wrench-adjustable"></i> Data Servis
                    </a>
                </li>
            </ul>

            <div class="sidebar-heading mt-2">Laporan</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= ($current_dir == 'laporan') ? 'active' : '' ?>"
                       href="<?= $depth ?>laporan/index.php">
                        <i class="bi bi-file-earmark-bar-graph"></i> Rekap Servis
                    </a>
                </li>
            </ul>
        </div>
        <!-- END SIDEBAR -->

        <!-- MAIN CONTENT -->
        <div class="col-md-10 main-content">
