<?php

    session_start();
    if( !isset($_SESSION["login"]) ) {
        header("Location: login.php");
        exit;
    }

    require 'functions.php';

    // pagination

    // konfigurasi
    $jumlahDataPerHalaman = 4;
    $jumlahData = count(query("SELECT * FROM mahasiswa"));
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

    // if( isset($_GET["halaman"]) ) {
    //     $halamanAktif = $_GET("halaman");
    // }else {
    //     $halamanAktif = 1;
    // }

    $halamanAktif = ( isset($_GET["halaman"])) ? $_GET["halaman"]: 1;
    
    $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

    $mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerHalaman");



    

    // $mahasiswa = query("SELECT * FROM mahasiswa ORDER BY id ASC");
    // $mahasiswa = query("SELECT * FROM mahasiswa ORDER BY id DESC");

    // tombol cari diklick
    if( isset($_POST["cari"]) ) {
        $mahasiswa = cari($_POST["keyword"]);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
</head>
<body>

    <a href="logout.php">Logout</a>
    <h1>Daftar Mahasiswa</h1>

    <a href="tambah.php">Tambah data mahasiswa</a>
    <br><br>
    
    <form action="" method="post">

        <input type="text" name="keyword" size="40" autofocus placeholder="Masukan keyword pencarian" autocomplete="off">
        <button type="submit" name="cari">Cari!</button>

    </form>
    <br>

    <!-- Navigasi -->

    <?php if($halamanAktif > 1 ) : ?>
        <a href="?halaman=<?= $halamanAktif - 1 ?>">&laquo;</a>
    <?php endif; ?>

    <?php for($i = 1; $i<= $jumlahHalaman; $i++) : ?>
        <?php if( $i == $halamanAktif ) :?>
            <a href="?halaman=<?=  $i; ?>" style="font-weight:bold; color: red;"><?= $i; ?></a>
        <?php else : ?>
            <a href="?halaman=<?=  $i; ?>"><?= $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    
    <?php if($halamanAktif < $jumlahHalaman ) : ?>
        <a href="?halaman=<?= $halamanAktif + 1 ?>">&raquo;</a>
    <?php endif; ?>
    <br>
    
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>NRP</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
        </tr>

        <?php
            $i = 1;
            foreach( $mahasiswa as $row ) : ?>
        <tr>
            <td><?= $i; ?></td>
            <td>
                <a href="ubah.php?id=<?= $row["id"]; ?>">Ubah</a>
                <a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?');">Hapus</a>
            </td>
            <td><img src="img/<?= $row["gambar"]; ?>" width="70"></td>
            <td><?= $row["nrp"]; ?></td>
            <td><?= $row["nama"];?></td>
            <td><?= $row["email"];?></td>
            <td><?= $row["jurusan"];?></td>
        </tr>
        <?php
            $i++;
            endforeach;
        ?>
    </table>
    
</body>
</html>