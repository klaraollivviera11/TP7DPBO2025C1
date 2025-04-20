<?php
require_once 'Donasi.php';
$donasi = new Donasi();

$data_donasi = $donasi->getAllDonasi();

$jumlah_donasi = isset($_POST['jumlah_donasi']) ? $_POST['jumlah_donasi'] : null;
$tanggal_donasi = isset($_POST['tanggal_donasi']) ? $_POST['tanggal_donasi'] : null;
$jenis_donasi = isset($_POST['jenis_donasi']) ? $_POST['jenis_donasi'] : null;
$id_donatur = isset($_POST['id_donatur']) ? $_POST['id_donatur'] : null;

// delete
if(isset($_GET['delete_id'])){
    $delete_id = $_GET['delete_id'];
    if($donasi->deleteDonasi($delete_id)){
        echo "<p>Donasi berhasil dihapus!</p>";
        header("Location: donasi.php");
        exit;
    }
}

//apabila id terisi
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    //ambil id data yang dipilih
    $donasiData = $donasi->getDonasiById($id);

    //menampilkan list donasi
    $donaturList = $donasi->getDonaturList();

    //proses update
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])){
        //update data
        if($donasi->updateDonasi($id, $jumlah_donasi, $tanggal_donasi, $jenis_donasi, $id_donatur)){
            echo "<p>Donasi berhasil diupdate!</p>";
            header("Location: donasi.php");
            exit;
        }
    }
}else{
    //kalau tidak ada id yang dipilih maka create data
    if(isset($_POST['add'])){
        //add data
        if ($donasi->createDonasi($jumlah_donasi, $tanggal_donasi, $jenis_donasi, $id_donatur)) {
            echo "<p>Donasi berhasil ditambahkan!</p>";
        }
    }

    //menampilkan list donasi
    $donaturList = $donasi->getDonaturList();
}

//search
if (isset($_GET['search_name'])) {
    $data_donasi = $donasi->searchDonasi($_GET['search_name']);
}

?>

<!-- form untuk add atau update -->
<h3><?= isset($_GET['id']) ? 'Edit Donasi' : 'Tambah Donasi Baru' ?></h3>

<form method="POST" action="">
    <!-- form untuk edit atau updat -->
    <?php if (isset($donasiData)): ?>
        <input type="hidden" name="id" value="<?= $donasiData['id'] ?>">
    <?php endif; ?>

    <label for="jumlah_donasi">Jumlah Donasi:</label><br>
    <input type="number" name="jumlah_donasi" value="<?= isset($donasiData) ? $donasiData['jumlah_donasi'] : '' ?>" required><br><br>

    <label for="tanggal_donasi">Tanggal Donasi:</label><br>
    <input type="date" name="tanggal_donasi" value="<?= isset($donasiData) ? $donasiData['tanggal_donasi'] : '' ?>" required><br><br>

    <label for="jenis_donasi">Jenis Donasi:</label><br>
    <select name="jenis_donasi" required>
        <option value="uang" <?= isset($donasiData) && $donasiData['jenis_donasi'] == 'uang' ? 'selected' : '' ?>>Uang</option>
        <option value="barang" <?= isset($donasiData) && $donasiData['jenis_donasi'] == 'barang' ? 'selected' : '' ?>>Barang</option>
    </select><br><br>

    <label for="id_donatur">Nama Donatur:</label><br>
    <select name="id_donatur" required>
        <?php foreach ($donaturList as $donatur): ?>
            <option value="<?= $donatur['id'] ?>" <?= isset($donasiData) && $donasiData['id_donatur'] == $donatur['id'] ? 'selected' : '' ?>><?= $donatur['name'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit" name="<?= isset($donasiData) ? 'update' : 'add' ?>">Simpan</button>
</form>

<br><hr><br>

<!-- searching -->
<div class="search-container">
    <h4>Search Donasi</h4>
    <form method="GET" action="donasi.php">
        <label for="search_name">Search by Donatur Name:</label>
        <input type="text" id="search_name" name="search_name" placeholder="Enter Donatur Name" value="<?= isset($_GET['search_name']) ? $_GET['search_name'] : '' ?>">
        <button type="submit">Search</button>
    </form>
</div>

<!-- view data -->
<h3>List Donasi</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Jumlah Donasi</th>
        <th>Tanggal Donasi</th>
        <th>Jenis Donasi</th>
        <th>Nama Donatur</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($data_donasi as $d): ?>
    <tr>
        <td><?= $d['id'] ?></td>
        <td>Rp <?= number_format($d['jumlah_donasi'], 0, ',', '.') ?></td>
        <td><?= $d['tanggal_donasi'] ?></td>
        <td><?= $d['jenis_donasi'] ?></td>
        <td><?= $d['nama_donatur'] ?></td>
        <td class="actions">
            <a href="donasi.php?id=<?= $d['id'] ?>" class="btn edit-btn">Edit</a>
            <a href="donasi.php?delete_id=<?= $d['id'] ?>" onclick="if (!confirm('Yakin mau hapus data ini?')) return false;" class="btn delete-btn">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
