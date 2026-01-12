<?php
$conn = mysqli_connect("localhost", "root", "", "db_keuangan");
if(!$conn){
  die("Koneksi gagal: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Transaksi</title>
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

      <h2>Data Transaksi</h2>

<?php if(isset($_GET['msg'])): ?>
  <?php if($_GET['msg'] == "hapus_sukses"): ?>
    <p class="alert success">✅ Data berhasil dihapus.</p>
  <?php elseif($_GET['msg'] == "hapus_gagal"): ?>
    <p class="alert danger">❌ Data gagal dihapus.</p>
  <?php endif; ?>
<?php endif; ?>


      <div class="table-wrap">
        <table>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Kategori</th>
            <th>Nominal</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
          </tr>

          <?php
          $no = 1;
          $query = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY id DESC");
          while($row = mysqli_fetch_assoc($query)){
            echo "<tr>
              <td>$no</td>
              <td>{$row['nama']}</td>
              <td>{$row['tanggal']}</td>
              <td>{$row['jenis']}</td>
              <td>{$row['kategori']}</td>
              <td>{$row['nominal']}</td>
              <td>{$row['deskripsi']}</td>
              <td>
                <a href='edit.php?id={$row['id']}'>Edit</a> |
                <a href='hapus.php?id={$row['id']}' onclick='return confirm(\"Hapus?\")'>Hapus</a>
              </td>
            </tr>";
            $no++;
          }
          ?>

        </table>
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
