
<?php
require_once 'config/db.php';

class Distribusi {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAllDistribusi() {
        $stmt = $this->db->query("SELECT distribusi.*, donasi.jenis_donasi, donasi.jumlah_donasi, donatur.name AS nama_donatur
                                    FROM distribusi
                                    JOIN donasi ON distribusi.id_donasi = donasi.id
                                    JOIN donatur ON donasi.id_donatur = donatur.id;");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDistribusiById($id) {
        $stmt = $this->db->prepare("SELECT distribusi.*, donasi.jenis_donasi, donasi.jumlah_donasi, donatur.name
                                    FROM distribusi
                                    JOIN donasi ON distribusi.id_donasi = donasi.id
                                    JOIN donatur ON donasi.id_donatur = donatur.id
                                    WHERE distribusi.id = ?");
        
        $stmt->execute([$id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDonasiList() {
        $stmt = $this->db->query("SELECT donasi.id, donasi.jenis_donasi, donasi.jumlah_donasi, donatur.name AS nama_donatur
                                  FROM donasi
                                  JOIN donatur ON donasi.id_donatur = donatur.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function createDistribusi($tujuan, $tanggal_distribusi, $status, $id_donasi) {
        $stmt = $this->db->prepare("INSERT INTO distribusi (tujuan, tanggal_distribusi, status, id_donasi) VALUES (?, ?, ?, ?)");
        
        return $stmt->execute([$tujuan, $tanggal_distribusi, $status, $id_donasi]);
    }

    public function updateDistribusi($id, $tujuan, $tanggal_distribusi, $status, $id_donasi) {
        $stmt = $this->db->prepare("UPDATE distribusi SET tujuan = ?, tanggal_distribusi = ?, status = ?, id_donasi = ? WHERE id = ?");
        
        return $stmt->execute([$tujuan, $tanggal_distribusi, $status, $id_donasi]);
    }

    public function deleteDistribusi($id) {
        $stmt = $this->db->prepare("DELETE FROM distribusi WHERE id = ?");
        
        return $stmt->execute([$id]);
    }

    public function searchDistribusi($tujuan) {
        $stmt = $this->db->prepare("SELECT distribusi.*, donasi.jenis_donasi, donasi.jumlah_donasi, donatur.name AS nama_donatur
                                    FROM distribusi
                                    JOIN donasi ON distribusi.id_donasi = donasi.id
                                    JOIN donatur ON donasi.id_donatur = donatur.id
                                    WHERE distribusi.tujuan LIKE :tujuan");
        
        $tujuan = "%" . $tujuan . "%";

        $stmt->bindParam(':tujuan', $tujuan, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>