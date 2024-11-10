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

$id = intval($_GET['id']);

$mysqli = openConnection();

$stmt = $mysqli->prepare("UPDATE Sales SET `notified` = 1, updated_at = NOW() WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header('Content-Type: application/json');
echo json_encode(['success' => 'Sale marked as notified']);

?>
