<?php

header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . "/connection.php";
require_once __DIR__ . "/message.php";

// ==========================
// WAITER GET
// ==========================
try {
  $sql = "SELECT
      pre.id,
      pro.name,
      pro.flavor,
      pro.size,
      pro.description,
      pro.price
    FROM PREPARE AS pre
    JOIN PRODUCT AS pro
      ON pre.id_product = pro.id
  ";

  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($products);

} catch (Throwable $err) {
  error_log($err->getMessage());
  http_response_code(500);
  sendResponse(false, "Prepare unccessfully");
}