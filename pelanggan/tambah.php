<?php
$title = "Tambah Pelanggan";
require_once '../config/database.php';

$error = '';

// Proses simpan data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama     = trim($_POST['nama']);
    $telepon  = trim($_POST['telepon']);
    $alamat   = trim($_POST['alamat']);

    // Validasi sederhana
    if (empty($nama) || empty($telepon)) {
        $error = "Nama dan No. Telepon wajib diisi!";
    } else {
        // Simpan ke database
        $sql = "INSERT INTO pelanggan (nama, telepon, alamat) VALUES ('$nama', '$telepon', '$alamat')";

        if (mysqli_query($conn, $sql)) {
            // Redirect ke halaman daftar dengan pesan sukses
            header("Location: index.php?pesan=tambah");
            exit();
        } else {
            $error = "Gagal menyimpan data: " . mysqli_error($conn);
        }
    }
}

require_once '../includes/header.php';
?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h4><i class="bi bi-person-plus-fill me-2 text-primary"></i>Tambah Pelanggan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="index.php">Pelanggan</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>
</div>

<?php if ($error): ?>
<div class="alert alert-danger"><i class="bi bi-exclamation-circle me-2"></i><?= $error ?></div>
<?php endif; ?>

<!-- FORM TAMBAH -->
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card form-card">
            <div class="card-header">
                <i class="bi bi-person-plus me-2"></i>Form Tambah Pelanggan
            </div>
            <div class="card-body p-4">
                <form method="POST" action="">
                    
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama"
                               placeholder="Masukkan nama lengkap pelanggan"
                               value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '' ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="telepon" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="text" class="form-control" id="telepon" name="telepon"
                                   placeholder="Contoh: 081234567890"
                                   value="<?= isset($_POST['telepon']) ? htmlspecialchars($_POST['telepon']) : '' ?>"
                                   required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat"
                                  rows="3" placeholder="Masukkan alamat pelanggan (opsional)"><?= isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : '' ?></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Simpan Data
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
