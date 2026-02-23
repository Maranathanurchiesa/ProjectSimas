<?php 
require 'config.php';

// --- FUNGSI HELPER ---
if (!function_exists('query')) {
    function query($query) {
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
        }
        return $rows;
    }
}

// 1. TAMBAH DATA
if(isset($_POST['tambah'])){
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $gender = $_POST['gender'];
    $usia = $_POST['usia']; // Diambil dari input yang diisi otomatis oleh JS

    $sql = "INSERT INTO mahasiswa (nim, nama, alamat, tanggal_lahir, gender, usia) 
            VALUES ('$nim', '$nama', '$alamat', '$tanggal_lahir', '$gender', '$usia')";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: admin.php");
        exit;
    }
}

// 2. HAPUS DATA
if(isset($_GET['hapus'])){
    $nim = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE nim='$nim'");
    header("Location: admin.php");
    exit;
}

// 3. AMBIL DATA - Urutan Alfanumerik DESC
$mahasiswa = query("SELECT * FROM mahasiswa ORDER BY nim DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIMAS - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="admin-header mb-5">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h3><i class="fas fa-user-shield me-2"></i>Admin Panel</h3>
            <small>Sistem Informasi Manajemen Mahasiswa</small>
        </div>
        <div>
            <a href="index.php" class="btn btn-light btn-sm me-2"><i class="fas fa-home"></i></a>
            <a href="admin.php" class="btn btn-light btn-sm"><i class="fas fa-sync"></i></a>
        </div>
    </div>
</header>

<div class="container pb-5">
    <div class="card admin-form-card p-4 mb-5">
        <div class="form-header mb-4">
            <h5><i class="fas fa-user-plus me-2"></i>Tambah Mahasiswa</h5>
        </div>
        <form method="POST" class="admin-form row g-3">
            <div class="col-md-4">
                <label>NIM (Huruf & Angka)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    <input type="text" name="nim" class="form-control" placeholder="Contoh: Z102, 9901" required>
                </div>
            </div>
            <div class="col-md-4">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Gender</label>
                <select name="gender" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Usia (Otomatis)</label>
                <input type="number" name="usia" id="usia" class="form-control" readonly placeholder="Pilih tgl lahir..." required>
            </div>
            <div class="col-12">
                <button type="submit" name="tambah" class="btn btn-gradient px-4">
                    <i class="fas fa-save me-1"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>

    <div class="card p-4 modern-table">
        <h5 class="fw-bold mb-4"><i class="fas fa-table me-2 text-primary"></i>Daftar Mahasiswa</h5>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>NIM <i class="fas fa-sort-alpha-down-alt ms-1"></i></th>
                        <th>Nama</th>
                        <th>Tanggal Lahir</th>
                        <th>Gender</th>
                        <th>Usia</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(empty($mahasiswa)): ?>
                    <tr><td colspan="7" class="text-center p-4 text-muted">Belum ada data mahasiswa yang tersimpan.</td></tr>
                <?php else: ?>
                    <?php foreach($mahasiswa as $m): ?>
                        <tr>
                            <td class="fw-bold text-primary"><?= htmlspecialchars($m['nim']) ?></td>
                            <td><?= htmlspecialchars($m['nama']) ?></td>
                            <td>
                                <span class="text-muted small">
                                    <i class="fas fa-calendar-alt me-1 text-secondary"></i>
                                    <?= date('d M Y', strtotime($m['tanggal_lahir'])) ?>
                                </span>
                            </td>
                            <td>
                                <?php if(trim($m['gender']) == 'Laki-laki'): ?>
                                    <span class="badge-male"><i class="fas fa-mars me-1"></i>Laki-laki</span>
                                <?php else: ?>
                                    <span class="badge-female"><i class="fas fa-venus me-1"></i>Perempuan</span>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge-soft"><?= $m['usia'] ?> Tahun</span></td>
                            <td class="text-muted small"><?= htmlspecialchars($m['alamat']) ?></td>
                            <td>
                                <a href="edit.php?nim=<?= $m['nim'] ?>" class="btn-edit me-2" title="Edit"><i class="fas fa-edit"></i></a>
                                <a href="?hapus=<?= $m['nim'] ?>" class="btn-delete" title="Hapus" onclick="return confirm('Hapus data NIM <?= $m['nim'] ?>?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('tanggal_lahir').addEventListener('change', function() {
        const birthDate = new Date(this.value);
        const today = new Date();
        
        if (!isNaN(birthDate)) {
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            
            // Koreksi jika bulan/tanggal belum lewat di tahun ini
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            
            document.getElementById('usia').value = age;
        }
    });
</script>

</body>
</html>