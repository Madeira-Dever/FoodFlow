<?php

$host = "localhost";
$database = "FOODFLOW";
$user = "root";
$password = "";

try {
  $pdo = new PDO(
    "mysql:host=$host;dbname=$database;charset=utf8mb4",
    $user,
    $password
  );

  $pdo->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
  );
} catch (PDOException $err) {
  error_log($err->getMessage());
  http_response_code(500);
  echo "Error in connection";
  exit;
}