-- Membuat Database
CREATE DATABASE donation_db;
USE donation_db;

-- Membuat Tabel Donatur
CREATE TABLE donatur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE,
    nomor_telepon VARCHAR(13) UNIQUE
);

-- Membuat Tabel Donasi
CREATE TABLE donasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jumlah_donasi DOUBLE NOT NULL DEFAULT 0,
    tanggal_donasi DATE NOT NULL,
    jenis_donasi ENUM('uang', 'barang') NOT NULL, -- Menggunakan ENUM untuk pilihan 'uang' dan 'barang'
    id_donatur INT NOT NULL,
    FOREIGN KEY (id_donatur) REFERENCES donatur(id)
);

-- Membuat Tabel Distribusi
CREATE TABLE distribusi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tujuan TEXT NOT NULL, -- Menggunakan tipe data TEXT untuk tujuan distribusi
    tanggal_distribusi DATE NOT NULL,
    status ENUM('proses', 'selesai') NOT NULL, -- Menggunakan ENUM untuk status distribusi
    id_donasi INT NOT NULL,
    FOREIGN KEY (id_donasi) REFERENCES donasi(id)
);

-- Menambahkan Data ke Tabel Donatur
INSERT INTO donatur (name, email, nomor_telepon) VALUES
('Grigori', 'grigori@idk.com', '08123456789'),
('Asda Fegehejekel', 'asda@idk.com', '08234567890');

-- Menambahkan Data ke Tabel Donasi
INSERT INTO donasi (jumlah_donasi, tanggal_donasi, jenis_donasi, id_donatur) VALUES
(1000000, '2025-04-20', 'uang', 1),
(500000, '2025-04-21', 'barang', 2);

-- Menambahkan Data ke Tabel Distribusi
INSERT INTO distribusi (tujuan, tanggal_distribusi, status, id_donasi) VALUES
('Panti Asuhan A', '2025-04-22', 'sudah dilakukan', 1),
('Panti Asuhan B', '2025-04-23', 'belum', 2);
