<?php
include_once("koneksi.php");

if (isset($_GET['id_siswa'])) {
    $id_siswa = $_GET['id_siswa'];

    $result = $conn->query("SELECT * FROM absensi WHERE id_siswa = $id_siswa");
    $row = $result->fetch_assoc();

    if (isset($_POST['Update'])) {
        $nama = $_POST['nama'];
        $jurusan = $_POST['jurusan'];

        $sql = "UPDATE absensi SET nama = ?, jurusan = ? WHERE id_siswa = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nama, $jurusan, $id_siswa);

        if ($stmt->execute()) {
            echo "<script>alert('Data berhasil diperbarui!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Edit Data Siswa</h2>
        <form method="post">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" class="form-control" name="nama" value="<?= $row['nama'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Jurusan</label>
                <input type="text" class="form-control" name="jurusan" value="<?= $row['jurusan'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="Update">Perbarui</button>
        </form>
    </div>
</body>
</html>