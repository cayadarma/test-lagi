<?php
    require "session.php";
    require "../koneksi.php";

    $id = $_GET['p'];

    $query = mysqli_query($con, "SELECT * FROM kategori WHERE id='$id'");
    $data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit kategori</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>
<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <h2>Edit Kategori</h2>

        <div class="col-12 col-md-6">
            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $data['nama']; ?>">
                </div>

                <div class="mt-3 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="editBtn">Edit</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn">Delete</button>
                </div>
            </form>

            <?php 
                //fungsi tombol edit
                if(isset($_POST['editBtn'])){
                    $kategori = htmlspecialchars($_POST['kategori']);
                    
                    //memastikan yang di edit ada/tidak ada di database sebelumnya
                    if($data['nama']==$kategori){
                        ?>
                            <!-- mengembalikan (merefresh) user ke halaman kategori kalau tidak mengedit dan langsung submit-->
                            <meta http-equiv="refresh" content="0; url=kategori.php" />
                        <?php
                    } else {
                        $query = mysqli_query($con, "SELECT * FROM kategori WHERE nama='$kategori'");
                        $jumlahData = mysqli_num_rows($query);
                        
                        //kalau datanya sudah ada di database
                        if($jumlahData > 0){
                        ?>
                            <div class="alert alert-warning mt-3" role="alert">
                            Kategori sudah ada!
                            </div>
                        <?php
                        } else {
                        // kalau kategorinya baru/belum ada
                        $querySimpan = mysqli_query($con, "UPDATE kategori SET nama='$kategori' WHERE id='$id'");
                        
                        //kalau berhasil disimpan
                        if($querySimpan){
                            ?>
                                <div class="alert alert-success mt-3" role="alert">
                                Kategori berhasil diupdate!
                                </div>
                            
                            <!-- mengembalikan (merefresh) user ke halaman kategori-->
                                <meta http-equiv="refresh" content="1; url=kategori.php" />
                            <?php
                            }
    
                        }
                    }
                }

                //fungsi tombol delete
                if(isset($_POST['deleteBtn'])){
                    //memeriksa apakah ada kategori itu di tabel produk atau enggak
                    $queryCheck = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id ='$id'");
                    $dataCount = mysqli_num_rows($queryCheck);
                    
                    //kondisi jika ada
                    if($dataCount>0){
                    ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Kategori tidak bisa dihapus karena berisi produk!
                        </div>
                    <?php
                    die();
                    //supaya gak lanjut ke bawahnya
                    }

                    $queryDelete = mysqli_query($con, "DELETE FROM kategori WHERE id='$id'");
                    
                    //jika kategori tidak digunakan dalam tabel produk/tidak berisi produk
                    if($queryDelete) {
                    ?>
                        <div class="alert alert-success mt-3" role="alert">
                            Kategori berhasil dihapus!
                        </div>

                        <meta http-equiv="refresh" content="1; url=kategori.php">
                    <?php
                    } else {
                        echo mysqli_error($con);
                    }
                }
            ?>
        </div>
    </div>


    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
