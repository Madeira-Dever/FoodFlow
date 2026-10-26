<?php

function sendResponse(
  bool $success,
  string $message,
  mixed $data = null
): void {
  echo json_encode([
    "success" => $success,
    "message" => $message,
    "data" => $data
  ]);

  exit;
}