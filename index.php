<?php 
require 'config.php';

$search = $_GET['cari'] ?? '';
$query = "SELECT * FROM mahasiswa 
          WHERE nama LIKE '%$search%' 
          ORDER BY nim DESC";
$mahasiswa = query($query);

// Statistik
$total = mysqli_fetch_assoc(mysqli_query($conn, 
        "SELECT COUNT(*) as jml FROM mahasiswa"))['jml'];

$lk = mysqli_fetch_assoc(mysqli_query($conn, 
        "SELECT COUNT(*) as jml FROM mahasiswa WHERE gender='Laki-laki'"))['jml'];

$pr = mysqli_fetch_assoc(mysqli_query($conn, 
        "SELECT COUNT(*) as jml FROM mahasiswa WHERE gender='Perempuan'"))['jml'];

$persen_lk = $total > 0 ? round(($lk / $total) * 100) : 0;
$persen_pr = $total > 0 ? round(($pr / $total) * 100) : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIMAS - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<header class="main-header mb-5">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-graduation-cap me-2"></i>SIMAS</h2>
            <small>Sistem Informasi Manajemen Mahasiswa</small>
        </div>
        <div>
            <a href="index.php" class="btn btn-light btn-sm me-2">
                <i class="fas fa-home"></i>
            </a>
            <a href="admin.php" class="btn btn-light btn-sm">
                <i class="fas fa-user-shield"></i>
            </a>
        </div>
    </div>
</header>

<div class="container pb-5">

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card card-stats stats-primary">
                <small>Total Mahasiswa</small>
                <h2><?= $total ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stats stats-info">
                <small>Laki-laki</small>
                <h2><?= $lk ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stats stats-danger">
                <small>Perempuan</small>
                <h2><?= $pr ?></h2>
            </div>
        </div>
    </div>

    <div class="card chart-card mb-5">
        <h5 class="fw-bold mb-4">
            <i class="fas fa-chart-pie me-2 text-primary"></i>
            Statistik Mahasiswa Berdasarkan Gender
        </h5>

        <div class="row align-items-center">

            <div class="col-md-6 text-center">
                <div class="chart-container">
                    <canvas id="genderChart"></canvas>
                    <div class="chart-center-text">
                        <h4><?= $total ?></h4>
                        <small>Total</small>
                    </div>
                </div>
            </div>

            <div class="col-md-6">

                <div class="gender-box male-box mb-4">
                    <div class="d-flex justify-content-between">
                        <strong>Laki-laki</strong>
                        <span><?= $persen_lk ?>%</span>
                    </div>
                    <div class="progress mt-2">
                        <div class="progress-bar bg-primary"
                            style="width: <?= $persen_lk ?>%">
                        </div>
                    </div>
                    <small><?= $lk ?> Mahasiswa</small>
                </div>

                <div class="gender-box female-box">
                    <div class="d-flex justify-content-between">
                        <strong>Perempuan</strong>
                        <span><?= $persen_pr ?>%</span>
                    </div>
                    <div class="progress mt-2">
                        <div class="progress-bar bg-danger"
                            style="width: <?= $persen_pr ?>%">
                        </div>
                    </div>
                    <small><?= $pr ?> Mahasiswa</small>
                </div>

            </div>
        </div>
    </div>

    <div class="card p-4 modern-table">
        
        <div class="row mb-4">
            <div class="col-md-6">
                <h5 class="fw-bold m-0 text-dark">Daftar Mahasiswa</h5>
            </div>
            <div class="col-md-6">
                <form action="" method="GET" class="d-flex justify-content-end">
                    <div class="input-group" style="max-width: 300px;">
                        <input type="text" 
                               name="cari" 
                               class="form-control" 
                               placeholder="Cari nama mahasiswa..." 
                               value="<?= htmlspecialchars($search) ?>">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        <?php if($search): ?>
                            <a href="index.php" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Tanggal Lahir</th>
                        <th>Gender</th>
                        <th>Usia</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(count($mahasiswa) > 0): ?>
                    <?php foreach($mahasiswa as $m): ?>
                        <tr>
                            <td class="fw-bold text-primary"><?= $m['nim'] ?></td>
                            <td><?= $m['nama'] ?></td>
                            <td><?= date('d M Y', strtotime($m['tanggal_lahir'])) ?></td>
                            <td>
                                <span class="badge <?= $m['gender']=='Laki-laki'?'badge-male':'badge-female' ?>">
                                    <?= $m['gender'] ?>
                                </span>
                            </td>
                            <td><?= $m['usia'] ?> Tahun</td>
                            <td><?= $m['alamat'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            Data tidak ditemukan untuk nama "<strong><?= htmlspecialchars($search) ?></strong>"
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
const ctx = document.getElementById('genderChart');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Laki-laki', 'Perempuan'],
        datasets: [{
            data: [<?= $lk ?>, <?= $pr ?>],
            backgroundColor: ['#0284c7', '#be185d'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '75%',
        plugins: {
            legend: { display: false }
        }
    }
});
</script>

</body>
</html>