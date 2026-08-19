<?php
$title = "Tambah Servis";
require_once '../config/database.php';

$error = '';

// Ambil daftar kendaraan (tampilkan merk + plat + nama pemilik)
$kendaraan_list = mysqli_query($conn, "SELECT k.id, k.merk, k.model, k.plat_nomor, p.nama AS nama_pelanggan
                                       FROM kendaraan k
                                       JOIN pelanggan p ON k.id_pelanggan = p.id
                                       ORDER BY p.nama ASC");

// Ambil daftar mekanik
$mekanik_list = mysqli_query($conn, "SELECT id, nama, spesialisasi FROM mekanik ORDER BY nama ASC");

// Proses simpan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kendaraan    = $_POST['id_kendaraan'];
    $id_mekanik      = $_POST['id_mekanik'];
    $tanggal_masuk   = $_POST['tanggal_masuk'];
    $tanggal_selesai = !empty($_POST['tanggal_selesai']) ? "'" . $_POST['tanggal_selesai'] . "'" : "NULL";
    $keluhan         = trim($_POST['keluhan']);
    $pekerjaan       = trim($_POST['pekerjaan']);
    $biaya           = str_replace('.', '', $_POST['biaya']); // Hapus titik dari format ribuan
    $biaya           = !empty($biaya) ? $biaya : 0;
    $status          = $_POST['status'];

    if (empty($id_kendaraan) || empty($id_mekanik) || empty($tanggal_masuk) || empty($keluhan)) {
        $error = "Kendaraan, mekanik, tanggal masuk, dan keluhan wajib diisi!";
    } else {
        $sql = "INSERT INTO servis (id_kendaraan, id_mekanik, tanggal_masuk, tanggal_selesai, keluhan, pekerjaan, biaya, status)
                VALUES ('$id_kendaraan', '$id_mekanik', '$tanggal_masuk', $tanggal_selesai, '$keluhan', '$pekerjaan', '$biaya', '$status')";

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

<div class="page-header">
    <div>
        <h4><i class="bi bi-wrench-adjustable me-2 text-success"></i>Tambah Servis</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="index.php">Servis</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>
</div>

<?php if ($error): ?>
<div class="alert alert-danger"><i class="bi bi-exclamation-circle me-2"></i><?= $error ?></div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card form-card">
            <div class="card-header">
                <i class="bi bi-clipboard-plus me-2"></i>Form Tambah Transaksi Servis
            </div>
            <div class="card-body p-4">
                <form method="POST" action="">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="id_kendaraan" class="form-label">Kendaraan <span class="text-danger">*</span></label>
                            <select class="form-select" id="id_kendaraan" name="id_kendaraan" required>
                                <option value="">-- Pilih Kendaraan --</option>
                                <?php while ($k = mysqli_fetch_assoc($kendaraan_list)): ?>
                                <option value="<?= $k['id'] ?>"
                                    <?= (isset($_POST['id_kendaraan']) && $_POST['id_kendaraan'] == $k['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($k['nama_pelanggan']) ?> -
                                    <?= htmlspecialchars($k['merk'] . ' ' . $k['model']) ?>
                                    (<?= htmlspecialchars($k['plat_nomor']) ?>)
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="id_mekanik" class="form-label">Mekanik <span class="text-danger">*</span></label>
                            <select class="form-select" id="id_mekanik" name="id_mekanik" required>
                                <option value="">-- Pilih Mekanik --</option>
                                <?php while ($m = mysqli_fetch_assoc($mekanik_list)): ?>
                                <option value="<?= $m['id'] ?>"
                                    <?= (isset($_POST['id_mekanik']) && $_POST['id_mekanik'] == $m['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($m['nama']) ?> (<?= $m['spesialisasi'] ?>)
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_masuk" class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk"
                                   value="<?= isset($_POST['tanggal_masuk']) ? $_POST['tanggal_masuk'] : date('Y-m-d') ?>"
                                   required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai <small class="text-muted">(opsional)</small></label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                   value="<?= isset($_POST['tanggal_selesai']) ? $_POST['tanggal_selesai'] : '' ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keluhan" class="form-label">Keluhan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="keluhan" name="keluhan" rows="2"
                                  placeholder="Tuliskan keluhan pelanggan..." required><?= isset($_POST['keluhan']) ? htmlspecialchars($_POST['keluhan']) : '' ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="pekerjaan" class="form-label">Pekerjaan yang Dilakukan</label>
                        <textarea class="form-control" id="pekerjaan" name="pekerjaan" rows="2"
                                  placeholder="Tuliskan pekerjaan/tindakan yang dilakukan..."><?= isset($_POST['pekerjaan']) ? htmlspecialchars($_POST['pekerjaan']) : '' ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="biaya" class="form-label">Biaya (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="biaya" name="biaya"
                                       min="0" placeholder="0"
                                       value="<?= isset($_POST['biaya']) ? htmlspecialchars($_POST['biaya']) : '' ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status Servis</label>
                            <?php $cur_status = isset($_POST['status']) ? $_POST['status'] : 'Proses'; ?>
                            <select class="form-select" id="status" name="status">
                                <option value="Proses"  <?= $cur_status == 'Proses'  ? 'selected' : '' ?>>🕐 Proses</option>
                                <option value="Selesai" <?= $cur_status == 'Selesai' ? 'selected' : '' ?>>✅ Selesai</option>
                            </select>
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
