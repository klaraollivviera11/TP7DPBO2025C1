<?php
require_once 'config/db.php';

class Donasi {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAllDonasi() {
        $stmt = $this->db->query("SELECT donasi.*, donatur.name AS nama_donatur
                                    FROM donasi
                                    JOIN donatur ON donasi.id_donatur = donatur.id;");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createDonasi($jumlah_donasi, $tanggal_donasi, $jenis_donasi, $id_donatur) {
        $stmt = $this->db->prepare("INSERT INTO donasi (jumlah_donasi, tanggal_donasi, jenis_donasi, id_donatur) VALUES (?, ?, ?, ?)");
        
        return $stmt->execute([$jumlah_donasi, $tanggal_donasi, $jenis_donasi, $id_donatur]);
    }

    public function updateDonasi($id, $jumlah_donasi, $tanggal_donasi, $jenis_donasi, $id_donatur) {
        $stmt = $this->db->prepare("UPDATE donasi SET jumlah_donasi = ?, tanggal_donasi = ?, jenis_donasi = ?, id_donatur = ? WHERE id = ?");
        
        return $stmt->execute([$jumlah_donasi, $tanggal_donasi, $jenis_donasi, $id_donatur]);
    }

    public function deleteDonasi($id) {
        $stmt = $this->db->prepare("DELETE FROM donasi WHERE id = ?");
        
        return $stmt->execute([$id]);
    }

    public function searchDonasi($name) {
        $stmt = $this->db->prepare("SELECT donasi.*, donatur.name AS nama_donatur
                                    FROM donasi
                                    JOIN donatur ON donasi.id_donatur = donatur.id
                                    WHERE donatur.name LIKE :name");
        
        $name = "%" . $name . "%";

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>