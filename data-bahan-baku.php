<?php
include 'db.php';

// Tambah bahan baku
if(isset($_POST['tambah'])){
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];
    mysqli_query($conn, "INSERT INTO tb_bahan_baku (nama, stok, satuan) VALUES ('$nama', '$stok', '$satuan')");
    header('Location: data-bahan-baku.php');
}

// Hapus bahan baku
if(isset($_GET['hapus'])){
    $nama = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM tb_bahan_baku WHERE nama='$nama'");
    header('Location: data-bahan-baku.php');
}

// Edit bahan baku
if(isset($_POST['edit'])){
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];
    mysqli_query($conn, "UPDATE tb_bahan_baku SET nama='$nama', stok='$stok', satuan='$satuan' WHERE id='$nama'");
    header('Location: data-bahan-baku.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Bahan Baku</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="dashboard.php">Hans Bakery</a></h1>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="data-bahan-baku.php">Data Bahan Baku</a></li>
                <li><a href="data-produk.php">Data Produk</a></li>
                <li><a href="keluar.php">Keluar</a></li>
            </ul>
        </div>
    </header>
    <div class="section">
        <div class="container">
            <h3>Data Bahan Baku</h3>
            <!-- Form tambah bahan baku -->
            <div class="box">
                <form method="POST">
                    <input type="text" name="nama" placeholder="Nama Bahan Baku" class="input-control" required>
                    <input type="number" name="stok" placeholder="Stok" class="input-control" required>
                    <input type="text" name="satuan" placeholder="Satuan (kg, liter, dll)" class="input-control" required>
                    <input type="submit" name="tambah" value="Tambah" class="btn">
                </form>
            </div>
            <!-- Tabel bahan baku -->
            <div class="box">
                <table border="1" cellspacing="0" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Bahan Baku</th>
                            <th>Stok</th>
                            <th>Satuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                 <?php
// Menampilkan data bahan baku
    $no = 1;
    $bahan = mysqli_query($conn, "SELECT * FROM tb_bahan_baku ORDER BY nama DESC");
    if(!$bahan){
        echo '<tr><td colspan="5">Gagal mengambil data: '.mysqli_error($conn).'</td></tr>';
    } else {
        while($row = mysqli_fetch_assoc($bahan)){
            // Jika sedang edit, tampilkan form edit
            if(isset($_GET['edit']) && $_GET['edit'] == $row['nama']){
    ?>
        <tr>
            <form method="POST">
                <td><?php echo $no++; ?></td>
                <td>
                    <input type="hidden" name="old_nama" value="<?php echo $row['nama']; ?>">
                    <input type="text" name="nama" value="<?php echo $row['nama']; ?>" required>
                </td>
                <td><input type="number" name="stok" value="<?php echo $row['stok']; ?>" required></td>
                <td><input type="text" name="satuan" value="<?php echo $row['satuan']; ?>" required></td>
                <td>
                    <input type="submit" name="edit" value="Simpan" class="btn">
                    <a href="data-bahan-baku.php" class="btn">Batal</a>
                </td>
            </form>
        </tr>
    <?php
            } else {
    ?>
        <tr>
            <th><?php echo $no++; ?></th>
            <th><?php echo $row['nama']; ?></th>
            <th><?php echo $row['stok']; ?></th>
            <th><?php echo $row['satuan']; ?></th>
            <th>
                <a href="data-bahan-baku.php?edit=<?php echo $row['nama']; ?>" class="btn btn-small">Edit</a>
                <a href="data-bahan-baku.php?hapus=<?php echo $row['nama']; ?>" class="btn btn-small" onclick="return confirm('Hapus data ini?')">Hapus</a>
            </th>
        </tr>
    <?php
            }
        }
    }
    ?>
</tbody>
                </table>
            </div>
        </div>
    </div>
    <footer>
        <div class="container">
            <small>Copyright &copy; 2025 - Hans Bakery.</small>
        </div>
    </footer>
</body>
</html>