<?php

include './config.php';

if (!isset($_GET['token']) || $_GET['token'] !== $GLOBALS['api_token']) {
  header('Content-Type: application/json');
  http_response_code(400);
  echo json_encode(['error' => 'Invalid token']);
  exit;
}

if (!isset($_GET['id'])) {
  header('Content-Type: application/json');
  http_response_code(400);
  echo json_encode(['error' => 'Missing sale id']);
  exit;
}

if (!isset($_GET['name'])) {
  header('Content-Type: application/json');
  http_response_code(400);
  echo json_encode(['error' => 'Missing buyer name']);
  exit;
}

$id = intval($_GET['id']);
$name = $_GET['name'];

$mysqli = openConnection();

$stmt = $mysqli->prepare("SELECT `buyer`, `verified` FROM Sales WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row == false) {
  header('Content-Type: application/json');
  http_response_code(400);
  echo json_encode(['error' => 'Sale not found']);
  exit;
}

if ($row['verified'] == 1) {
  header('Content-Type: application/json');
  http_response_code(400);
  echo json_encode(['error' => 'Sale already verified']);
  exit;
}

if (strtolower($row['buyer']) != strtolower($name)) {
  header('Content-Type: application/json');
  http_response_code(400);
  echo json_encode(['error' => 'You are not the buyer of this sale']);
  exit;
}

$stmt = $mysqli->prepare("UPDATE Sales SET `verified` = 1, updated_at = NOW() WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header('Content-Type: application/json');
echo json_encode(['success' => 'Sale marked as verified']);

?>
