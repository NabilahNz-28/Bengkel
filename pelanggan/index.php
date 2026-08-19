<?php
$title = "Data Pelanggan";
require_once '../config/database.php';
require_once '../includes/header.php';

// Ambil semua data pelanggan
$query  = "SELECT * FROM pelanggan ORDER BY id DESC";
$result = mysqli_query($conn, $query);

// Pesan sukses dari session (setelah tambah/edit/hapus)
$pesan = '';
if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == 'tambah')  $pesan = '<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>Data pelanggan berhasil ditambahkan! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    if ($_GET['pesan'] == 'edit')    $pesan = '<div class="alert alert-info alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>Data pelanggan berhasil diubah! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    if ($_GET['pesan'] == 'hapus')   $pesan = '<div class="alert alert-warning alert-dismissible fade show"><i class="bi bi-trash me-2"></i>Data pelanggan berhasil dihapus! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
}
?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h4><i class="bi bi-people-fill me-2 text-primary"></i>Data Pelanggan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Pelanggan</li>
            </ol>
        </nav>
    </div>
    <a href="tambah.php" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Pelanggan
    </a>
</div>

<?= $pesan ?>

<!-- TABEL DATA -->
<div class="card table-card">
    <div class="card-header">
        <i class="bi bi-table me-2"></i>Daftar Pelanggan
        <span class="badge bg-primary ms-2"><?= mysqli_num_rows($result) ?> data</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th>Nama Pelanggan</th>
                        <th>No. Telepon</th>
                        <th>Alamat</th>
                        <th>Tanggal Daftar</th>
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
                            <strong><?= htmlspecialchars($row['nama']) ?></strong>
                        </td>
                        <td>
                            <i class="bi bi-telephone me-1 text-muted"></i>
                            <?= htmlspecialchars($row['telepon']) ?>
                        </td>
                        <td><?= htmlspecialchars($row['alamat'] ?? '-') ?></td>
                        <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning text-white">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                            <button onclick="konfirmasiHapus('../pelanggan/hapus.php?id=<?= $row['id'] ?>', '<?= addslashes($row['nama']) ?>')"
                                    class="btn btn-sm btn-danger">
                                <i class="bi bi-trash me-1"></i>Hapus
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr>
                        <td colspan="6" class="no-data">
                            <i class="bi bi-people"></i>
                            Belum ada data pelanggan. <a href="tambah.php">Tambah sekarang!</a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
