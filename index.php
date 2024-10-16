<?php
    require "koneksi.php";

    //memanggil id, nama, harga, dan foto produk. tapi karena cuma mau nampilin 6 aja, jadinya pakai limit 6
    $queryProduct=mysqli_query($con, "SELECT id, nama, harga, foto, detail FROM produk LIMIT 6");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WOPIFARM || website jual beli ternak seputar Bali</title>

    <!-- style webnya -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"?>

    <!-- banner -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>WOPIFARM</h1>
            <h3>Cari hewan ternakmu sekarang!</h3>
            <div class="col-md-8 offset-md-2">
                <form method="get" action="produk.php">
                <div class="input-group input-group-lg my-4">

                    <!-- search bar -->
                    <input type="text" class="form-control" placeholder="Nama Produk" aria-label="Nama Produk" aria-describedby="basic-addon2" name="keyword">
                    <button type="submit" class="btn warna2">Telusuri</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- highlight kategori -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Kategori Terlaris</h3>

            <div class="row mt-3 text-white">
                <div class="col-md-4 mb-3">
                    <div class="top-category pig-category d-flex justify-content-center align-items-center">
                        <h4><a class="no-decoration" href="produk.php?kategori=babi">Babi</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="top-category bird-category d-flex justify-content-center align-items-center">
                        <h4><a class="no-decoration" href="produk.php?kategori=burung">Burung</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="top-category dog-category d-flex justify-content-center align-items-center">
                        <h4><a class="no-decoration" href="produk.php?kategori=anjing">Anjing</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- about us -->
     <div class="container-fluid warna2 py-5">
        <div class="container text-center">
            <h3>Tentang Kami</h3>
            <p class="fs-5 mt-5">Selamat datang di WOPIFARM! Tempat terbaik buat kamu yang lagi nyari ternak di Bali! Di sini, kamu bisa temuin berbagai macam hewan ternak
                mulai dari anjing, burung, ayam, sampai babi dengan harga yang bersahabat. Kami berkomitmen untuk memberi info lengkap soal kondisi hewan, asal usul, dan cara perawatannya biar kamu nggak salah pilih. 
                Tidak hanya itu, kami juga sering ngadain tips dan trik seputar peternakan yang bisa bantu kamu jadi peternak sukses.</p>
            <p class="fs-5 mt-5">Yuk, langsung cek koleksi ternak kami dan rasakan kemudahan berbelanja ternak secara online di Bali!</p>
        </div>
     </div>

    <!-- product -->
    <div class="container-fluid py-">
        <div class="container text-center">
            <h3 class="mt-5">Produk</h3>

            <div class="row mt-5">
                <!-- perulangan untuk memanggil produknya -->
                 <?php while($data=mysqli_fetch_array($queryProduct)) {
                    ?>
                <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="image-box">
                            <img src="image/<?php echo $data['foto']; ?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $data['nama']; ?></h5>
                            <p class="card-text text-truncate"><?php echo $data['detail'];?>.</p>
                            <p class="card-text text-harga">Rp <?php echo $data['harga']; ?></p>
                            <a href="produk-detail.php?nama=<?php echo $data['nama']?>" class="btn warna3 text-white">Lihat detail</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- tombol see more -->
             <a class="btn btn-outline-success mt-3 mb-5" href="produk.php">See More</a>
        </div>
    </div>

    <!-- footer -->
    <?php require "footer.php";?>

    <!-- java script nya -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>