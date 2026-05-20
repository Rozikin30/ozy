<!-- tambah_produk.php -->
<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: index.php");
    exit;
}

include "koneksi.php";

/* SIMPAN PRODUK */
if(isset($_POST['simpan'])){

    $nama_produk   = $_POST['nama_produk'];
    $jenis_keju    = $_POST['jenis_keju'];
    $stok          = $_POST['stok'];
    $harga         = $_POST['harga'];
    $tanggal_masuk = $_POST['tanggal_masuk'];

    $query = mysqli_query($conn,"INSERT INTO produk
    (nama_produk, jenis_keju, stok, harga, tanggal_masuk)

    VALUES

    ('$nama_produk',
     '$jenis_keju',
     '$stok',
     '$harga',
     '$tanggal_masuk')
    ");

    if($query){

        echo "
        <script>
            alert('Produk berhasil ditambahkan!');
            window.location='dassboard.php';
        </script>
        ";

    }else{

        echo "
        <script>
            alert('Produk gagal ditambahkan!');
        </script>
        ";

    }

}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>

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
            position:fixed;
            color:white;
            padding:10px;
        }

        .logo{
            display:flex;
            gap:10px;
            align-items:center;
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
            text-decoration:none;
            color:white;
            padding:16px;
            border-radius:14px;
            margin-bottom:10px;
            transition:0.3s;
        }

        .menu a:hover,
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
            background:#0c2b68;
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

        .topbar h2{
            color:#111827;
        }

        .search{
            background:#f5f5f5;
            padding:12px 20px;
            border-radius:12px;
            width:320px;
            display:flex;
            align-items:center;
            gap:10px;
        }

        .search input{
            border:none;
            outline:none;
            background:none;
            width:100%;
        }

        /* CONTENT */
        .content{
            padding:35px;
        }

        .breadcrumb{
            margin-bottom:30px;
            color:#6b7280;
        }

        .breadcrumb span{
            color:#ffcc00;
        }

        /* CARD */
        .card{
            background:white;
            border-radius:20px;
            padding:35px;
            box-shadow:0 5px 15px rgba(0,0,0,0.05);
        }

        .card h1{
            margin-bottom:10px;
            color:#111827;
        }

        .card p{
            color:#6b7280;
            margin-bottom:35px;
        }

        .wrapper{
            display:grid;
            grid-template-columns:2fr 1fr;
            gap:40px;
        }

        /* FORM */
        .input-group{
            margin-bottom:25px;
        }

        .input-group label{
            display:block;
            margin-bottom:10px;
            font-weight:600;
            color:#111827;
        }

        .input-group input,
        .input-group select{
            width:100%;
            height:58px;
            border:1px solid #ddd;
            border-radius:12px;
            padding:15px;
            font-size:16px;
            outline:none;
        }

        .flex{
            display:flex;
        }

        .addon{
            width:60px;
            background:#f3f4f6;
            border:1px solid #ddd;
            display:flex;
            justify-content:center;
            align-items:center;
            border-radius:12px 0 0 12px;
            font-weight:600;
        }

        .addon-right{
            width:60px;
            background:#f3f4f6;
            border:1px solid #ddd;
            display:flex;
            justify-content:center;
            align-items:center;
            border-radius:0 12px 12px 0;
            font-weight:600;
        }

        .flex input{
            border-radius:0;
        }

        .btn-group{
            display:flex;
            gap:20px;
            margin-top:35px;
        }

        .btn-back{
            flex:1;
            height:60px;
            border:none;
            border-radius:12px;
            background:#e5e7eb;
            cursor:pointer;
            font-size:16px;
            font-weight:600;
        }

        .btn-save{
            flex:1;
            height:60px;
            border:none;
            border-radius:12px;
            background:#ffcc00;
            cursor:pointer;
            font-size:16px;
            font-weight:600;
            color:#111827;
        }

        /* INFO */
        .info{
            border:1px solid #eee;
            border-radius:18px;
            padding:30px;
            height:fit-content;
        }

        .info-top{
            display:flex;
            gap:15px;
            margin-bottom:25px;
        }

        .info-top i{
            width:45px;
            height:45px;
            background:#e8f1ff;
            color:#2563eb;
            display:flex;
            justify-content:center;
            align-items:center;
            border-radius:50%;
        }

        .check{
            display:flex;
            gap:15px;
            margin-bottom:20px;
            align-items:center;
        }

        .check i{
            color:#22c55e;
            font-size:20px;
        }

        @media(max-width:1000px){

            .wrapper{
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

        <a href="dassboard.php">
            <i class="fa-solid fa-table-columns"></i>
            Dashboard
        </a>

        <a href="produk.php">
            <i class="fa-solid fa-cheese"></i>
            Produk Keju
        </a>

        <a href="tambah_produk.php" class="active">
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

        <div class="search">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input type="text" placeholder="Cari produk keju...">

        </div>

    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="breadcrumb">
            Dashboard >
            Produk Keju >
            <span>Tambah Produk</span>
        </div>

        <div class="card">

            <h1>Tambah Produk Keju</h1>

            <p>
                Lengkapi informasi produk keju pada form di bawah ini.
            </p>

            <div class="wrapper">

                <!-- FORM -->
                <div>

                    <form method="POST">

                        <div class="input-group">

                            <label>Nama Produk</label>

                            <input
                                type="text"
                                name="nama_produk"
                                placeholder="Masukkan nama produk keju"
                                required
                            >

                        </div>

                        <div class="input-group">

                            <label>Jenis Keju</label>

                            <select name="jenis_keju" required>

                                <option value="">
                                    Pilih jenis keju
                                </option>

                                <option>Cheddar</option>
                                <option>Mozzarella</option>
                                <option>Parmesan</option>
                                <option>Emmental</option>
                                <option>Cream Cheese</option>

                            </select>

                        </div>

                        <div class="input-group">

                            <label>Stok</label>

                            <div class="flex">

                                <input
                                    type="number"
                                    name="stok"
                                    placeholder="Masukkan jumlah stok"
                                    required
                                >

                                <div class="addon-right">
                                    kg
                                </div>

                            </div>

                        </div>

                        <div class="input-group">

                            <label>Harga</label>

                            <div class="flex">

                                <div class="addon">
                                    Rp
                                </div>

                                <input
                                    type="number"
                                    name="harga"
                                    placeholder="Masukkan harga produk"
                                    required
                                >

                                <div class="addon-right">
                                    /kg
                                </div>

                            </div>

                        </div>

                        <div class="input-group">

                            <label>Tanggal Masuk</label>

                            <input
                                type="date"
                                name="tanggal_masuk"
                                required
                            >

                        </div>

                        <div class="btn-group">

                            <button
                                type="button"
                                class="btn-back"
                                onclick="window.location='dassboard.php'"
                            >
                                ← Kembali
                            </button>

                            <button
                                type="submit"
                                name="simpan"
                                class="btn-save"
                            >
                                💾 Simpan Produk
                            </button>

                        </div>

                    </form>

                </div>

                <!-- INFO -->
                <div class="info">

                    <div class="info-top">

                        <i class="fa-solid fa-circle-info"></i>

                        <div>

                            <h3>Informasi</h3>

                            <br>

                            <p>
                                Pastikan semua data sudah diisi
                                dengan benar sebelum menyimpan produk.
                            </p>

                        </div>

                    </div>

                    <div class="check">
                        <i class="fa-regular fa-circle-check"></i>
                        Nama produk harus diisi
                    </div>

                    <div class="check">
                        <i class="fa-regular fa-circle-check"></i>
                        Jenis keju harus dipilih
                    </div>

                    <div class="check">
                        <i class="fa-regular fa-circle-check"></i>
                        Stok harus lebih dari 0
                    </div>

                    <div class="check">
                        <i class="fa-regular fa-circle-check"></i>
                        Harga harus lebih dari 0
                    </div>

                    <div class="check">
                        <i class="fa-regular fa-circle-check"></i>
                        Tanggal masuk harus dipilih
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>