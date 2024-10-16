<?php
require "koneksi.php";

$queryCategory = mysqli_query($con, "SELECT * FROM kategori");

// untuk nampilin produk dgn get produk by nama/keyword
if(isset($_GET['keyword'])){
    $queryProduct = mysqli_query($con, "SELECT * FROM produk WHERE nama LIKE '%".$_GET['keyword']."%'");
}

// untuk nampilin produk dgn get produk by category
else if(isset($_GET['kategori'])){
    $queryGetKategoriId = mysqli_query($con, "SELECT id FROM kategori WHERE nama='".$_GET['kategori']."'");
    $kategoriId = mysqli_fetch_array($queryGetKategoriId);

    $queryProduct = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$kategoriId[id]'");
}
// untuk nampilin produk dgn get produk default
else{
    $queryProduct = mysqli_query($con, "SELECT * FROM produk");
}

$countData = mysqli_num_rows($queryProduct);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>produk</title>

    <!-- style webnya -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php";?>

    <!-- banner -->
    <div class="container-fluid banner2 d-flex align-item-center">
        <div class="container">
            <h1 class="text-white text-center">Produk</h1>
        </div>
    </div>

    <!-- container -->
     <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
            <h3>Kategori</h3>
                <ul class="list-group">
                    <!-- memanggil nama-nama kategori dari database -->
                    <?php while($kategori = mysqli_fetch_array($queryCategory)) {?> 
                    <a class="no-decoration" href="produk.php?kategori=<?php echo $kategori['nama']?>">
                        <li class="list-group-item"><?php echo $kategori['nama']?></li>
                    </a>
                    <?php } ?>
                </ul>
            </div>

                <!-- memanggil produk -->
                <div class="col-lg-9">
                    <h3 class="text-center mb-3">Produk</h3>
                    <div class="row">

                    <!-- kondisi kalau produk yang dicari tidak tersedia -->
                    <?php
                        if($countData<1){
                    ?>
                        <h4 class="text-center my-5">Produk yang anda cari tidak tersedia</h4>
                    <?php
                        }
                    ?>
                        <?php while($produk = mysqli_fetch_array($queryProduct)) {?>
                    
                        <!-- card produk -->
                        <div class="col-sm-6 col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="image-box">
                                <img src="image/<?php echo $produk['foto']; ?>" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $produk['nama']; ?></h5>
                                <p class="card-text text-truncate"><?php echo $produk['detail'];?>.</p>
                                <p class="card-text text-harga">Rp <?php echo $produk['harga'];?></p>
                                <a href="produk-detail.php?nama=p" class="btn warna3 text-white">Lihat detail</a>
                            </div>
                        </div>
                        </div>
                    <?php } ?>
                    </div>
                </div>
        </div>
     </div>

    <!-- java script nya -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>