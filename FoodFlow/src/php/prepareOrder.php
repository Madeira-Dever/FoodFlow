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

require_once __DIR__ . "/connection.php";
// =========================================================
// INSERT IN PREPARE
// =========================================================
try {
  $sql = "SELECT id FROM PREPARE
    WHERE id_product = :id_product";

  $stmt = $conn->prepare($sql);
  $stmt->execute(["id_product" => $data['id']]);

  if ($stmt->fetch()) {
    http_response_code(403);
    echo json_encode([
      "error" => true,
      "message" => "Produto já preparado"
    ]);
    exit;
  }

  $sql = "INSERT INTO PREPARE (id_product)
    VALUES (:id_product)";

  $stmt = $conn->prepare($sql);
  $stmt->execute(["id_product" => $data['id']]);

  http_response_code(201);
  echo json_encode([
    "error" => false,
    "message" => "Preparo concluido"
  ]);
} catch (PDOException $err) {
  http_response_code(500);
  error_log($err->getMessage());
  echo json_encode([
    "error" => true,
    "message" => $err->getMessage()
  ]);
}