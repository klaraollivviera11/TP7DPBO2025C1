<?php
require_once 'class/Distribusi.php';
require_once 'class/Donasi.php';
require_once 'class/Donatur.php';

$distribusi = new Distribusi();
$donasi = new Donasi();
$donatur = new Donatur();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sistem Donasi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'view/header.php'; ?>
    <main>
        <h2>Welcome!^^</h2>
        <nav>
            <a href="?page=donatur">Donatur</a> |
            <a href="?page=donasi">Donasi</a> |
            <a href="?page=distribusi">Distribusi</a>
        </nav>

        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if ($page == 'donatur') include 'view/donatur.php';
            elseif ($page == 'donasi') include 'view/donasi.php';
            elseif ($page == 'distribusi') include 'view/distribusi.php';
        }
        ?>
    </main>
    <?php include 'view/footer.php'; ?>
</body>
</html>