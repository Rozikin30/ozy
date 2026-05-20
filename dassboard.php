<!-- dashboard.php -->
<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['login'])){
    header("Location: index.php");
    exit;
}

include "koneksi.php";

?>

<?php
/* TOTAL PRODUK */
$total_produk = mysqli_query($conn, "SELECT COUNT(*) as total FROM produk");
$produk = mysqli_fetch_assoc($total_produk);

/* TOTAL STOK */
$total_stok = mysqli_query($conn, "SELECT SUM(stok) as stok FROM produk");
$stok = mysqli_fetch_assoc($total_stok);

/* TOTAL NILAI */
$total_nilai = mysqli_query($conn, "SELECT SUM(stok * harga) as nilai FROM produk");
$nilai = mysqli_fetch_assoc($total_nilai);

/* DATA PRODUK */
$data_produk = mysqli_query($conn, "SELECT * FROM produk ORDER BY id_produk DESC");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard CheeseStock</title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
            color:white;
            position:fixed;
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

        .menu{
            margin-top:20px;
        }

        .menu a{
            display:flex;
            align-items:center;
            gap:15px;
            color:white;
            text-decoration:none;
            padding:15px;
            border-radius:12px;
            margin-bottom:10px;
            transition:0.3s;
        }

        .menu a:hover,
        .menu .active{
            background:#ffcc00;
            color:#000;
        }

        .bottom{
            position:absolute;
            bottom:30px;
            width:85%;
        }

        .logout{
            background:#0c2b68;
        }

        /* MAIN */
        .main{
            margin-left:270px;
            width:calc(100% - 270px);
            padding:30px;
        }

        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:20px;
        }

        .topbar h1{
            font-size:30px;
            color:#111827;
        }

        .search{
            background:white;
            padding:10px 10px;
            border-radius:20px;
            width:200px;
            display:flex;
            align-items:center;
            gap:10px;
        }

        .search input{
            border:none;
            outline:none;
            width:200%;
            font-size:16px;
        }

        /* CARD */
        .cards{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:10px;
            margin-bottom:20px;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:20px;
            display:flex;
            align-items:center;
            gap:20px;
            box-shadow:0 5px 10px rgba(0,0,0,0.05);
        }

        .card i{
            width:70px;
            height:70px;
            display:flex;
            justify-content:center;
            align-items:center;
            border-radius:15px;
            font-size:30px;
        }

        .yellow{
            background:#fff5d7;
            color:#ffcc00;
        }

        .green{
            background:#e8fff0;
            color:#22c55e;
        }

        .blue{
            background:#e8f3ff;
            color:#3b82f6;
        }

        .purple{
            background:#f5e8ff;
            color:#a855f7;
        }

        .card h2{
            font-size:25px;
        }

        /* TABLE */
        .table-box{
            background:white;
            padding:30px;
            border-radius:20px;
            box-shadow:0 5px 10px rgba(0,0,0,0.05);
        }

        .table-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:20px;
        }

        .table-header h2{
            color:#111827;
        }

        .btn{
            background:#ffcc00;
            color:white;
            border:none;
            padding:14px 20px;
            border-radius:12px;
            cursor:pointer;
            font-size:16px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table th{
            background:#f3f4f6;
            padding:15px;
            text-align:left;
        }

        table td{
            padding:18px 15px;
            border-bottom:1px solid #eee;
        }

        .badge{
            background:#dcfce7;
            color:#16a34a;
            padding:8px 15px;
            border-radius:30px;
            font-size:14px;
        }

        .aksi{
            display:flex;
            gap:10px;
        }

        .btn-edit{
    display:inline-flex;
    width:55px;
    height:55px;
    background:#ffcc00;
    color:white;
    justify-content:center;
    align-items:center;
    border-radius:14px;
    text-decoration:none;
    margin-right:10px;
    font-size:18px;
}

        .btn-delete{
    display:inline-flex;
    width:55px;
    height:55px;
    background:#ef4444;
    color:white;
    justify-content:center;
    align-items:center;
    border-radius:14px;
    text-decoration:none;
    font-size:18px;
}

        @media(max-width:1200px){

            .cards{
                grid-template-columns:repeat(2,1fr);
            }

        }

        @media(max-width:768px){

            .sidebar{
                display:none;
            }

            .main{
                margin-left:0;
                width:100%;
            }

            .cards{
                grid-template-columns:1fr;
            }

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

        <a href="dassboard.php" class="active">
            <i class="fa-solid fa-table-columns"></i>
            Dashboard
        </a>

        <a href="produk.php">
            <i class="fa-solid fa-cheese"></i>
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

    <!-- TOP -->
    <div class="topbar">

        <h1>Dashboard</h1>

        <div class="search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Cari produk keju...">
        </div>

    </div>

    <!-- CARD -->
    <div class="cards">

        <div class="card">
            <i class="fa-solid fa-cheese yellow"></i>

            <div>
                <p>Total Produk</p>
                <h2><?= $produk['total']; ?></h2>
            </div>
        </div>

        <div class="card">
            <i class="fa-solid fa-cube green"></i>

            <div>
                <p>Stok Tersedia</p>
                <h2><?= $stok['stok']; ?></h2>
            </div>
        </div>

        <div class="card">
            <i class="fa-solid fa-wallet blue"></i>

            <div>
                <p>Total Nilai Stok</p>
                <h2>
                    Rp <?= number_format($nilai['nilai']); ?>
                </h2>
            </div>
        </div>

        <div class="card">
            <i class="fa-solid fa-bag-shopping purple"></i>

            <div>
                <p>Produk Terjual</p>
                <h2>58</h2>
            </div>
        </div>

    </div>

    <!-- TABLE -->
    <div class="table-box">

        <div class="table-header">

            <h2>Daftar Produk Keju</h2>

         <a href="tambah_produk.php" class="btn">
                <i class="fa-solid fa-plus"></i>
                Tambah Produk
            </a>

        </div>

        <table>

            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jenis Keju</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Tanggal Masuk</th>
                <th>Aksi</th>
            </tr>

            <?php
            $no = 1;

            while($row = mysqli_fetch_assoc($data_produk)){
            ?>

            <tr>

                <td><?= $no++; ?></td>

                <td><?= $row['nama_produk']; ?></td>

                <td>
                    <span class="badge">
                        <?= $row['jenis_keju']; ?>
                    </span>
                </td>

                <td><?= $row['stok']; ?></td>

                <td>
                    Rp <?= number_format($row['harga']); ?>
                </td>

                <td><?= $row['tanggal_masuk']; ?></td>

                <td>

                    <div class="aksi">

                        <a href="edit_produk.php?id=<?= $row['id_produk']; ?>"
                            class="btn-edit">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <a href="hapus_produk.php?id=<?= $row['id_produk']; ?>"
                            class="btn-delete"
                                onclick="return confirm('Yakin ingin hapus produk ini?')">
                            <i class="fa-solid fa-trash"></i>
                        </a>

                    </div>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>