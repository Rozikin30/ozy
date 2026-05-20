<!-- produk.php -->
<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: index.php");
    exit;
}

include "koneksi.php";

/* SEARCH */
$cari = "";

if(isset($_GET['cari'])){
    $cari = $_GET['cari'];
}

/* QUERY */
$data = mysqli_query($conn,"
SELECT * FROM produk
WHERE nama_produk LIKE '%$cari%'
ORDER BY id_produk DESC
");

?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Produk Keju</title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#f5f6fa;
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:270px;
    height:100vh;
    background:#021b4b;
    position:fixed;
    color:white;
    padding:10px;
}

.logo{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:20px;
}

.logo i{
    font-size:45px;
    color:#ffcc00;
}

.logo h2{
    font-size:25px;
}

.logo span{
    color:#ffcc00;
}

.menu a{
    display:flex;
    align-items:center;
    gap:15px;
    padding:16px;
    text-decoration:none;
    color:white;
    border-radius:12px;
    margin-bottom:10px;
    transition:0.3s;
}

.menu a:hover{
    background:#ffcc00;
    color:#111827;
}

.menu .active{
    background:#ffcc00;
    color:#111827;
}

.bottom{
    position:absolute;
    bottom:30px;
    width:85%;
}

.logout{
    background:#0d2b68;
}

/* MAIN */
.main{
    margin-left:270px;
    width:calc(100% - 270px);
}

/* TOPBAR */
.topbar{
    background:white;
    padding:20px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid #eee;
}

.search-top{
    width:320px;
    height:55px;
    background:#f5f5f5;
    border-radius:12px;
    display:flex;
    align-items:center;
    padding:0 20px;
}

.search-top input{
    width:100%;
    border:none;
    outline:none;
    background:none;
}

/* CONTENT */
.content{
    padding:30px;
}

.breadcrumb{
    margin-bottom:25px;
    color:#6b7280;
}

/* CARD */
.card{
    background:white;
    border-radius:20px;
    padding:30px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.header h1{
    font-size:35px;
    margin-bottom:8px;
}

.header p{
    color:#6b7280;
}

.btn-tambah{
    background:#ffcc00;
    color:#111827;
    text-decoration:none;
    padding:15px 24px;
    border-radius:12px;
    font-weight:600;
}

/* FILTER */
.filter{
    display:flex;
    gap:15px;
    margin-bottom:25px;
}

.search-box{
    width:350px;
    height:55px;
    border:1px solid #ddd;
    border-radius:12px;
    display:flex;
    align-items:center;
    padding:0 15px;
}

.search-box input{
    width:100%;
    border:none;
    outline:none;
    background:none;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}

table thead{
    background:#f3f4f6;
}

table th{
    padding:18px;
    text-align:left;
}

table td{
    padding:20px 18px;
    border-bottom:1px solid #eee;
}

.badge{
    padding:8px 15px;
    border-radius:30px;
    font-size:14px;
    font-weight:500;
}

/* WARNA BADGE */
.cheddar{
    background:#dcfce7;
    color:#15803d;
}

.mozzarella{
    background:#dbeafe;
    color:#2563eb;
}

.parmesan{
    background:#f3e8ff;
    color:#9333ea;
}

.emmental{
    background:#fef3c7;
    color:#d97706;
}

.cream{
    background:#ccfbf1;
    color:#0f766e;
}

/* BUTTON */
.btn-edit,
.btn-hapus{
    width:45px;
    height:45px;
    border:none;
    border-radius:12px;
    cursor:pointer;
    color:white;
}

.btn-edit{
    background:#ffcc00;
    color:#111827;
}

.btn-hapus{
    background:#ef4444;
}

.aksi{
    display:flex;
    gap:10px;
}

.pagination{
    margin-top:30px;
    display:flex;
    justify-content:center;
    gap:10px;
}

.page{
    width:45px;
    height:45px;
    border-radius:10px;
    border:1px solid #ddd;
    display:flex;
    justify-content:center;
    align-items:center;
}

.page.active{
    background:#ffcc00;
    border:none;
}

</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">

        <i class="fa-solid fa-cheese"></i>

        <div>
            <h2>Cheese<span>Stock</span></h2>
            <small>Sistem Data Produk Keju</small>
        </div>

    </div>

    <div class="menu">

        <a href="dassboard.php">
            <i class="fa-solid fa-table-columns"></i>
            Dashboard
        </a>

        <a href="produk.php" class="active">
            <i class="fa-solid fa-box"></i>
            Produk Keju
        </a>

        <a href="tambah_produk.php">
            <i class="fa-solid fa-circle-plus"></i>
            Tambah Produk
        </a>

        <a href="kategori.php">
            <i class="fa-solid fa-layer-group"></i>
            Kategori
        </a>

        <a href="transaksi.php">
            <i class="fa-solid fa-cart-shopping"></i>
            Transaksi
        </a>

        <a href="#">
            <i class="fa-solid fa-chart-column"></i>
            Laporan
        </a>

        <a href="#">
            <i class="fa-solid fa-gear"></i>
            Pengaturan
        </a>

    </div>

    <div class="bottom">

        <div class="menu">

            <a href="logout.php" class="logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </a>

        </div>

    </div>

</div>

<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">

        <h2>Dashboard</h2>

        <div class="search-top">

            <input type="text" placeholder="Cari produk keju...">

            <i class="fa-solid fa-magnifying-glass"></i>

        </div>

    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="breadcrumb">
            Dashboard >
            Produk Keju
        </div>

        <div class="card">

            <div class="header">

                <div>

                    <h1>Produk Keju</h1>

                    <p>
                        Kelola semua data produk keju yang tersedia.
                    </p>

                </div>

                <a href="tambah_produk.php" class="btn-tambah">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Produk
                </a>

            </div>

            <!-- SEARCH -->
            <form method="GET">

                <div class="filter">

                    <div class="search-box">

                        <input
                            type="text"
                            name="cari"
                            placeholder="Cari nama produk..."
                            value="<?= $cari; ?>"
                        >

                        <i class="fa-solid fa-magnifying-glass"></i>

                    </div>

                </div>

            </form>

            <!-- TABLE -->
            <table>

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Jenis Keju</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Tanggal Masuk</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                while($row = mysqli_fetch_assoc($data)){

                    $class = "";

                    if($row['jenis_keju']=="Cheddar"){
                        $class = "cheddar";
                    }

                    elseif($row['jenis_keju']=="Mozzarella"){
                        $class = "mozzarella";
                    }

                    elseif($row['jenis_keju']=="Parmesan"){
                        $class = "parmesan";
                    }

                    elseif($row['jenis_keju']=="Emmental"){
                        $class = "emmental";
                    }

                    else{
                        $class = "cream";
                    }

                ?>

                    <tr>

                        <td><?= $no++; ?></td>

                        <td><?= $row['nama_produk']; ?></td>

                        <td>
                            <span class="badge <?= $class; ?>">
                                <?= $row['jenis_keju']; ?>
                            </span>
                        </td>

                        <td><?= $row['stok']; ?> kg</td>

                        <td>
                            Rp <?= number_format($row['harga']); ?> /kg
                        </td>

                        <td><?= $row['tanggal_masuk']; ?></td>

                        <td>

                            <div class="aksi">

                                <a href="edit_produk.php?id=<?= $row['id_produk']; ?>">

                                    <button
                                    type="button"
                                    class="btn-edit">

                                        <i class="fa-solid fa-pen"></i>

                                    </button>

                                </a>

                                <a
                                href="hapus_produk.php?id=<?= $row['id_produk']; ?>"
                                onclick="return confirm('Yakin ingin hapus produk?')">

                                    <button
                                    type="button"
                                    class="btn-hapus">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </a>

                            </div>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

            <!-- PAGINATION -->
            <div class="pagination">

                <div class="page">
                    <i class="fa-solid fa-angle-left"></i>
                </div>

                <div class="page active">1</div>
                <div class="page">2</div>
                <div class="page">3</div>

                <div class="page">
                    <i class="fa-solid fa-angle-right"></i>
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>