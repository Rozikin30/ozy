<!-- kategori.php -->
<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

include "koneksi.php";

/* TAMBAH KATEGORI */
if (isset($_POST['simpan'])) {

    $nama_kategori = htmlspecialchars($_POST['nama_kategori']);
    $deskripsi     = htmlspecialchars($_POST['deskripsi']);

    $stmt = mysqli_prepare($conn, "INSERT INTO kategori 
    (nama_kategori, deskripsi)
    VALUES (?, ?)");

    mysqli_stmt_bind_param(
        $stmt,
        "ss",
        $nama_kategori,
        $deskripsi
    );

    $query = mysqli_stmt_execute($stmt);

    if ($query) {

        echo "
        <script>
            alert('Kategori berhasil ditambahkan!');
            window.location='kategori.php';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Kategori gagal ditambahkan!');
        </script>
        ";

    }
}

/* HAPUS KATEGORI */
if (isset($_GET['hapus'])) {

    $id = (int) $_GET['hapus'];

    mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori='$id'");

    echo "
    <script>
        alert('Kategori berhasil dihapus!');
        window.location='kategori.php';
    </script>
    ";
}

/* TAMPIL DATA */
$data = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori DESC");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Produk</title>

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

        .content{
            padding:35px;
        }

        .card{
            background:white;
            border-radius:20px;
            padding:35px;
            box-shadow:0 5px 15px rgba(0,0,0,0.05);
        }

        .title{
            margin-bottom:30px;
        }

        .wrapper{
            display:grid;
            grid-template-columns:1fr 1.5fr;
            gap:30px;
        }

        /* FORM */
        .input-group{
            margin-bottom:20px;
        }

        .input-group label{
            display:block;
            margin-bottom:8px;
            font-weight:600;
        }

        .input-group input,
        .input-group textarea{
            width:100%;
            padding:15px;
            border:1px solid #ddd;
            border-radius:12px;
            outline:none;
            font-size:15px;
        }

        textarea{
            resize:none;
            height:120px;
        }

        .btn{
            width:100%;
            height:55px;
            border:none;
            background:#ffcc00;
            border-radius:12px;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
        }

        /* TABLE */
        table{
            width:100%;
            border-collapse:collapse;
        }

        table th{
            background:#021b4b;
            color:white;
            padding:15px;
            text-align:left;
        }

        table td{
            padding:15px;
            border-bottom:1px solid #eee;
        }

        .hapus{
            padding:8px 14px;
            background:#ef4444;
            color:white;
            text-decoration:none;
            border-radius:8px;
            font-size:14px;
        }

        .badge{
            background:#fff8db;
            color:#b58900;
            padding:5px 12px;
            border-radius:20px;
            font-size:13px;
            font-weight:600;
        }

        @media(max-width:1000px){

            .wrapper{
                grid-template-columns:1fr;
            }

            .sidebar{
                display:none;
            }

            .main{
                margin-left:0;
                width:100%;
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

        <a href="tambah_produk.php">
            <i class="fa-solid fa-circle-plus"></i>
            Tambah Produk
        </a>

        <a href="kategori.php" class="active">
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

        <h2>Kategori Produk</h2>

    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="card">

            <div class="title">
                <h1>Data Kategori</h1>
                <p>Kelola kategori produk keju.</p>
            </div>

            <div class="wrapper">

                <!-- FORM -->
                <div>

                    <form method="POST">

                        <div class="input-group">

                            <label>Nama Kategori</label>

                            <input
                                type="text"
                                name="nama_kategori"
                                placeholder="Masukkan nama kategori"
                                required
                            >

                        </div>

                        <div class="input-group">

                            <label>Deskripsi</label>

                            <textarea
                                name="deskripsi"
                                placeholder="Masukkan deskripsi kategori"
                            ></textarea>

                        </div>

                        <button
                            type="submit"
                            name="simpan"
                            class="btn"
                        >
                            💾 Simpan Kategori
                        </button>

                    </form>

                </div>

                <!-- TABLE -->
                <div>

                    <table>

                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>

                        <?php
                        $no = 1;

                        while($row = mysqli_fetch_assoc($data)){
                        ?>

                        <tr>

                            <td><?= $no++; ?></td>

                            <td>
                                <span class="badge">
                                    <?= $row['nama_kategori']; ?>
                                </span>
                            </td>

                            <td><?= $row['deskripsi']; ?></td>

                            <td>

                                <a
                                    href="?hapus=<?= $row['id_kategori']; ?>"
                                    class="hapus"
                                    onclick="return confirm('Yakin hapus kategori?')"
                                >
                                    Hapus
                                </a>

                            </td>

                        </tr>

                        <?php } ?>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>