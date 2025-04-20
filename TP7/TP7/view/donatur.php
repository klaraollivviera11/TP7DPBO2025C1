<?php
require_once 'Donatur.php';
$donatur = new Donatur();

$data_donatur = $donatur->getAllDonatur();

$name = isset($_POST['name']) ? $_POST['name'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$nomor_telepon = isset($_POST['nomor_telepon']) ? $_POST['nomor_telepon'] : null;

//delete
if(isset($_GET['delete_id'])){
    $delete_id = $_GET['delete_id'];
    if($donatur->deleteDonatur($delete_id)){
        echo "<p>Donatur berhasil dihapus!</p>";
        header("Location: donatur.php");
        exit;
    }
}

//apabila id terisi
if(isset($_GET['id'])){
    //ambil id data yang dipilih
    $id = $_GET['id'];

    //menampilkan list donasi
    $donaturData = $donatur->getDonaturById($id);

    //proses update
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])){
        //update data
        if($donatur->updateDonatur($id, $name, $email, $nomor_telepon)){
            echo "<p>Donatur berhasil diupdate!</p>";
            header("Location: donatur.php");
            exit;
        }
    }
}else{
    //kalau tidak ada id yang dipilih maka create data
    if(isset($_POST['add'])){
        //add data
        if($donatur->createDonatur($name, $email, $nomor_telepon)){
            echo "<p>Donatur berhasil ditambahkan!</p>";
        }
    }
}

//search
if(isset($_GET['search_name'])){
    $data_donatur = $donatur->searchDonatur($_GET['search_name']);
}
?>

<!-- form untuk add atau update -->
<h3><?= isset($_GET['id']) ? 'Edit Donatur' : 'Tambah Donatur Baru' ?></h3>

<form method="POST" action="">
    <!-- form untuk edit atau update -->
    <?php if (isset($donaturData)): ?>
        <input type="hidden" name="id" value="<?= $donaturData['id'] ?>">
    <?php endif; ?>

    <label for="name">Nama:</label><br>
    <input type="text" name="name" value="<?= isset($donaturData) ? $donaturData['name'] : '' ?>" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" name="email" value="<?= isset($donaturData) ? $donaturData['email'] : '' ?>" required><br><br>

    <label for="nomor_telepon">No. Telp:</label><br>
    <input type="text" name="nomor_telepon" value="<?= isset($donaturData) ? $donaturData['nomor_telepon'] : '' ?>" required><br><br>

    <button type="submit" name="<?= isset($donaturData) ? 'update' : 'add' ?>">Simpan</button>
</form>

<br><hr><br>

<!-- searching -->
<div class="search-container">
    <h4>Search Donatur</h4>
    <form method="GET" action="donatur.php">
        <label for="search_name">Search by Name:</label>
        <input type="text" id="search_name" name="search_name" placeholder="Enter Donatur Name" value="<?= isset($_GET['search_name']) ? $_GET['search_name'] : '' ?>">
        <button type="submit">Search</button>
    </form>
</div>

<!-- view data -->
<h3>List Donatur</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Email</th>
        <th>No. Telp</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($data_donatur as $d): ?>
    <tr>
        <td><?= $d['id'] ?></td>
        <td><?= $d['name'] ?></td>
        <td><?= $d['email'] ?></td>
        <td><?= $d['nomor_telepon'] ?></td>
        <td class="actions">
            <a href="donatur.php?id=<?= $d['id'] ?>" class="btn edit-btn">Edit</a>
            <a href="donatur.php?delete_id=<?= $d['id'] ?>" onclick="if (!confirm('Yakin mau hapus data ini?')) return false;" class="btn delete-btn">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
