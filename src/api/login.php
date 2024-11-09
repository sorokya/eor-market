<?php

include './config.php';

const FIVE_MINUTES = 5 * 50;

$username = trim($_POST['username']);
$password = trim($_POST['password']);

if (strlen($username) < 3 || strlen($username) > 12) {
  echo json_encode(['error' => 'Username must be between 3 and 12 characters']);
  exit;
}

if (strlen($password) == 0) {
  echo json_encode(['error' => 'Password is required']);
  exit;
}

$mysqli = openConnection();

$stmt = $mysqli->prepare("SELECT `id`, `name`, `verified`, `created_at`, `password_hash` FROM Accounts WHERE `name` = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
  password_verify($password, "\$2y\$10\$PtAV4cVL0VEOZRcwBWMqp.IfAlUHIrjjpTQ2IVKdOvd3RlmJTerf6");
  echo json_encode(['error' => 'Invalid username or password']);
  exit;
}

$row = $result->fetch_assoc();

if (!password_verify($username . $password, $row['password_hash'])) {
  echo json_encode(['error' => 'Invalid username or password']);
  exit;
}

if ($row['verified'] == 0) {
  $now = time();
  $diff = $now - strtotime($row['created_at']);

  if ($diff < FIVE_MINUTES) {
    $diff = FIVE_MINUTES - $diff;
    $minutes = floor($diff / 60);
    $seconds = $diff % 60;
    echo json_encode(['error' => 'Please verify your account or wait ' . $minutes . ' minutes and ' . $seconds . ' seconds and signup again']);
    exit;
  } else {
    echo json_encode(['error' => 'Account not verified. Please signup again.']);
    exit;
  }
}

setcookie("user", json_encode([
  'id' => $row['id'],
  'name' => $username,
]), [
  'secure' => true,
  'httponly' => true,
  'expires' => time() + 60 * 20,
  'sameSite' => 'Lax',
  'path' => '/',
]);

echo json_encode(['success' => true]);

?>
