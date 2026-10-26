<?php

header("Content-Type: application/json; charset=utf-8");
$product = json_decode(file_get_contents("php://input"), true);
require_once __DIR__ . "/connection.php";
require_once __DIR__ . "/message.php";

try {
    if (!is_array($product) || !isset($product["id"])) {
        http_response_code(400);
        sendResponse(false, "Invalid product data");
        exit;
    }

    $sql = "SELECT id
        FROM `PREPARE`
        WHERE id_product = :id_product"
    ;

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "id_product" => $product["id"]
    ]);

    if ($stmt->fetch()) {
        sendResponse(true, "Product already prepared");
        exit;
    }

    $sql = "INSERT INTO PREPARE
        (id_product)
        VALUES 
        (:id_product)"
    ;

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "id_product" => $product["id"]
    ]);

    sendResponse(true, "Prepare successfully");

} catch (Throwable $err) {
    error_log($err->getMessage());
    http_response_code(500);
    sendResponse(false, "Prepare unsuccessfully");
}