<?php 
require "koneksi.php";

$nama = htmlspecialchars($_GET['nama']);
$queryProduct = mysqli_query($con, "SELECT * FROM produk WHERE nama='$nama'");
$produk = mysqli_fetch_array($queryProduct);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WOPIFARM || detail produk</title>

    <!-- style webnya -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php";?>

    <!-- detail produk -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-3">
                    <img src="image/<?php echo $produk['foto'];?>" class="w-100" alt="">    
                </div>
                <div class="col-md-6 offset-lg-1">
                    <h1><?php echo $produk['nama'];?></h1>
                    <p class="fs-5">
                    <?php echo $produk['detail'];?>
                    </p>
                    <p class="text-harga">
                        Rp <?php echo $produk['harga'];?>
                    </p>
                    <p class="fs-5">
                        Status ketersediaan: <b><?php echo $produk['ketersediaan_stok']?></b>
                    </p>
                    <a href="https://wa.me/6285976447993" class="btn warna3 text-white">Beli sekarang!</a>
                </div>
            </div>
        </div>
    </div>


    <!-- footer -->
    <?php require "footer.php"?>

    <!-- java script nya -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>

</body>
</html>