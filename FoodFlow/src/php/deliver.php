<?php

header("Content-Type: application/json; charset=utf-8");
$data = json_decode(file_get_contents("php://input"), true);

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

// =========================================================
// INSERT IN DELIVER TABLE
// =========================================================
require_once __DIR__ . "/connection.php";
try {
  $sql = "INSERT INTO DELIVER
    (id_user, id_request)
    VALUES
    (:id_user, :id_request)";

  $stmt = $conn->prepare($sql);
  $stmt->execute([
    "id_user" => $data['id_user'],
    "id_request" => $data['id_request']
  ]);

  http_response_code(201);
  echo json_encode([
    "error" => false,
    "message" => "Produtos entregues",
    "products" => $data
  ]);
} catch (PDOException $err) {
  http_response_code(500);
  error_log($err->getMessage());
  echo json_encode([
    "error" => true,
    "message" => $err->getMessage()
  ]);
}