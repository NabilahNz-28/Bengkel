<?php
$title = "Edit Kendaraan";
require_once '../config/database.php';

$id    = $_GET['id'] ?? 0;
$error = '';

// Ambil data kendaraan
$result = mysqli_query($conn, "SELECT * FROM kendaraan WHERE id = $id");
if (mysqli_num_rows($result) == 0) { header("Location: index.php"); exit(); }
$data = mysqli_fetch_assoc($result);

// Ambil daftar pelanggan untuk dropdown
$pelanggan_list = mysqli_query($conn, "SELECT id, nama FROM pelanggan ORDER BY nama ASC");

// Proses update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pelanggan = $_POST['id_pelanggan'];
    $jenis        = $_POST['jenis'];
    $merk         = trim($_POST['merk']);
    $model        = trim($_POST['model']);
    $plat_nomor   = strtoupper(trim($_POST['plat_nomor']));
    $tahun        = $_POST['tahun'];

    if (empty($id_pelanggan) || empty($merk) || empty($model) || empty($plat_nomor) || empty($tahun)) {
        $error = "Semua field wajib diisi!";
    } else {
        $sql = "UPDATE kendaraan SET id_pelanggan='$id_pelanggan', jenis='$jenis', merk='$merk',
                model='$model', plat_nomor='$plat_nomor', tahun='$tahun' WHERE id=$id";

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
        <h4><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Kendaraan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="index.php">Kendaraan</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
</div>

<?php if ($error): ?>
<div class="alert alert-danger"><i class="bi bi-exclamation-circle me-2"></i><?= $error ?></div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card form-card">
            <div class="card-header" style="background: linear-gradient(135deg, #ffc107, #e0a800); color:#333">
                <i class="bi bi-pencil me-2"></i>Form Edit Kendaraan
            </div>
            <div class="card-body p-4">
                <form method="POST" action="">

                    <div class="mb-3">
                        <label for="id_pelanggan" class="form-label">Pemilik Kendaraan <span class="text-danger">*</span></label>
                        <select class="form-select" id="id_pelanggan" name="id_pelanggan" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php
                            $cur_id_pelanggan = isset($_POST['id_pelanggan']) ? $_POST['id_pelanggan'] : $data['id_pelanggan'];
                            while ($p = mysqli_fetch_assoc($pelanggan_list)): ?>
                            <option value="<?= $p['id'] ?>" <?= ($cur_id_pelanggan == $p['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['nama']) ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis Kendaraan <span class="text-danger">*</span></label>
                        <?php $cur_jenis = isset($_POST['jenis']) ? $_POST['jenis'] : $data['jenis']; ?>
                        <select class="form-select" id="jenis" name="jenis" required>
                            <option value="Motor" <?= $cur_jenis == 'Motor' ? 'selected' : '' ?>>Motor</option>
                            <option value="Mobil" <?= $cur_jenis == 'Mobil' ? 'selected' : '' ?>>Mobil</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="merk" class="form-label">Merk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="merk" name="merk"
                                   value="<?= htmlspecialchars(isset($_POST['merk']) ? $_POST['merk'] : $data['merk']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="model" class="form-label">Model / Tipe <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="model" name="model"
                                   value="<?= htmlspecialchars(isset($_POST['model']) ? $_POST['model'] : $data['model']) ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="plat_nomor" class="form-label">Plat Nomor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-uppercase" id="plat_nomor" name="plat_nomor"
                                   value="<?= htmlspecialchars(isset($_POST['plat_nomor']) ? $_POST['plat_nomor'] : $data['plat_nomor']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="tahun" name="tahun"
                                   min="1990" max="<?= date('Y') ?>"
                                   value="<?= htmlspecialchars(isset($_POST['tahun']) ? $_POST['tahun'] : $data['tahun']) ?>" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-2">
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
