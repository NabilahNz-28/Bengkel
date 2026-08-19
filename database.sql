-- =============================================
-- SISTEM BENGKEL MOTOR & MOBIL
-- Database: db_bengkel
-- =============================================

CREATE DATABASE IF NOT EXISTS db_bengkel;
USE db_bengkel;

-- =============================================
-- Tabel: pelanggan
-- =============================================
CREATE TABLE IF NOT EXISTS pelanggan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    telepon VARCHAR(15) NOT NULL,
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =============================================
-- Tabel: kendaraan
-- =============================================
CREATE TABLE IF NOT EXISTS kendaraan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pelanggan INT NOT NULL,
    jenis ENUM('Motor', 'Mobil') NOT NULL,
    merk VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    plat_nomor VARCHAR(15) NOT NULL,
    tahun YEAR NOT NULL,
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id) ON DELETE CASCADE
);

-- =============================================
-- Tabel: mekanik
-- =============================================
CREATE TABLE IF NOT EXISTS mekanik (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    telepon VARCHAR(15) NOT NULL,
    spesialisasi ENUM('Motor', 'Mobil', 'Keduanya') NOT NULL DEFAULT 'Keduanya',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =============================================
-- Tabel: servis
-- =============================================
CREATE TABLE IF NOT EXISTS servis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_kendaraan INT NOT NULL,
    id_mekanik INT NOT NULL,
    tanggal_masuk DATE NOT NULL,
    tanggal_selesai DATE,
    keluhan TEXT NOT NULL,
    pekerjaan TEXT,
    biaya DECIMAL(12, 0) DEFAULT 0,
    status ENUM('Proses', 'Selesai') NOT NULL DEFAULT 'Proses',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kendaraan) REFERENCES kendaraan(id) ON DELETE CASCADE,
    FOREIGN KEY (id_mekanik) REFERENCES mekanik(id) ON DELETE CASCADE
);

-- =============================================
-- Data Dummy: pelanggan
-- =============================================
INSERT INTO pelanggan (nama, telepon, alamat) VALUES
('Budi Santoso', '081234567890', 'Jl. Merdeka No. 10, Jakarta'),
('Siti Rahayu', '082345678901', 'Jl. Sudirman No. 25, Bandung'),
('Ahmad Fauzi', '083456789012', 'Jl. Diponegoro No. 5, Surabaya'),
('Rina Wati', '084567890123', 'Jl. Pahlawan No. 8, Yogyakarta'),
('Joko Pramono', '085678901234', 'Jl. Gajah Mada No. 15, Semarang');

-- =============================================
-- Data Dummy: kendaraan
-- =============================================
INSERT INTO kendaraan (id_pelanggan, jenis, merk, model, plat_nomor, tahun) VALUES
(1, 'Motor', 'Honda', 'Beat', 'B 1234 ABC', 2020),
(1, 'Mobil', 'Toyota', 'Avanza', 'B 5678 DEF', 2019),
(2, 'Motor', 'Yamaha', 'NMAX', 'D 2345 GHI', 2021),
(3, 'Mobil', 'Suzuki', 'Ertiga', 'L 3456 JKL', 2018),
(4, 'Motor', 'Honda', 'Vario 125', 'AB 4567 MNO', 2022),
(5, 'Mobil', 'Daihatsu', 'Xenia', 'H 5678 PQR', 2020);

-- =============================================
-- Data Dummy: mekanik
-- =============================================
INSERT INTO mekanik (nama, telepon, spesialisasi) VALUES
('Andi Wijaya', '081111111111', 'Keduanya'),
('Beni Kurniawan', '082222222222', 'Motor'),
('Cahyo Nugroho', '083333333333', 'Mobil'),
('Dedi Permana', '084444444444', 'Motor');

-- =============================================
-- Data Dummy: servis
-- =============================================
INSERT INTO servis (id_kendaraan, id_mekanik, tanggal_masuk, tanggal_selesai, keluhan, pekerjaan, biaya, status) VALUES
(1, 2, '2026-08-10', '2026-08-10', 'Mesin brebet dan susah distarter', 'Ganti busi, servis karburator', 150000, 'Selesai'),
(2, 3, '2026-08-12', '2026-08-13', 'AC tidak dingin', 'Service AC, isi freon', 350000, 'Selesai'),
(3, 2, '2026-08-15', NULL, 'Rem belakang kurang pakem', 'Ganti kampas rem belakang', 120000, 'Proses'),
(4, 1, '2026-08-17', NULL, 'Lampu depan mati dan oli habis', 'Ganti bohlam, ganti oli mesin', 200000, 'Proses'),
(5, 2, '2026-08-18', '2026-08-18', 'Ban bocor', 'Tambal ban tubeless', 50000, 'Selesai');
