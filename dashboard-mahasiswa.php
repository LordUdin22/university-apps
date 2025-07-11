<?php
session_start();
if (!isset($_SESSION['tipe']) || $_SESSION['tipe'] !== 'mahasiswa') {
  header("Location: login.php");
  exit;
}
include 'config/koneksi.php';
$nim = $_SESSION['id'];

// Ambil data mahasiswa
$mhs = $conn->query("SELECT * FROM mahasiswa WHERE nim='$nim'")->fetch_assoc();

// Ambil data KRS dan nilai
$krs = $conn->query("SELECT krs.kode_mk, mk.nama_mk, n.nilai
                    FROM krs
                    JOIN matakuliah mk ON krs.kode_mk = mk.kode_mk
                    LEFT JOIN nilai n ON krs.nim = n.nim AND krs.kode_mk = n.kode_mk
                    WHERE krs.nim='$nim'");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Dashboard Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
  <div class="container-fluid">
    <span class="navbar-brand">Dashboard Mahasiswa</span>
    <a href="logout.php" class="btn btn-light">Logout</a>
  </div>
</nav>

<div class="container mt-4">
  <h3>Halo, <?= $mhs['nama'] ?>!</h3>
  <p><strong>NIM:</strong> <?= $mhs['nim'] ?> <br>
     <strong>Jurusan:</strong> <?= $mhs['jurusan'] ?></p>

  <h4 class="mt-4">KRS & Nilai</h4>
  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>Kode MK</th>
        <th>Nama Mata Kuliah</th>
        <th>Nilai</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $krs->fetch_assoc()): ?>
      <tr>
        <td><?= $row['kode_mk'] ?></td>
        <td><?= $row['nama_mk'] ?></td>
        <td><?= $row['nilai'] ?? '-' ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
    <h4 class="mt-5">Jadwal Kuliah</h4>
  <table class="table table-striped table-bordered">
    <thead class="table-dark">
      <tr>
        <th>Hari</th>
        <th>Jam</th>
        <th>Kode MK</th>
        <th>Nama Mata Kuliah</th>
        <th>Nama Dosen</th>
        <th>Ruang</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $jadwal = $conn->query("
        SELECT j.*, mk.nama_mk 
        FROM krs k
        JOIN jadwal j ON k.kode_mk = j.kode_mk
        JOIN matakuliah mk ON mk.kode_mk = j.kode_mk
        WHERE k.nim = '$nim'
        ORDER BY FIELD(j.hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'), j.jam_mulai
      ");
      while ($row = $jadwal->fetch_assoc()):
      ?>
      <tr>
        <td><?= $row['hari'] ?></td>
        <td><?= substr($row['jam_mulai'], 0, 5) ?> - <?= substr($row['jam_selesai'], 0, 5) ?></td>
        <td><?= $row['kode_mk'] ?></td>
        <td><?= $row['nama_mk'] ?></td>
        <td><?= $row['nama_dosen'] ?></td>
        <td><?= $row['ruang'] ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
