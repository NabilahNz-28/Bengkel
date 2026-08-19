<?php
$title = "Data Mekanik";
require_once '../config/database.php';
require_once '../includes/header.php';

$query  = "SELECT * FROM mekanik ORDER BY id DESC";
$result = mysqli_query($conn, $query);

$pesan = '';
if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == 'tambah') $pesan = '<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>Data mekanik berhasil ditambahkan! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    if ($_GET['pesan'] == 'edit')   $pesan = '<div class="alert alert-info alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>Data mekanik berhasil diubah! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    if ($_GET['pesan'] == 'hapus')  $pesan = '<div class="alert alert-warning alert-dismissible fade show"><i class="bi bi-trash me-2"></i>Data mekanik berhasil dihapus! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
}
?>

<div class="page-header">
    <div>
        <h4><i class="bi bi-person-badge-fill me-2 text-warning"></i>Data Mekanik</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Mekanik</li>
            </ol>
        </nav>
    </div>
    <a href="tambah.php" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Mekanik
    </a>
</div>

<?= $pesan ?>

<div class="card table-card">
    <div class="card-header">
        <i class="bi bi-table me-2"></i>Daftar Mekanik
        <span class="badge bg-warning text-dark ms-2"><?= mysqli_num_rows($result) ?> data</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mekanik</th>
                        <th>No. Telepon</th>
                        <th>Spesialisasi</th>
                        <th>Tanggal Bergabung</th>
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
                        <td><strong><?= htmlspecialchars($row['nama']) ?></strong></td>
                        <td><i class="bi bi-telephone me-1 text-muted"></i><?= htmlspecialchars($row['telepon']) ?></td>
                        <td>
                            <?php
                            $badge = match($row['spesialisasi']) {
                                'Motor'    => 'bg-success',
                                'Mobil'    => 'bg-info',
                                'Keduanya' => 'bg-primary',
                                default    => 'bg-secondary'
                            };
                            ?>
                            <span class="badge <?= $badge ?>">
                                <i class="bi bi-tools me-1"></i><?= $row['spesialisasi'] ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning text-white">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                            <button onclick="konfirmasiHapus('../mekanik/hapus.php?id=<?= $row['id'] ?>', '<?= addslashes($row['nama']) ?>')"
                                    class="btn btn-sm btn-danger">
                                <i class="bi bi-trash me-1"></i>Hapus
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr>
                        <td colspan="6" class="no-data">
                            <i class="bi bi-person-badge"></i>
                            Belum ada data mekanik. <a href="tambah.php">Tambah sekarang!</a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
