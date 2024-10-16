<?php
    require "session.php";
    require "../koneksi.php";

    $id = $_GET['p'];

    //menghubungkan dengan tabel produk di database dan supaya tidak menggunakan kategori_id
    $query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id'");
    $data = mysqli_fetch_array($query);

    $queryCategory = mysqli_query($con, "SELECT * FROM kategori WHERE id!='$data[kategori_id]'");

    //function supaya tidak ada nama gambar yang sama
    function ubahNamaGambar($length = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for($i = 0; $i < $length; $i++){
            $randomString .= $characters[rand(0,$charactersLength - 1)];
        }
        return $randomString;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wopifarm || detail produk</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css"> -->
</head>

<style>
    form div{
    margin-bottom: 10px;
    }
</style>
<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <h2>Detail Produk</h2>

        <div class="col-12 col-md-6">
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <!-- form nama -->
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $data['nama']; ?>">
                </div>
                <div>
                    <!-- form kategori-->
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="<?php echo $data['kategori_id']; ?>"><?php echo $data['nama_kategori'];?></option>
                        <?php
                            while($dataKategori=mysqli_fetch_array($queryCategory)){
                            ?>
                                <option value="<?php echo $dataKategori['id']; ?>"><?php echo $dataKategori['nama'];?></option>
                            <?php
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <!-- form harga-->
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" value="<?php echo $data['harga'];?>" name="harga" required>
                </div>
                <div class="mt-3">
                    <!-- menampilkan foro yang sudah ada -->
                    <label for="currentFoto">Foto Produk Sekarang</label>
                    <img src="../image/<?php echo $data['foto']?>" alt="" width="300px">
                </div>
                <div>
                    <!-- form input foto baru -->
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <!-- form detail -->
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10">
                        <?php echo $data['detail']; ?>
                    </textarea>
                </div>
                <div>
                    <!-- form ketersediaan stok -->
                    <label for="ketersediaan_stok">Ketersediaan Stok</label>
                    <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                        <option value="<?php echo $data['ketersediaan_stok'];?>"><?php echo $data['ketersediaan_stok'];?></option>
                        <?php
                        if($data['ketersediaan_stok']=='tersedia'){
                        ?>
                            <option value="habis">habis</option>
                        <?php
                        } else {
                        ?>
                            <option value="tersedia">tersedia</option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <!-- button simpan untuk editnya -->
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                    <!-- button delete untuk menghapus data -->
                    <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
                </div>
            </form>

            <?php 
                //kondisi jika button simpan diklik
                if(isset($_POST['simpan'])){
                    $nama=htmlspecialchars($_POST['nama']);
                    $kategori=htmlspecialchars($_POST['kategori']);
                    $harga=htmlspecialchars($_POST['harga']);
                    $detail=htmlspecialchars($_POST['detail']);
                    $ketersediaan_stok=htmlspecialchars($_POST['ketersediaan_stok']);

                    //ngecek buat upload gambarnya
                    $target_dir = "../image/";
                    $nama_file = basename($_FILES["foto"]["name"]);
                    $target_file = $target_dir . $nama_file;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $image_size = $_FILES["foto"]["size"];
                    $randomName = ubahNamaGambar(20);
                    $new_name = $randomName . "." . $imageFileType;

                    if($nama=='' || $kategori=='' || $harga==''){
                        ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                Nama, Kategori, dan Harga WAJIB DIISI!
                            </div>
                        <?php
                        } else {
                            $queryUpdate = mysqli_query($con, "UPDATE produk SET kategori_id='$kategori', nama='$nama', harga='$harga', detail='$detail', ketersediaan_stok='$ketersediaan_stok' WHERE id='$id'");
                        
                        //di bawah adalah kondisi saat ngecek apakah ada foto baru yang diupload atau enggak
                        //jika kondisinya ada foto baru
                            if($nama_file!=''){
                                if($image_size > 500000){
                                ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        File tidak boleh lebih dari 500 KB!
                                    </div>
                                <?php
                                } else {
                                    //mengecek apakah type file adalah jpg, png, gif
                                    if($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' && $imageFileType != 'gif'){
                                    ?>    
                                        <div class="alert alert-warning mt-3" role="alert">
                                        Format file harus JPG, JPEG, PNG, atau GIF!
                                        </div>
                                    <?php
                                    } else {
                                        //mengupload file foto ke folder image
                                        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);

                                        $queryUpdate=mysqli_query($con, "UPDATE produk SET foto='$new_name' WHERE id='$id'");

                                        //mengupload foto ke database
                                        if($queryUpdate){
                                        ?>
                                            <div class="alert alert-success mt-3" role="alert">
                                                Produk berhasil diupdate!
                                                </div>
                                            
                                            <!-- mengembalikan (merefresh) user ke halaman produk-->
                                                <meta http-equiv="refresh" content="1; url=produk.php" />
                                        <?php
                                        } else {
                                            echo mysqli_error($con);
                                        }
                                    }
                                }
                            }
                        }
                    }
                
                //kondisi untuk button delete
                if(isset($_POST['hapus'])){
                    $queryHapus = mysqli_query($con, "DELETE FROM produk WHERE id='$id'");

                    //kalau button delete ditekan
                    if($queryHapus){
                        ?>
                            <div class="alert alert-success mt-3" role="alert">
                            Produk berhasil dihapus!
                            </div>

                        <!-- mengembalikan admin ke  -->
                        <meta http-equiv="refresh" content="1; url=produk.php">
                        <?php
                    }
                }
            ?>
        </div>
    </div>


    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../fontawesome/js/all.min.js"></script> -->
</body>
</html>