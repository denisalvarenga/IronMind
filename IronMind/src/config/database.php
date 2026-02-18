<?php

$host = "localhost";
$dbname = "ironmind";
$user = "root";
$pass = "";

/* ===== CONEXÃO PDO (já existente) ===== */
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );
} catch (PDOException $e) {
    die("Erro na conexão PDO: " . $e->getMessage());
}

/* ===== CONEXÃO MYSQLI (nova) ===== */
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão MySQLi: " . $conn->connect_error);
}