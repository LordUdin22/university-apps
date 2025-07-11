<?php
session_start();
include 'config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST['id'];
  $password = $_POST['password'];
  $tipe = $_POST['tipe'];

  if ($tipe === "mahasiswa") {
    $q = $conn->query("SELECT * FROM mahasiswa WHERE nim='$id' AND password='$password'");
    if ($q->num_rows > 0) {
      $_SESSION['tipe'] = 'mahasiswa';
      $_SESSION['id'] = $id;
      header("Location: dashboard-mahasiswa.php");
      exit;
    }
  } elseif ($tipe === "dosen") {
    $q = $conn->query("SELECT * FROM dosen WHERE nip='$id' AND password='$password'");
    if ($q->num_rows > 0) {
      $_SESSION['tipe'] = 'dosen';
      $_SESSION['id'] = $id;
      header("Location: dashboard-dosen.php");
      exit;
    }
  }
  $error = "Login gagal. Cek ID dan Password.";
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login Sistem Akademik</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card p-4 shadow w-50 mx-auto">
    <div class="text-center mb-3">
      <img src="img/logo.png" alt="Logo" class="logo-sm">
      <h3 class="mt-2">Login Sistem Akademik</h3>
    </div>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="post">
      <div class="mb-3">
        <label>ID (NIM/NIP)</label>
        <input type="text" name="id" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Login Sebagai</label>
        <select name="tipe" class="form-select" required>
          <option value="mahasiswa">Mahasiswa</option>
          <option value="dosen">Dosen</option>
        </select>
      </div>
      <button class="btn btn-primary w-100">Login</button>
    </form>
    <a href="index.php" class="btn btn-secondary mt-3 w-100">← Kembali ke Beranda</a>
  </div>
</div>
</body>
</html>
