// Konfirmasi sebelum hapus data
function konfirmasiHapus(url, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus data "' + nama + '"?\nData yang dihapus tidak dapat dikembalikan!')) {
        window.location.href = url;
    }
}

// Format angka ke Rupiah
function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(angka);
}

// Auto hide alert setelah 4 detik
document.addEventListener('DOMContentLoaded', function () {
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 4000);
    });
});
