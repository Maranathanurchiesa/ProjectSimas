<?php 
require 'config.php';

// Ambil NIM dari URL
$nim = $_GET['nim'] ?? '';

if(!$nim){
    header("Location: admin.php");
    exit;
}

// Ambil data berdasarkan NIM
$data = query("SELECT * FROM mahasiswa WHERE nim='$nim'");

if(!$data){
    header("Location: admin.php");
    exit;
}

$data = $data[0];

// Proses update
if(isset($_POST['update'])){

    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $gender = $_POST['gender'];
    $usia = $_POST['usia'];

    mysqli_query($conn, "UPDATE mahasiswa SET
        nama='$nama',
        alamat='$alamat',
        tanggal_lahir='$tanggal_lahir',
        gender='$gender',
        usia='$usia'
        WHERE nim='$nim'
    ");

    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Mahasiswa - SIMAS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- HEADER -->
<header class="main-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h2>
                <i class="fas fa-user-edit me-2"></i>
                Edit Data Mahasiswa
            </h2>
            <small>Sistem Informasi Manajemen Mahasiswa</small>
        </div>

        <div>
            <a href="admin.php" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</header>

<div class="container py-5">

    <div class="card p-5 edit-card">

        <h5 class="fw-bold mb-4">
            <i class="fas fa-pen me-2 text-primary"></i>
            Form Edit Mahasiswa
        </h5>

        <form method="POST" class="admin-form row g-4">

            <!-- NIM (TIDAK BISA DIEDIT) -->
            <div class="col-md-6">
                <label>NIM</label>
                <input type="text" 
                       class="form-control" 
                       value="<?= $data['nim'] ?>" 
                       readonly>
            </div>

            <div class="col-md-6">
                <label>Nama</label>
                <input type="text" 
                       name="nama"
                       class="form-control"
                       value="<?= $data['nama'] ?>" 
                       required>
            </div>

            <div class="col-md-6">
                <label>Alamat</label>
                <input type="text" 
                       name="alamat"
                       class="form-control"
                       value="<?= $data['alamat'] ?>" 
                       required>
            </div>

            <div class="col-md-6">
                <label>Tanggal Lahir</label>
                <input type="date" 
                       name="tanggal_lahir"
                       class="form-control"
                       value="<?= $data['tanggal_lahir'] ?>" 
                       required>
            </div>

            <div class="col-md-6">
                <label>Gender</label>
                <select name="gender" class="form-select" required>
                    <option value="Laki-laki"
                        <?= $data['gender']=='Laki-laki'?'selected':'' ?>>
                        Laki-laki
                    </option>

                    <option value="Perempuan"
                        <?= $data['gender']=='Perempuan'?'selected':'' ?>>
                        Perempuan
                    </option>
                </select>
            </div>

            <div class="col-md-6">
                <label>Usia</label>
                <input type="number" 
                       name="usia"
                       class="form-control"
                       value="<?= $data['usia'] ?>" 
                       required>
            </div>

            <div class="col-12 mt-4">
                <button type="submit" name="update" class="btn btn-gradient me-2">
                    <i class="fas fa-save me-1"></i> Update Data
                </button>

                <a href="admin.php" class="btn btn-secondary">
                    Batal
                </a>
            </div>

        </form>

    </div>

</div>

</body>
</html>