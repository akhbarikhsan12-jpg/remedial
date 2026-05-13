<?php
session_start();
include 'koneksi.php';

$error = "";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $data = mysqli_fetch_assoc($query);

    if($data && password_verify($password, $data['password'])){

        $_SESSION['id'] = $data['id'];
        $_SESSION['nama'] = $data['nama'];

        header("Location: dashboard.php");

    } else {
        $error = "Email atau password salah";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="login-box">

                <h2 class="text-center mb-4">Login</h2>

                <?php if($error){ ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>

                <form method="POST">

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <button type="submit" name="login" class="btn btn-primary w-100">
                        Login
                    </button>

                </form>

                <div class="text-center mt-3">
                    <a href="register.php">Belum punya akun?</a>
                </div>

            </div>

        </div>
    </div>
</div>

</body>
</html>