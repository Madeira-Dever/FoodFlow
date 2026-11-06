<?php

header("Content-Type: application/json; charset=utf-8");

// =========================================================
// VALIDATIONS
// =========================================================
if ($_SERVER['REQUEST_METHOD'] !== "GET") {
  http_response_code(405);
  echo json_encode([
    "error" => true,
    "message" => "Método inválido"
  ]);
  exit;
}

// =========================================================
// GET ORDERS FROM DELIVER
// =========================================================
require_once __DIR__ . "/connection.php";
try {
  $sql = "SELECT
      DELIVER.id AS id_deliver,
      DELIVER.id_user,
      DELIVER.id_request,
      PRODUCT.id AS id_product,
      PRODUCT.name,
      PRODUCT.flavor,
      PRODUCT.size,
      PRODUCT.description,
      PRODUCT.price
    FROM DELIVER
    JOIN REQUEST
      ON DELIVER.id_request = REQUEST.id
    JOIN USER
      ON DELIVER.id_user = USER.id
    JOIN PRODUCT
      ON PRODUCT.id_request = REQUEST.id";

  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

  http_response_code(200);
  echo json_encode([
    "error" => false,
    "message" => "Pedidos rcebidos",
    "orders" => $orders
  ]);
} catch (PDOException $err) {
  http_response_code(500);
  error_log($err->getMessage());
  echo json_encode([
    "error" => true,
    "message" => $err->getMessage()
  ]);
}