<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: login.php");
}

$error = "";

if(isset($_POST['simpan'])){

    $user_id = $_SESSION['id'];
    $lokasi = $_POST['lokasi'];
    $waktu = $_POST['waktu'];
    $jumlah = $_POST['jumlah'];
    $deskripsi = $_POST['deskripsi'];

    if(empty($lokasi) || empty($waktu) || empty($jumlah) || empty($deskripsi)){
        $error = "Semua field wajib diisi";
    } elseif(!is_numeric($jumlah)){
        $error = "Jumlah kendaraan harus angka";
    } else {

        if($jumlah <= 20){
            $status = "Lancar";
        } elseif($jumlah <= 50){
            $status = "Padat";
        } else {
            $status = "Macet";
        }
        
        $namaFile = $_FILES['foto']['name'];
        $tmpFile = $_FILES['foto']['tmp_name'];

        $ekstensi = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

        $format = ['jpg', 'jpeg', 'png'];

        if(in_array($ekstensi, $format)){

            move_uploaded_file($tmpFile, "uploads/" . $namaFile);

            mysqli_query($conn,
            "INSERT INTO monitoring
            (user_id, lokasi_cctv, waktu_monitoring,
            jumlah_kendaraan, status_kemacetan,
            deskripsi, foto_bukti)

            VALUES

            ('$user_id','$lokasi','$waktu',
            '$jumlah','$status',
            '$deskripsi','$namaFile')");

            header("Location: monitoring.php");

        } else {
            $error = "Format file harus jpg, jpeg, atau png";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Monitoring</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-4">

    <h3>Tambah Data Monitoring</h3>

    <?php if($error){ ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Lokasi CCTV</label>

            <input
            type="text"
            name="lokasi"
            class="form-control"
            required>
        </div>

        <div class="mb-3">
            <label>Waktu Monitoring</label>

            <input
            type="datetime-local"
            name="waktu"
            class="form-control"
            required>
        </div>

        <div class="mb-3">
            <label>Jumlah Kendaraan</label>

            <input
            type="number"
            name="jumlah"
            class="form-control"
            required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>

            <textarea
            name="deskripsi"
            class="form-control"
            rows="4"
            required></textarea>
        </div>

        <div class="mb-3">
            <label>Foto Bukti</label>

            <input
            type="file"
            name="foto"
            class="form-control"
            required>
        </div>

        <button
        type="submit"
        name="simpan"
        class="btn btn-primary">
            Simpan
        </button>

        <a href="monitoring.php" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

<?php include 'footer.php'; ?>

</body>
</html>