<?php
require_once 'koneksi.php';

// Tambah data
if (isset($_POST['simpan'])) {
  $nama = $_POST['nama'];
  $npm = $_POST['npm'];
  $ket = $_POST['keterangan'];

  mysqli_query($koneksi, "INSERT INTO absensi VALUES('', '$nama', '$npm', '$ket')");
}

// Hapus data
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  mysqli_query($koneksi, "DELETE FROM absensi WHERE id=$id");
}

// Mengambil data untuk edit
$edit = false;
$data_edit = [];
if (isset($_GET['edit'])) {
  $edit = true;
  $id = $_GET['edit'];
  $result = mysqli_query($koneksi, "SELECT * FROM absensi WHERE id=$id");
  $data_edit = mysqli_fetch_assoc($result);
}

// Update Data
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $nama = $_POST['nama'];
  $npm = $_POST['npm'];
  $ket = $_POST['keterangan'];

  mysqli_query(
    $koneksi,
    "UPDATE absensi SET nama='$nama', npm='$npm', keterangan='$ket' WHERE id=$id"
  );
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>CRUD Absensi Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Absensi Mahasiswa</h4>
      </div>

      <div class="card-body">
        <form method="POST" class="row g-3 mb-4">
          <input type="hidden" name="id" value="<?= $edit ? $data_edit['id'] : '' ?>">

          <div class="col-md-4">
            <input type="text" name="nama" class="form-control" placeholder="Nama Mahasiswa"
              value="<?= $edit ? $data_edit['nama'] : '' ?>" required>
          </div>

          <div class="col-md-3">
            <input type="text" name="npm" class="form-control" placeholder="NPM"
              value="<?= $edit ? $data_edit['npm'] : '' ?>" required>
          </div>

          <div class="col-md-3">
            <select name="keterangan" class="form-select" required>
              <option value="">-- Pilih --</option>
              <option value="Hadir" <?= ($edit && $data_edit['keterangan'] == 'Hadir') ? 'selected' : '' ?>>Hadir</option>
              <option value="Izin" <?= ($edit && $data_edit['keterangan'] == 'Izin') ? 'selected' : '' ?>>Izin</option>
              <option value="Alpha" <?= ($edit && $data_edit['keterangan'] == 'Alpha') ? 'selected' : '' ?>>Alpha</option>
            </select>
          </div>

          <div class="col-md-2 d-grid">
            <button type="submit" name="<?= $edit ? 'update' : 'simpan' ?>"
              class="btn <?= $edit ? 'btn-warning' : 'btn-success' ?>">
              <?= $edit ? 'Update' : 'Simpan' ?>
            </button>
          </div>
        </form>

        <table class="table table-bordered table-striped table-hover">
          <thead class="table-dark">
            <tr>
              <th>No</th>
              <th>Nama Mahasiswa</th>
              <th>NPM</th>
              <th>Keterangan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM absensi");
            while ($row = mysqli_fetch_assoc($data)) {
            ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['npm'] ?></td>
                <td>
                  <span class="badge bg-<?=
                    $row['keterangan'] == 'Hadir' ? 'success' : ($row['keterangan'] == 'Izin' ? 'warning' : 'danger')
                    ?>">
                    <?= $row['keterangan'] ?>
                  </span>
                </td>
                <td>
                  <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                    onclick="return confirm('Hapus data?')">Hapus</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>