<?php
include_once("koneksi.php");

if (isset($_POST['Submit'])) {
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];

    $sql = "INSERT INTO absensi (nama, jurusan, waktu_kehadiran) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nama, $jurusan);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data!');</script>";
    }
}

if (isset($_GET['id_siswa'])) {
    $id_siswa = htmlspecialchars($_GET["id_siswa"]);

    $sql = "DELETE FROM absensi WHERE id_siswa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_siswa);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/absensi.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">SMK N 1 WONOSEGORO</span>
        </div>
    </nav>

    <div class="container my-5">
        <h2 class="text-center">Presensi Siswa</h2>
        
        <div class="text-end mb-3">
            <a href="login.php" class="btn btn-secondary">Kembali ke Login</a>
        </div>

        <form method="post" class="my-3">
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="nama" placeholder="Nama Siswa" required>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="jurusan" placeholder="Jurusan" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100" name="Submit">Tambah</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Waktu Kehadiran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM absensi ORDER BY id_siswa DESC");
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['nama']}</td>
                            <td>{$row['jurusan']}</td>
                            <td>{$row['waktu_kehadiran']}</td>
                            <td>
                                <a href='update.php?id_siswa={$row['id_siswa']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='?id_siswa={$row['id_siswa']}' class='btn btn-danger btn-sm'>Hapus</a>
                            </td>
                        </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Belum ada data siswa</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>