<?php
session_start();
include 'koneksi.php';

$error = "";

if(isset($_POST['register'])){

    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    if(empty($nama) || empty($email) || empty($password)){
        $error = "Semua field wajib diisi";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Format email tidak valid";
    } elseif(strlen($password) < 6){
        $error = "Password minimal 6 karakter";
    } else {

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($conn, "INSERT INTO users(nama,email,password)
        VALUES('$nama','$email','$password_hash')");

        header("Location: login.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="login-box">

                <h2 class="text-center mb-4">Register</h2>

                <?php if($error){ ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>

                <form method="POST">

                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <button type="submit" name="register" class="btn btn-primary w-100">
                        Register
                    </button>

                </form>

                <div class="text-center mt-3">
                    <a href="login.php">Sudah punya akun?</a>
                </div>

            </div>

</html>