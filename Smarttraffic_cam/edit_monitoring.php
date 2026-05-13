<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: login.php");
}

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM monitoring WHERE id='$id'"));

$error = "";

if(isset($_POST['update'])){

    $lokasi = $_POST['lokasi'];
    $waktu = $_POST['waktu'];
    $jumlah = $_POST['jumlah'];
    $deskripsi = $_POST['deskripsi'];

    // Validasi
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

        $foto = $data['foto_bukti'];

        if($_FILES['foto']['name'] != ""){

            $namaFile = $_FILES['foto']['name'];
            $tmpFile = $_FILES['foto']['tmp_name'];

            $ekstensi = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

            $format = ['jpg', 'jpeg', 'png'];

            if(in_array($ekstensi, $format)){

                move_uploaded_file($tmpFile, "uploads/" . $namaFile);

                $foto = $namaFile;

            } else {
                $error = "Format file harus jpg, jpeg, atau png";
            }
        }

        if($error == ""){

            mysqli_query($conn,
            "UPDATE monitoring SET

            lokasi_cctv='$lokasi',
            waktu_monitoring='$waktu',
            jumlah_kendaraan='$jumlah',
            status_kemacetan='$status',
            deskripsi='$deskripsi',
            foto_bukti='$foto'

            WHERE id='$id'");

            header("Location: monitoring.php");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Monitoring</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-4">

    <h3>Edit Data Monitoring</h3>

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
            value="<?php echo $data['lokasi_cctv']; ?>"
            required>
        </div>

        <div class="mb-3">
            <label>Waktu Monitoring</label>

            <input
            type="datetime-local"
            name="waktu"
            class="form-control"
            value="<?php echo date('Y-m-d\\TH:i', strtotime($data['waktu_monitoring'])); ?>"
            required>
        </div>

        <div class="mb-3">
            <label>Jumlah Kendaraan</label>

            <input
            type="number"
            name="jumlah"
            class="form-control"
            value="<?php echo $data['jumlah_kendaraan']; ?>"
            required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>

            <textarea
            name="deskripsi"
            class="form-control"
            rows="4"
            required><?php echo $data['deskripsi']; ?></textarea>
        </div>

        <div class="mb-3">
            <label>Foto Lama</label><br>

            <img
            src="uploads/<?php echo $data['foto_bukti']; ?>"
            width="120">
        </div>

        <div class="mb-3">
            <label>Upload Foto Baru</label>

            <input
            type="file"
            name="foto"
            class="form-control">
        </div>

        <button
        type="submit"
        name="update"
        class="btn btn-warning">
            Update
        </button>

        <a href="monitoring.php" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

<?php include 'footer.php'; ?>

</body>
</html>