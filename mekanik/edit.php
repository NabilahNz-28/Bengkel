<?php
$title = "Edit Mekanik";
require_once '../config/database.php';

$id    = $_GET['id'] ?? 0;
$error = '';

$result = mysqli_query($conn, "SELECT * FROM mekanik WHERE id = $id");
if (mysqli_num_rows($result) == 0) { header("Location: index.php"); exit(); }
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama         = trim($_POST['nama']);
    $telepon      = trim($_POST['telepon']);
    $spesialisasi = $_POST['spesialisasi'];

    if (empty($nama) || empty($telepon)) {
        $error = "Nama dan No. Telepon wajib diisi!";
    } else {
        $sql = "UPDATE mekanik SET nama='$nama', telepon='$telepon', spesialisasi='$spesialisasi' WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?pesan=edit");
            exit();
        } else {
            $error = "Gagal mengubah data: " . mysqli_error($conn);
        }
    }
}

require_once '../includes/header.php';
?>

<div class="page-header">
    <div>
        <h4><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Mekanik</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="index.php">Mekanik</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
</div>

<?php if ($error): ?>
<div class="alert alert-danger"><i class="bi bi-exclamation-circle me-2"></i><?= $error ?></div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card form-card">
            <div class="card-header" style="background: linear-gradient(135deg, #ffc107, #e0a800); color:#333">
                <i class="bi bi-pencil me-2"></i>Form Edit Mekanik
            </div>
            <div class="card-body p-4">
                <form method="POST" action="">

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Mekanik <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama"
                               value="<?= htmlspecialchars(isset($_POST['nama']) ? $_POST['nama'] : $data['nama']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="telepon" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="text" class="form-control" id="telepon" name="telepon"
                                   value="<?= htmlspecialchars(isset($_POST['telepon']) ? $_POST['telepon'] : $data['telepon']) ?>" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="spesialisasi" class="form-label">Spesialisasi</label>
                        <?php $cur_spes = isset($_POST['spesialisasi']) ? $_POST['spesialisasi'] : $data['spesialisasi']; ?>
                        <select class="form-select" id="spesialisasi" name="spesialisasi">
                            <option value="Motor"    <?= $cur_spes == 'Motor'    ? 'selected' : '' ?>>Motor</option>
                            <option value="Mobil"    <?= $cur_spes == 'Mobil'    ? 'selected' : '' ?>>Mobil</option>
                            <option value="Keduanya" <?= $cur_spes == 'Keduanya' ? 'selected' : '' ?>>Keduanya (Motor & Mobil)</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="bi bi-save me-2"></i>Simpan Perubahan
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
