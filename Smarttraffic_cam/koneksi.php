<?php
$conn = mysqli_connect("localhost", "root", "", "smarttraffic_cam");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>