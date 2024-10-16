<?php
    require "session.php";
    require "../koneksi.php";

    //mengambil jumlah angka kategori dari database (sesuai banyaknya kategori di database)
    $queryCategory = mysqli_query($con, "SELECT * FROM  kategori");
    $jumlahKategori = mysqli_num_rows($queryCategory);

    //mengambil jumlah angka produk dari database (sesuai dengan banyaknya produk di database)
    $queryProduct = mysqli_query($con, "SELECT * FROM  produk");
    $jumlahProduk = mysqli_num_rows($queryProduct);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<!-- membuat style di kolom kategori -->
<style>
    .kotak{
        border: solid;
    }

    .summary-product{
        background-color: #50B498;
        border-radius: 15px;
    }
    .summary-category {
        background-color: #468585;
        border-radius: 15px;
    }

    .no-decoration{
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
            <i class="fa-solid fa-house"></i> Home
            </li>
        </ol>
        </nav>
        <h2>Hallo, <?php echo $_SESSION['username']?>!</h2>
        <!-- membuat tampilan responsive -->
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-category p-4">
                        <div class="row text-white">
                            <div class="col-6">
                            <i class="fa-solid fa-list fa-7x"></i>
                            </div>
                            <div class="col-6">
                            <h3 class="fs-2">Kategori</h3>
                            <p class="fs-4"><?php echo $jumlahKategori;?> kategori</p>
                            <p><a href="kategori.php" class="text-white no-decoration">Lihat detail disini!</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-product p-4">
                        <div class="row text-white">
                            <div class="col-6">
                            <i class="fa-solid fa-paw fa-7x"></i>
                            </div>
                            <div class="col-6">
                            <h3 class="fs-2">Produk</h3>
                            <p class="fs-4"><?php echo $jumlahProduk;?> produk</p>
                            <p><a href="produk.php" class="text-white no-decoration">Lihat detail disini!</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>