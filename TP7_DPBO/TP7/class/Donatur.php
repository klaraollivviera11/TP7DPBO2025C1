<?php
require_once 'config/db.php';

class donatur {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAllDonatur() {
        $stmt = $this->db->query("SELECT * FROM donatur");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createDonatur($name, $email, $nomor_telepon) {
        $stmt = $this->db->prepare("INSERT INTO donatur (name, email, nomor_telepon) VALUES (?, ?, ?)");
        
        return $stmt->execute([$name, $email, $nomor_telepon]);
    }

    public function updateDonatur($name, $email, $nomor_telepon) {
        $stmt = $this->db->prepare("UPDATE donatur SET name = ?, email = ?, nomor_telepon = ? WHERE id = ?");
        
        return $stmt->execute([$name, $email, $nomor_telepon]);
    }

    public function deleteDonatur($id) {
        $stmt = $this->db->prepare("DELETE FROM donatur WHERE id = ?");
        
        return $stmt->execute([$id]);
    }

    public function searchDonatur($name) {
        $stmt = $this->db->prepare("SELECT donatur.*
                                    FROM donatur
                                    WHERE donatur.name LIKE :name");
        
        $name = "%" . $name . "%";

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>