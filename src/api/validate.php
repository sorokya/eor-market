<?php

const FIVE_MINUTES = 5 * 50;

include './config.php';

$data = json_decode(file_get_contents('php://input'), true);

$name = $data['name'];
$code = $data['code'];
$token = $data['token'];

if ($token !== $GLOBALS['api_token']) {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid token']);
  exit;
}

if (strlen($name) < 3 || strlen($name) > 12) {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid username']);
  exit;
}

if (strlen($code) != 5) {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid code']);
  exit;
}

$mysqli = openConnection();

$stmt = $mysqli->prepare("SELECT `name`, `verified`, `created_at`
FROM Accounts
WHERE `name` = ?");

$stmt->bind_param("s", $name);

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row == false) {
  http_response_code(400);
  echo json_encode(['error' => 'User not found']);
  exit;
}

$verified = $row['verified'];

if ($verified) {
  http_response_code(400);
  echo json_encode(['error' => 'User already verified']);
  exit;
}

$created_at = $row['created_at'];
$now = time();
$diff = $now - strtotime($created_at);

if ($diff > FIVE_MINUTES) {
  http_response_code(400);
  echo json_encode(['error' => 'Code expired. Please register again']);
  exit;
}

if (strtoupper($code) != $row['code']) {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid code. Please double check the code']);
  exit;
}

$stmt = $mysqli->prepare("UPDATE Accounts SET `verified` = 1, updated_at = NOW() WHERE `name` = ?");
$stmt->bind_param("s", $name);
$stmt->execute();

echo json_encode(['success' => 'User verified']);
?>
