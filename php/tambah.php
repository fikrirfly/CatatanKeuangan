<?php
$conn = mysqli_connect("localhost", "root", "", "db_keuangan");
if(!$conn){
  die("Koneksi gagal: " . mysqli_connect_error());
}

$pesan = "";

if(isset($_POST['simpan'])){
  $nama     = $_POST['nama'] ?? '';
  $tanggal  = $_POST['tanggal'] ?? '';
  $jenis    = $_POST['jenis'] ?? '';
  $kategori = $_POST['kategori'] ?? '';
  $nominal  = $_POST['nominal'] ?? '';
  $deskripsi= $_POST['deskripsi'] ?? '';

  if($nama=="" || $tanggal=="" || $jenis=="" || $kategori=="" || $nominal==""){
    $pesan = "Nama, Tanggal, Jenis, Kategori, dan Nominal wajib diisi.";
  } else {
    $nama     = mysqli_real_escape_string($conn, $nama);
    $tanggal  = mysqli_real_escape_string($conn, $tanggal);
    $jenis    = mysqli_real_escape_string($conn, $jenis);
    $kategori = mysqli_real_escape_string($conn, $kategori);
    $nominal  = (int)$nominal;
    $deskripsi= mysqli_real_escape_string($conn, $deskripsi);

    $sql = "INSERT INTO transaksi (nama, tanggal, jenis, kategori, nominal, deskripsi)
            VALUES ('$nama','$tanggal','$jenis','$kategori',$nominal,'$deskripsi')";

    if(mysqli_query($conn, $sql)){
      header("Location: data.php");
      exit;
    } else {
      $pesan = "Gagal simpan data: " . mysqli_error($conn);
    }
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Data</title>
  <link rel="stylesheet" href="/keuangan_sederhana/css/style.css">
</head>
<body>
  <script src="/keuangan_sederhana/js/script.js"></script>


<header class="navbar">
  <div class="container nav-inner">
    <div class="brand">CATATAN KEUANGAN</div>
    <nav class="menu">
      <a href="index.php">Home</a>
      <a href="data.php">Data</a>
      <a href="tambah.php" class="active">Tambah Data</a>
    </nav>
  </div>
</header>
<main>
  <section class="hero">
    <div class="container hero-inner">

      <h2>Tambah Data</h2>

      <?php if($pesan!=""): ?>
        <p style="color:red;"><b><?= $pesan ?></b></p>
      <?php endif; ?>

      <div class="form-wrap">
        <form method="POST">
          <label>Nama</label>
          <input type="text" name="nama">

          <label>Tanggal</label>
          <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required>


          <label>Jenis</label>
        <select name="jenis">
            <option value="">-- Pilih --</option>
            <option value="Pemasukan">Pemasukan</option>
            <option value="Pengeluaran">Pengeluaran</option>
          </select>

          <label>Kategori</label>
          <input type="text" name="kategori">

          <label>Nominal</label>
          <input type="number" name="nominal">

          <label>Deskripsi</label>
          <textarea name="deskripsi"></textarea>

          <button type="submit" name="simpan">Simpan</button>
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
