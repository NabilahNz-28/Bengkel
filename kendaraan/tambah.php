<?php
$title = "Tambah Kendaraan";
require_once '../config/database.php';

$error = '';

// Ambil daftar pelanggan untuk dropdown
$pelanggan_list = mysqli_query($conn, "SELECT id, nama FROM pelanggan ORDER BY nama ASC");

// Proses simpan data
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
        $sql = "INSERT INTO kendaraan (id_pelanggan, jenis, merk, model, plat_nomor, tahun)
                VALUES ('$id_pelanggan', '$jenis', '$merk', '$model', '$plat_nomor', '$tahun')";

        if (mysqli_query($conn, $sql)) {
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
        <h4><i class="bi bi-car-front me-2 text-info"></i>Tambah Kendaraan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="index.php">Kendaraan</a></li>
                <li class="breadcrumb-item active">Tambah</li>
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
            <div class="card-header">
                <i class="bi bi-car-front me-2"></i>Form Tambah Kendaraan
            </div>
            <div class="card-body p-4">
                <form method="POST" action="">

                    <div class="mb-3">
                        <label for="id_pelanggan" class="form-label">Pemilik Kendaraan <span class="text-danger">*</span></label>
                        <select class="form-select" id="id_pelanggan" name="id_pelanggan" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php while ($p = mysqli_fetch_assoc($pelanggan_list)): ?>
                            <option value="<?= $p['id'] ?>"
                                <?= (isset($_POST['id_pelanggan']) && $_POST['id_pelanggan'] == $p['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['nama']) ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis Kendaraan <span class="text-danger">*</span></label>
                        <select class="form-select" id="jenis" name="jenis" required>
                            <option value="Motor" <?= (isset($_POST['jenis']) && $_POST['jenis'] == 'Motor') ? 'selected' : '' ?>>Motor</option>
                            <option value="Mobil" <?= (isset($_POST['jenis']) && $_POST['jenis'] == 'Mobil') ? 'selected' : '' ?>>Mobil</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="merk" class="form-label">Merk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="merk" name="merk"
                                   placeholder="Contoh: Honda, Toyota, Yamaha"
                                   value="<?= isset($_POST['merk']) ? htmlspecialchars($_POST['merk']) : '' ?>"
                                   required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="model" class="form-label">Model / Tipe <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="model" name="model"
                                   placeholder="Contoh: Beat, Avanza, NMAX"
                                   value="<?= isset($_POST['model']) ? htmlspecialchars($_POST['model']) : '' ?>"
                                   required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="plat_nomor" class="form-label">Plat Nomor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-uppercase" id="plat_nomor" name="plat_nomor"
                                   placeholder="Contoh: B 1234 ABC"
                                   value="<?= isset($_POST['plat_nomor']) ? htmlspecialchars($_POST['plat_nomor']) : '' ?>"
                                   required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="tahun" name="tahun"
                                   min="1990" max="<?= date('Y') ?>"
                                   placeholder="<?= date('Y') ?>"
                                   value="<?= isset($_POST['tahun']) ? htmlspecialchars($_POST['tahun']) : '' ?>"
                                   required>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-2">
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
