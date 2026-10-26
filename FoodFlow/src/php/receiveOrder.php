<?php

header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . "/connection.php";
require_once __DIR__ . "/message.php";

// ==========================
// SEND TO CHEF
// ==========================
try {
  $sql = "SELECT * FROM PRODUCT";

  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($products);

} catch (PDOException $err) {
  error_log($err->getMessage());
  http_response_code(500);
  sendResponse(false, "Error searching products");
}