<?php
$conn = mysqli_connect("localhost", "root", "", "db_kampus");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function hitungUsia($tanggal_lahir) {
    $birthDate = new DateTime($tanggal_lahir);
    $today = new DateTime('today');
    return $birthDate->diff($today)->y;
}
?>