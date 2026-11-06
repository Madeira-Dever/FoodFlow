<?php

header("Content-Type: application/json; charset=utf-8");
$data = json_decode(file_get_contents("php://input"), true);
session_start();

$idUser = $_SESSION['id_user'] ?? null;
if (!$idUser) {
  http_response_code(401);
  echo json_encode([
    "error" => true,
    "message" => "Usuário não autenticado"
  ]);
  exit;
}

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
try {
  // =========================================================
  // INSERT STATUS IN REQUEST
  // =========================================================
  $sqlRequest = "INSERT INTO REQUEST
    (id_user, status)
    VALUES
    (:id_user, :status)";

  $stmtRequest = $conn->prepare($sqlRequest);

  $stmtRequest->execute([
    "id_user" => $idUser,
    "status" => "Pedido feito"
  ]);
  $idRequest = $conn->lastInsertId();

  // =========================================================
  // INSERT PRODUCT
  // =========================================================
  $sqlProduct = "INSERT INTO PRODUCT
    (id_request, name, flavor, size, description, price)
    VALUES
    (:id_request, :name, :flavor, :size, :description, :price)";

  $stmtProduct = $conn->prepare($sqlProduct);

  foreach ($data as $d) {
    $stmtProduct->execute([
      "id_request" => $idRequest,
      "name" => $d['name'],
      "flavor" => $d['flavor'],
      "size" => $d['size'],
      "description" => $d['description'],
      "price" => $d['price']
    ]);
  }

  http_response_code(200);
  echo json_encode([
    "error" => false,
    "message" => "Produto enviado",
    "data" => $data
  ]);
} catch (PDOException $err) {
  http_response_code(500);
  error_log($err->getMessage());
  echo json_encode([
    "error" => true,
    "message" => $err->getMessage()
  ]);
}