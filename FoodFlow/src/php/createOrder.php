<?php

header("Content-Type: application/json; charset=utf-8");
$data = json_decode(file_get_contents("php://input"), true);
$method = $_SERVER["REQUEST_METHOD"];

require_once __DIR__ . "/message.php";
require_once __DIR__ . "/connection.php";

if ($method !== "POST") {
  http_response_code(405);
  sendResponse(false, "Wrong method");
}

if (!is_array($data) || empty($data)) {
  http_response_code(400);
  sendResponse(false, "Invalid product list");
}

try {
  // ==========================
  // INSERT REQUEST
  // ==========================
  $sqlRequest = "INSERT INTO REQUEST 
    (status)
    VALUES 
    (:status)"
  ;

  $stmtRequest = $pdo->prepare($sqlRequest);
  $stmtRequest->execute([
    "status" => "Order placed"
  ]);

  $idRequest = $pdo->lastInsertId();

  // ==========================
  // INSERT PRODUCT
  // ==========================
  $sqlProduct = "INSERT INTO PRODUCT
    (name, flavor, size, description, price)
    VALUES 
    (:name, :flavor, :size, :description, :price)"
  ;

  $stmtProduct = $pdo->prepare($sqlProduct);

  foreach ($data as $product) {
    if (
      !isset(
        $product["name"],
        $product["size"],
        $product["flavor"],
        $product["description"],
        $product["price"]
      ) ||
      !is_numeric($product["price"]) ||
      $product["price"] < 0
    ) {
      http_response_code(400);
      sendResponse(false, "Invalid product");
    }

    $stmtProduct->execute([
      "name" => $product["name"],
      "flavor" => $product["flavor"],
      "size" => $product["size"],
      "description" => $product["description"],
      "price" => $product["price"]
    ]);
  }
  sendResponse(true, "Inserted successfully");

} catch (PDOException $err) {
  error_log($err->getMessage());
  http_response_code(500);
  sendResponse(false, "Error inserting products and request");
}