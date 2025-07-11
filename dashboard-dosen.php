<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['tipe']) || $_SESSION['tipe'] !== 'dosen') {
  header("Location: login.php");
  exit;
}

$dosen = $conn->query("SELECT * FROM dosen WHERE nip='" . $_SESSION['id'] . "'")->fetch_assoc();

// Hapus mahasiswa
if (isset($_GET['hapus'])) {
  $conn->query("DELETE FROM mahasiswa WHERE nim='" . $_GET['hapus'] . "'");
  header("Location: dashboard-dosen.php");
  exit;
}

// Tambah / Edit mahasiswa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nim = $_POST['nim'];
  $nama = $_POST['nama'];
  $jurusan = $_POST['jurusan'];
  $password = $_POST['password'];

  if (isset($_POST['edit'])) {
    $conn->query("UPDATE mahasiswa SET nama='$nama', jurusan='$jurusan', password='$password' WHERE nim='$nim'");
  } else {
    $conn->query("INSERT INTO mahasiswa (nim, nama, jurusan, password) VALUES ('$nim','$nama','$jurusan','$password')");
  }
  header("Location: dashboard-dosen.php");
  exit;
}

// Ambil data untuk edit
$editData = null;
if (isset($_GET['edit'])) {
  $editData = $conn->query("SELECT * FROM mahasiswa WHERE nim='" . $_GET['edit'] . "'")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Dashboard Dosen - Universitas Lord Dream</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark p-3">
  <div class="container-fluid">
    <span class="navbar-brand">Dashboard Dosen</span>
    <a href="logout.php" class="btn btn-outline-light">Logout</a>
  </div>
</nav>

<div class="container mt-4">
  <h3>Selamat datang, <?= $dosen['nama'] ?>!</h3>
  <p><strong>NIP:</strong> <?= $dosen['nip'] ?><br>
     <strong>Mata Kuliah Ajar:</strong> <?= $dosen['matkul_ajar'] ?></p>

  <hr>
  <h4>Kelola Mahasiswa</h4>

  <!-- Form Tambah/Edit -->
  <form method="post" class="mb-4">
    <div class="row">
      <div class="col-md-3 mb-2">
        <input type="text" name="nim" value="<?= $editData['nim'] ?? '' ?>" class="form-control" placeholder="NIM" required <?= isset($editData) ? 'readonly' : '' ?>>
      </div>
      <div class="col-md-3 mb-2">
        <input type="text" name="nama" value="<?= $editData['nama'] ?? '' ?>" class="form-control" placeholder="Nama" required>
      </div>
      <div class="col-md-3 mb-2">
        <input type="text" name="jurusan" value="<?= $editData['jurusan'] ?? '' ?>" class="form-control" placeholder="Jurusan" required>
      </div>
      <div class="col-md-3 mb-2">
        <input type="text" name="password" value="<?= $editData['password'] ?? '' ?>" class="form-control" placeholder="Password" required>
      </div>
    </div>
    <button type="submit" name="<?= isset($editData) ? 'edit' : 'tambah' ?>" class="btn btn-<?= isset($editData) ? 'warning' : 'primary' ?>">
      <?= isset($editData) ? 'Update Mahasiswa' : 'Tambah Mahasiswa' ?>
    </button>
    <?php if (isset($editData)): ?>
      <a href="dashboard-dosen.php" class="btn btn-secondary">Batal</a>
    <?php endif; ?>
  </form>

  <!-- Tabel Mahasiswa (CRUD) -->
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>NIM</th>
        <th>Nama</th>
        <th>Jurusan</th>
        <th>Password</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $mahasiswa = $conn->query("SELECT * FROM mahasiswa ORDER BY nim");
      while ($row = $mahasiswa->fetch_assoc()):
      ?>
      <tr>
        <td><?= $row['nim'] ?></td>
        <td><?= $row['nama'] ?></td>
        <td><?= $row['jurusan'] ?></td>
        <td><?= $row['password'] ?></td>
        <td>
          <a href="?edit=<?= $row['nim'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="?hapus=<?= $row['nim'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <!-- Tabel Mata Kuliah -->
  <hr class="my-5">
  <h4>Daftar Seluruh Mata Kuliah</h4>
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>Kode MK</th>
        <th>Nama Mata Kuliah</th>
        <th>SKS</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $matkul = $conn->query("SELECT * FROM matakuliah ORDER BY kode_mk");
      while ($row = $matkul->fetch_assoc()):
      ?>
      <tr>
        <td><?= $row['kode_mk'] ?></td>
        <td><?= $row['nama_mk'] ?></td>
        <td><?= $row['sks'] ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <!-- Tabel Jadwal Mengajar -->
<hr class="my-5">
<h4>Jadwal Mengajar</h4>
<table class="table table-bordered table-hover">
  <thead class="table-dark">
    <tr>
      <th>Hari</th>
      <th>Jam</th>
      <th>Kode MK</th>
      <th>Nama Mata Kuliah</th>
      <th>Ruang</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $jadwal = $conn->query("
      SELECT j.*, mk.nama_mk 
      FROM jadwal j 
      JOIN matakuliah mk ON j.kode_mk = mk.kode_mk 
      WHERE j.nip = '{$dosen['nip']}'
      ORDER BY FIELD(j.hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'), jam_mulai
    ");
    while ($row = $jadwal->fetch_assoc()):
    ?>
    <tr>
      <td><?= $row['hari'] ?></td>
      <td><?= substr($row['jam_mulai'], 0, 5) ?> - <?= substr($row['jam_selesai'], 0, 5) ?></td>
      <td><?= $row['kode_mk'] ?></td>
      <td><?= $row['nama_mk'] ?></td>
      <td><?= $row['ruang'] ?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
</div>
</body>
</html>
