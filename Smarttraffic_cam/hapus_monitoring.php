<?php

$koneksi = mysqli_connect(
    "localhost",
    "root",
    "",
    "smarttraffic_cam"
);

if(!$koneksi){
    die("Koneksi gagal");
}

$id = $_GET['id'];

mysqli_query(
    $koneksi,
    "DELETE FROM monitoring WHERE id='$id'"
);

header("location:monitoring.php");

?>