<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: login.php");
}

$user_id = $_SESSION['id'];

$query = mysqli_query($conn,
"SELECT * FROM monitoring
WHERE user_id='$user_id'
ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Monitoring</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-4">

    <h3>Data Monitoring CCTV</h3>

    <a href="tambah_monitoring.php" class="btn btn-primary mb-3">
        Tambah Data
    </a>

    <table class="table table-bordered">

        <tr class="table-dark">
            <th>No</th>
            <th>Lokasi CCTV</th>
            <th>Waktu</th>
            <th>Jumlah Kendaraan</th>
            <th>Status</th>
            <th>Deskripsi</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;

        while($data = mysqli_fetch_assoc($query)){
        ?>

        <tr>

            <td><?php echo $no++; ?></td>

            <td>
                <?php echo $data['lokasi_cctv']; ?>
            </td>

            <td>
                <?php echo $data['waktu_monitoring']; ?>
            </td>

            <td>
                <?php echo $data['jumlah_kendaraan']; ?>
            </td>

            <td>
                <?php echo $data['status_kemacetan']; ?>
            </td>

            <td>
                <?php echo $data['deskripsi']; ?>
            </td>

            <td>

                <img
                src="uploads/<?php echo $data['foto_bukti']; ?>"
                width="100">

            </td>

            <td>

                <a
                href="edit_monitoring.php?id=<?php echo $data['id']; ?>"
                class="btn btn-warning btn-sm">
                    Edit
                </a>

                <a
                href="hapus_monitoring.php?id=<?php echo $data['id']; ?>"
                class="btn btn-danger btn-sm"
                onclick="return confirm('Yakin hapus data?')">
                    Hapus
                </a>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

<?php include 'footer.php'; ?>

</body>
</html>