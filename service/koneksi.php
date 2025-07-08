<?php
$host = 'localhost';
$user = 'u663997152_PamerBynomnom';
$pass = 'Nom12345678@'; // kosong untuk Laragon
$db   = 'u663997152_nomnom';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
