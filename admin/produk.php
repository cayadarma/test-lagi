<?php
    require "session.php";
    require "../koneksi.php";

    //menghubungkan dengan tabel produk di database dan supaya tidak menggunakan kategori_id
    $query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
    $jumlahProduk = mysqli_num_rows($query);

    $queryCategory = mysqli_query($con, "SELECT * FROM kategori");

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
    <title>produk</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    .no-decoration{
        text-decoration: none;
    }

    form div{
        margin-bottom: 10px;
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
                    <li class="breadcrumb-item active" aria-current="page"> Produk</li>
                </ol>
            </nav>

        <!-- tambah produk -->
        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Produk</h3>

            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <!-- form nama di produk -->
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" required>
                </div>
                <div>
                    <!-- form kategori di produk -->
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="">Pilih salah satu</option>
                        <?php
                            while($data=mysqli_fetch_array($queryCategory)){
                            ?>
                                <option value="<?php echo $data['id']; ?>"><?php echo $data['nama'];?></option>
                            <?php
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <!-- form harga di produk -->
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" name="harga" required>
                </div>
                <div>
                    <!-- form input foto -->
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <!-- form detail -->
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10"></textarea>
                </div>
                <div>
                    <!-- form ketersediaan stok -->
                    <label for="ketersediaan_stok">Ketersediaan Stok</label>
                    <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>
                <div>
                    <!-- tombol submit -->
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>
            </form>

            <!-- validasi produk di backend -->
            <?php
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

                    // mengecek jika nama, kategori,dan harga ada yang masih kosong
                    if($nama=='' || $kategori=='' || $harga==''){
                    ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Nama, Kategori, dan Harga WAJIB DIISI!
                        </div>
                    <?php
                    } else {
                        //pengecekan apakah fotonya kosong atau enggak
                        if($nama_file!=''){
                            //mengecek apakah ukuran foto lebih dari 500kb
                            if($image_size>500000){
                            ?>
                                <div class="alert alert-warning mt-3" role="alert">
                                    File tidak boleh lebih dari 500 kb!
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
                            //mengupload file foto
                                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                                }
                            }
                        }

                        //menyimpan data yang diupload ke database (tabel produk)
                        $queryTambah = mysqli_query($con, "INSERT INTO produk (kategori_id, nama, harga, foto, detail, ketersediaan_stok)
                        VALUES ('$kategori', '$nama', '$harga', '$new_name', '$detail', '$ketersediaan_stok')");

                        if($queryTambah){
                        ?>
                          <div class="alert alert-success mt-3" role="alert">
                            Produk berhasil disimpan!
                            </div>
                        
                        <!-- mengembalikan (merefresh) user ke halaman kategori-->
                            <meta http-equiv="refresh" content="1; url=produk.php" />
                      <?php
                        } else {
                            mysqli_error($con);
                        }
                    }
                }
            ?>
        </div>

        <!-- tabel produk -->
        <div class="mt-3 mb-3">
            <h2>List Produk</h2>
            <div class="table-responsive mt-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Ketersediaan Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //kalau jumlah produknya 0 atau belum isi
                        if($jumlahProduk==0){
                        ?>
                            <tr>
                                <td colspan=6 class="text-center">Tidak ada data produk yang tersedia</td>
                            </tr>
                        <?php
                        } else {
                        //kalau jumlah produknya sudah terisi    
                            $number = 1;
                            while($data=mysqli_fetch_array($query)){
                            ?>
                                <tr>
                                    <td><?php echo $number; ?></td>
                                    <td><?php echo $data['nama']; ?></td>
                                    <td><?php echo $data['nama_kategori']; ?></td>
                                    <td><?php echo $data['harga']; ?></td>
                                    <td><?php echo $data['ketersediaan_stok']; ?></td>
                                    <td>
                                        <a href="edit-produk.php?p=<?php echo $data['id']; ?>"
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
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>