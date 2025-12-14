<?php
$koneksi = mysqli_connect("localhost", "root", "", "absensi_db");
if (!$koneksi) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
