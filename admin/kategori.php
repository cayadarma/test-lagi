<?php
    require "session.php";
    require "../koneksi.php";

    $queryCategory = mysqli_query($con, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryCategory);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kategori</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    .no-decoration{
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php";?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                <a href="../admin" class="no-decoration text-muted";>
                    <i class="fa-solid fa-house"></i> Home
                </a></li>
                <li class="breadcrumb-item active" aria-current="page"> Kategori</li>
            </ol>
        </nav>

        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Kategori</h3>

            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" placeholder="input nama kategori" class="form-control">
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                </div>
            </form>

            <!-- proses tombol submit -->
            <?php 
            // mengecek apakah datanya sudah ada di database/sudah ada sebelumnya
                if(isset($_POST['simpan'])){
                    $kategori = htmlspecialchars($_POST['kategori']);

                    $queryExist = mysqli_query($con, "SELECT nama FROM kategori WHERE nama = '$kategori'");
                    $dataBaru = mysqli_num_rows($queryExist);

                    //kalau kategorinya sudah ada
                    if($dataBaru > 0) {
                    ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Kategori sudah ada!
                        </div>
                    <?php
                    } else {
                        // kalau kategorinya baru/belum ada
                        $querySimpan = mysqli_query($con, "INSERT INTO kategori(nama) VALUES ('$kategori')");
                        
                        //kalau berhasil disimpan
                        if($querySimpan){
                        ?>
                            <div class="alert alert-success mt-3" role="alert">
                            Kategori berhasil disimpan!
                            </div>
                        
                        <!-- mengembalikan (merefresh) user ke halaman kategori-->
                            <meta http-equiv="refresh" content="2; url=kategori.php" />
                        <?php
                        }
                        else {
                            echo mysqli_error($con);
                        }
                    }
                }
            ?>
        </div>

    <div class="mt-3">
        <h2>List Kategori</h2>

        <!-- tabel responsive -->
        <div class="table-responsive mt-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
<!-- mengecek apakah data ada/tidak di database. lalu insert di table -->
                    <?php 
                        if($jumlahKategori==0){
                            ?>
                                <tr>
                                    <td colspan=3 class="text-center">Tidak ada data kategori yang tersedia</td>
                                </tr>
                            <?php
                            } else {
                                $number = 1;
                                
                            // mencetak data kategori sesuai dengan di database
                                while($data=mysqli_fetch_array($queryCategory)){
                            ?>
                                <tr>
                                    <td><?php echo $number;?></td>
                                    <td><?php echo $data['nama'];?></td>
                                    <td>
                                        <a href="edit-kategori.php?p=<?php echo $data['id']; ?>"
                                        class="btn btn-warning"><i class="fa-solid fa-list"></i></i>
                                    </td>
                                </tr>
                            <?php
                                $number++;    
                                }
                            }
                            

                    ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>