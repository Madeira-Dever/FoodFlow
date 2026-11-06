<?php

$env = parse_ini_file(__DIR__ . "/../../settings/.env");

// =========================================================
// CREATE CONNECTION WITH DATABASE
// =========================================================
try {
  $host = $env['DB_HOST'];
  $dbname = $env['DB_NAME'];
  $user = $env['DB_USER'];
  $password = $env['DB_PASSWORD'];

  $conn = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
    $user,
    $password
  );

  $conn->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
  );
} catch (PDOException $err) {
  http_response_code(500);
  error_log($err->getMessage());
  echo json_encode([
    "error" => true,
    "message" => "Erro na conexão com o banco de dados"
  ]);
  exit;
}