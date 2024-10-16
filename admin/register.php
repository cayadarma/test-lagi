<?php
session_start();

// menghubungkan ke database
$conn = mysqli_connect("localhost", "root", "", "uas");

// cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Enkripsi password sebelum disimpan
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Menyimpan data ke database
    $query = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
    if (mysqli_query($conn, $query)) {
        // Redirect ke halaman login setelah registrasi berhasil
        header("Location: login.php");
        exit;
    } else {
        $error = "Pendaftaran gagal, coba lagi. Kesalahan: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<!-- style untuk box login -->
<style>
    .main{
        height: 100vh;
    }

    .login-box{
        width: 500px;
        height: 400px;
        box-sizing: border-box;
        border-radius: 10px;
    }
</style>

<!-- isi box login -->
<body>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        <div class="login-box p-5 shadow">
            <form action="" method="post">
            <h2>Daftar terlebih dahulu!</h2>

            <!-- berikut kondisi jika terjadi error -->
            <?php if (isset($error)): ?>
                    <div class="alert alert-warning" role="alert">
                    <?= $error;?>
                    </div></p>
                <?php endif; ?>

                <!-- isi dalam tabel register/daftar -->
                <div>
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div>
                    <button class="btn btn-success class form-control mt-3" type="submit" name="register">Daftar</button>
                </div>
                <p class="text-center mt-5">Sudah punya akun? Login <a href="login.php">disini!</a></p>
            </form>
        </div>
    </div>
</body>
</html>
