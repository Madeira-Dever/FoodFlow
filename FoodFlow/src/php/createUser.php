<?php

header("Content-Type: application/json; charset=utf-8");
$data = json_decode(file_get_contents("php://input"), true);
session_start();

// =========================================================
// VALIDATIONS
// =========================================================
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
  http_response_code(405);
  echo json_encode([
    "error" => true,
    "message" => "Método inválido"
  ]);
  exit;
}

if (!is_array($data) || empty($data)) {
  http_response_code(400);
  echo json_encode([
    "error" => true,
    "message" => "Dados inválidos"
  ]);
  exit;
}

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo json_encode([
    "error" => true,
    "message" => "Formato de email inválido"
  ]);
  exit;
}

if (strlen($password) < 6) {
  http_response_code(400);
  echo json_encode([
    "error" => true,
    "message" => "A senha deve ter 6 caracteres"
  ]);
  exit;
}

// =========================================================
// CREATE USER ACCOUNT
// =========================================================
require_once __DIR__ . "/connection.php";
try {
  $sql = "INSERT INTO USER
    (email, password)
    VALUES
    (:email, :password)";

  $stmt = $conn->prepare($sql);
  $stmt->execute([
    "email" => $email,
    "password" => password_hash($password, PASSWORD_DEFAULT)
  ]);

  $_SESSION['id_user'] = $conn->lastInsertId();

  http_response_code(201);
  echo json_encode([
    "error" => false,
    "message" => "Usuário criado"
  ]);
} catch (PDOException $err) {
  http_response_code(500);
  error_log($err->getMessage());
  echo json_encode([
    "error" => true,
    "message" => $err->getMessage()
  ]);
}