<!-- transaksi.php -->
<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

include "koneksi.php";

/* TAMBAH TRANSAKSI */
if (isset($_POST['simpan'])) {

    $produk         = htmlspecialchars($_POST['produk']);
    $nama_pembeli   = htmlspecialchars($_POST['nama_pembeli']);
    $jumlah_beli    = (int) $_POST['jumlah_beli'];
    $tanggal        = $_POST['tanggal'];

    // Ambil data produk
    $ambil = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$produk'");
    $dataProduk = mysqli_fetch_assoc($ambil);

    $nama_produk = $dataProduk['nama_produk'];
    $harga       = $dataProduk['harga'];
    $stok        = $dataProduk['stok'];

    // Validasi stok
    if ($jumlah_beli > $stok) {

        echo "
        <script>
            alert('Stok produk tidak mencukupi!');
        </script>
        ";

    } else {

        $total = $harga * $jumlah_beli;

        // Simpan transaksi
        $stmt = mysqli_prepare($conn, "INSERT INTO transaksi
        (nama_produk, nama_pembeli, jumlah_beli, total_harga, tanggal)
        VALUES (?, ?, ?, ?, ?)");

        mysqli_stmt_bind_param(
            $stmt,
            "ssiis",
            $nama_produk,
            $nama_pembeli,
            $jumlah_beli,
            $total,
            $tanggal
        );

        $query = mysqli_stmt_execute($stmt);

        // Update stok produk
        $sisa_stok = $stok - $jumlah_beli;

        mysqli_query($conn, "UPDATE produk 
        SET stok='$sisa_stok'
        WHERE id_produk='$produk'");

        if ($query) {

            echo "
            <script>
                alert('Transaksi berhasil!');
                window.location='transaksi.php';
            </script>
            ";

        } else {

            echo "
            <script>
                alert('Transaksi gagal!');
            </script>
            ";

        }

    }
}

/* HAPUS TRANSAKSI */
if (isset($_GET['hapus'])) {

    $id = (int) $_GET['hapus'];

    mysqli_query($conn, "DELETE FROM transaksi WHERE id_transaksi='$id'");

    echo "
    <script>
        alert('Transaksi berhasil dihapus!');
        window.location='transaksi.php';
    </script>
    ";
}

/* TAMPIL PRODUK */
$produk = mysqli_query($conn, "SELECT * FROM produk ORDER BY nama_produk ASC");

/* TAMPIL TRANSAKSI */
$transaksi = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY id_transaksi DESC");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Produk</title>

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

        .wrapper{
            display:grid;
            grid-template-columns:1fr 1.7fr;
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
        .input-group select{
            width:100%;
            height:55px;
            border:1px solid #ddd;
            border-radius:12px;
            padding:15px;
            outline:none;
            font-size:15px;
        }

        .btn{
            width:100%;
            height:55px;
            border:none;
            border-radius:12px;
            background:#ffcc00;
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

        .badge{
            background:#ecfdf5;
            color:#059669;
            padding:5px 12px;
            border-radius:20px;
            font-size:13px;
            font-weight:600;
        }

        .hapus{
            background:#ef4444;
            color:white;
            padding:8px 14px;
            text-decoration:none;
            border-radius:8px;
            font-size:14px;
        }

        .harga{
            color:#2563eb;
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

        <a href="dashboard.php">
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

        <a href="transaksi.php" class="active">
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

        <h2>Transaksi Produk</h2>

    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="card">

            <h1 style="margin-bottom:10px;">
                Data Transaksi
            </h1>

            <p style="margin-bottom:30px;color:#6b7280;">
                Kelola transaksi penjualan produk keju.
            </p>

            <div class="wrapper">

                <!-- FORM -->
                <div>

                    <form method="POST">

                        <div class="input-group">

                            <label>Pilih Produk</label>

                            <select name="produk" required>

                                <option value="">
                                    -- Pilih Produk --
                                </option>

                                <?php while($p = mysqli_fetch_assoc($produk)){ ?>

                                    <option value="<?= $p['id_produk']; ?>">

                                        <?= $p['nama_produk']; ?>
                                        -
                                        Stok: <?= $p['stok']; ?> kg

                                    </option>

                                <?php } ?>

                            </select>

                        </div>

                        <div class="input-group">

                            <label>Nama Pembeli</label>

                            <input
                                type="text"
                                name="nama_pembeli"
                                placeholder="Masukkan nama pembeli"
                                required
                            >

                        </div>

                        <div class="input-group">

                            <label>Jumlah Beli</label>

                            <input
                                type="number"
                                name="jumlah_beli"
                                min="1"
                                placeholder="Masukkan jumlah beli"
                                required
                            >

                        </div>

                        <div class="input-group">

                            <label>Tanggal Transaksi</label>

                            <input
                                type="date"
                                name="tanggal"
                                required
                            >

                        </div>

                        <button
                            type="submit"
                            name="simpan"
                            class="btn"
                        >
                            💾 Simpan Transaksi
                        </button>

                    </form>

                </div>

                <!-- TABLE -->
                <div>

                    <table>

                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Pembeli</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>

                        <?php
                        $no = 1;

                        while($t = mysqli_fetch_assoc($transaksi)){
                        ?>

                        <tr>

                            <td><?= $no++; ?></td>

                            <td>

                                <span class="badge">
                                    <?= $t['nama_produk']; ?>
                                </span>

                            </td>

                            <td><?= $t['nama_pembeli']; ?></td>

                            <td><?= $t['jumlah_beli']; ?> kg</td>

                            <td class="harga">
                                Rp <?= number_format($t['total_harga']); ?>
                            </td>

                            <td><?= $t['tanggal']; ?></td>

                            <td>

                                <a
                                    href="?hapus=<?= $t['id_transaksi']; ?>"
                                    class="hapus"
                                    onclick="return confirm('Yakin hapus transaksi?')"
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