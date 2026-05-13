<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: login.php");
}

$id = $_SESSION['id'];

$total = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM monitoring WHERE user_id='$id'"));

$lancar = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM monitoring
WHERE status_kemacetan='Lancar' AND user_id='$id'"));

$padat = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM monitoring
WHERE status_kemacetan='Padat' AND user_id='$id'"));

$macet = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM monitoring
WHERE status_kemacetan='Macet' AND user_id='$id'"));

$terbaru = mysqli_query($conn,
"SELECT * FROM monitoring WHERE user_id='$id'
ORDER BY id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-4">

    <h3>Selamat Datang, <?php echo $_SESSION['nama']; ?></h3>

    <div class="row mt-4">

        <div class="col-md-3">
            <div class="card-box bg-blue">
                <h5>Total Monitoring</h5>
                <h2><?php echo $total['total']; ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box bg-green">
                <h5>Lancar</h5>
                <h2><?php echo $lancar['total']; ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box bg-orange">
                <h5>Padat</h5>
                <h2><?php echo $padat['total']; ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box bg-red">
                <h5>Macet</h5>
                <h2><?php echo $macet['total']; ?></h2>
            </div>
        </div>

    </div>

    <div class="mt-5">

        <h4>Monitoring Terbaru</h4>
</html>