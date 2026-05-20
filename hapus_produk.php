<?php

include "koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($conn,
"DELETE FROM produk WHERE id_produk='$id'");

if($query){

    echo "
    <script>
        alert('Produk berhasil dihapus!');
        window.location='dassboard.php';
    </script>
    ";

}else{

    echo "
    <script>
        alert('Produk gagal dihapus!');
        window.location='dassboard.php';
        window.location='produk.php';
    </script>
    ";

}

?>