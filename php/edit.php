<?php
$conn = mysqli_connect("localhost", "root", "", "db_keuangan");
if(!$conn){
  die("Koneksi gagal: " . mysqli_connect_error());
}

if(!isset($_GET['id'])){
  die("ID tidak ditemukan.");
}
$id = (int)$_GET['id'];

$q = mysqli_query($conn, "SELECT * FROM transaksi WHERE id=$id");
if(!$q || mysqli_num_rows($q) == 0){
  die("Data tidak ditemukan.");
}
$data = mysqli_fetch_assoc($q);

$pesan = "";

if(isset($_POST['update'])){
  $nama      = $_POST['nama'] ?? '';
  $tanggal   = $_POST['tanggal'] ?? '';
  $jenis     = $_POST['jenis'] ?? '';
  $kategori  = $_POST['kategori'] ?? '';
  $nominal   = $_POST['nominal'] ?? '';
  $deskripsi = $_POST['deskripsi'] ?? '';

  if($nama=="" || $tanggal=="" || $jenis=="" || $kategori=="" || $nominal==""){
    $pesan = "Nama, Tanggal, Jenis, Kategori, dan Nominal wajib diisi.";
  } elseif(!is_numeric($nominal) || (int)$nominal <= 0){
    $pesan = "Nominal harus angka dan lebih dari 0.";
  } else {
    $nama      = mysqli_real_escape_string($conn, $nama);
    $tanggal   = mysqli_real_escape_string($conn, $tanggal);
    $jenis     = mysqli_real_escape_string($conn, $jenis);
    $kategori  = mysqli_real_escape_string($conn, $kategori);
    $nominal   = (int)$nominal;
    $deskripsi = mysqli_real_escape_string($conn, $deskripsi);

    $sql = "UPDATE transaksi
            SET nama='$nama',
                tanggal='$tanggal',
                jenis='$jenis',
                kategori='$kategori',
                nominal=$nominal,
                deskripsi='$deskripsi'
            WHERE id=$id";

    if(mysqli_query($conn, $sql)){
      header("Location: data.php");
      exit;
    } else {
      $pesan = "Gagal update: " . mysqli_error($conn);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Data</title>
  <link rel="stylesheet" href="/keuangan_sederhana/css/style.css">
</head>
<body>
  <script src="/keuangan_sederhana/js/script.js"></script>


<header class="navbar">
  <div class="container nav-inner">
    <div class="brand">CATATAN KEUANGAN</div>
    <nav class="menu">
      <a href="index.php">Home</a>
      <a href="data.php" class="active">Data</a>
      <a href="tambah.php">Tambah Data</a>
    </nav>
  </div>
</header>

<main>
  <section class="hero">
    <div class="container hero-inner">

      <h2>Edit Data Transaksi</h2>
      <a href="data.php" style="color:#fff; font-weight:600;">← Kembali</a>
      <br><br>

      <?php if($pesan!=""): ?>
        <p class="alert danger"><b><?= $pesan ?></b></p>
      <?php endif; ?>

      <div class="form-wrap">
        <form method="POST">
          <label>Nama</label>
          <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>

          <label>Tanggal</label>
          <input type="date" name="tanggal" value="<?= htmlspecialchars($data['tanggal']) ?>" required>

          <label>Jenis</label>
          <select name="jenis" required>
            <option value="">-- Pilih --</option>
            <option value="Pemasukan" <?= ($data['jenis']=="Pemasukan") ? "selected" : "" ?>>Pemasukan</option>
            <option value="Pengeluaran" <?= ($data['jenis']=="Pengeluaran") ? "selected" : "" ?>>Pengeluaran</option>
          </select>

          <label>Kategori</label>
          <input type="text" name="kategori" value="<?= htmlspecialchars($data['kategori']) ?>" required>

          <label>Nominal</label>
          <input type="number" name="nominal" value="<?= htmlspecialchars($data['nominal']) ?>" required>

          <label>Deskripsi</label>
          <textarea name="deskripsi" rows="3"><?= htmlspecialchars($data['deskripsi']) ?></textarea>

          <button type="submit" name="update">Update</button>
        </form>
      </div>

    </div>
  </section>
</main>

<footer class="footer">
  <div class="container">
    <p>© 2025/2026 - STMIK Mardira Indonesia | Pemrograman Web 1</p>
  </div>
</footer>

</body>
</html>
