<?php
require_once 'Distribusi.php';
$distribusi = new Distribusi();

//Apabila user tidak mencari
if(isset($_GET['search_tujuan']) && !empty($_GET['search_tujuan'])){
    //tampilkan hasil
    $data_distribusi = $distribusi->searchDistribusi($_GET['search_tujuan']);
}else{
    //tampilkan semua data
    $data_distribusi = $distribusi->getAllDistribusi();
}

$tanggal = isset($_POST['tanggal_distribusi']) ? $_POST['tanggal_distribusi'] : null;
$tujuan = isset($_POST['tujuan']) ? $_POST['tujuan'] : null;
$status = isset($_POST['status']) ? $_POST['status'] : null;
$id_donasi = isset($_POST['id_donasi']) ? $_POST['id_donasi'] : null;

//delete request
if(isset($_GET['delete_id'])){
    $delete_id = $_GET['delete_id'];
    if($distribusi->deleteDistribusi($delete_id)){
        echo "<p>Distribusi berhasil dihapus!</p>";
        header("Location: distribusi.php");
        exit;
    }
}

//apabila id terisi
if(isset($_GET['id'])){
    $id = $_GET['id'];
    //ambil id data yang dipilih
    $distribusiData = $distribusi->getDistribusiById($id);

    //menampilkan list donasi
    $donasiList = $distribusi->getDonasiList();

    //proses update
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])){
        //update data
        if($distribusi->updateDistribusi($id, $tujuan, $tanggal, $status, $id_donasi)){
            echo "<p>Distribusi berhasil diupdate!</p>";
            header("Location: distribusi.php");
            exit;
        }
    }
}else{
    //kalau tidak ada id yang dipilih maka create data
    if(isset($_POST['add'])){
        //add data
        if ($distribusi->createDistribusi($tujuan, $tanggal, $status, $id_donasi)) {
            echo "<p>Distribusi berhasil ditambahkan!</p>";
        }
    }

    //menampilkan list donasi
    $donasiList = $distribusi->getDonasiList();
}

?>

<!-- form untuk add atau update -->
<h3><?= isset($_GET['id']) ? 'Edit Distribusi' : 'Tambah Distribusi Baru' ?></h3>

<form method="POST" action="">
    <!-- form untuk edit atau update -->
    <?php if (isset($distribusiData)): ?>
        <input type="hidden" name="id" value="<?= $distribusiData['id'] ?>">
    <?php endif; ?>

    <label for="tanggal_distribusi">Tanggal Distribusi:</label><br>
    <input type="date" name="tanggal_distribusi" value="<?= isset($distribusiData) ? $distribusiData['tanggal_distribusi'] : '' ?>" required><br><br>

    <label for="tujuan">Tujuan:</label><br>
    <input type="text" name="tujuan" value="<?= isset($distribusiData) ? $distribusiData['tujuan'] : '' ?>" required><br><br>

    <label for="status">Status:</label><br>
    <select name="status" required>
        <option value="proses" <?= isset($distribusiData) && $distribusiData['status'] == 'proses' ? 'selected' : '' ?>>Proses</option>
        <option value="selesai" <?= isset($distribusiData) && $distribusiData['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
    </select><br><br>

    <label for="id_donasi">Pilih Donasi:</label><br>
    <select name="id_donasi" required>
        <?php foreach ($donasiList as $donasi): ?>
            <option value="<?= $donasi['id'] ?>" <?= isset($distribusiData) && $distribusiData['id_donasi'] == $donasi['id'] ? 'selected' : '' ?>>
                <?= $donasi['jenis_donasi'] ?> - Rp <?= number_format($donasi['jumlah_donasi'], 0, ',', '.') ?> (<?= $donasi['nama_donatur'] ?>)
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit" name="<?= isset($distribusiData) ? 'update' : 'add' ?>">Simpan</button>
</form>

<br><hr><br>

<!-- searching -->
<div class="search-container">
    <h4>Search Distribusi</h4>
    <form method="GET" action="distribusi.php">
        <label for="search_tujuan">Search by Tujuan:</label>
        <input type="text" id="search_tujuan" name="search_tujuan" placeholder="Enter Tujuan" value="<?= isset($_GET['search_tujuan']) ? $_GET['search_tujuan'] : '' ?>">
        <button type="submit">Search</button>
    </form>
</div>

<!-- view data -->
<h3>List Distribusi</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Tujuan</th>
        <th>Tanggal Distribusi</th>
        <th>Status</th>
        <th>Jenis Donasi</th>
        <th>Jumlah Donasi</th>
        <th>Nama Donatur</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($data_distribusi as $d): ?>
    <tr>
        <td><?= $d['id'] ?></td>
        <td><?= $d['tujuan'] ?></td>
        <td><?= $d['tanggal_distribusi'] ?></td>
        <td><?= $d['status'] ?></td>
        <td><?= $d['jenis_donasi'] ?></td>
        <td>Rp <?= number_format($d['jumlah_donasi'], 0, ',', '.') ?></td>
        <td><?= $d['nama_donatur'] ?></td>
        <td class="actions">
            <a href="distribusi.php?id=<?= $d['id'] ?>" class="btn edit-btn">Edit</a>
            <a href="distribusi.php?delete_id=<?= $d['id'] ?>" onclick="if (!confirm('Yakin mau hapus data ini?')) return false;" class="btn delete-btn">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
