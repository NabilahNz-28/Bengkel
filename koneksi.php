<?php
// =============================================
// Koneksi Database - Sistem Bengkel
// =============================================

$host     = "localhost";
$user     = "root";
$password = "";
$database = "db_bengkel";

// Membuat koneksi
$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$conn) {
    die("<div style='text-align:center; padding:50px; font-family:Arial'>
        <h2 style='color:red'>&#10060; Koneksi Database Gagal!</h2>
        <p>" . mysqli_connect_error() . "</p>
        <p>Pastikan XAMPP sudah berjalan dan database <b>db_bengkel</b> sudah dibuat.</p>
    </div>");
}

// Set charset UTF-8 agar karakter tidak error
mysqli_set_charset($conn, "utf8");
?>
