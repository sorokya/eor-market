<?php

include './config.php';

const FIVE_MINUTES = 5 * 50;

$username = $_POST['username'];
$password = $_POST['password'];

if (strlen($username) < 3 || strlen($username) > 12) {
  echo json_encode(['error' => 'Username must be between 3 and 12 characters']);
  exit;
}

$mysqli = openConnection();

$stmt = $mysqli->prepare("SELECT `name`, `verified`, `created_at`
FROM Accounts
WHERE `name` = ?");

$stmt->bind_param("s", $username);

$stmt->execute();
$result = $stmt->get_result();
$code = generateVerifyCode();
$hash = password_hash($username . $password, PASSWORD_BCRYPT);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $verified = $row['verified'];
  $created_at = $row['created_at'];

  $now = time();
  $diff = $now - strtotime($created_at);

  if ($verified == 1 || $diff < FIVE_MINUTES) {
    echo json_encode(['error' => 'Username already in use']);
    exit;
  }

  $stmt = $mysqli->prepare("UPDATE Accounts SET `password_hash` = ?, `verify_code` = ?, `created_at` = NOW() WHERE `name` = ?;");
  $stmt->bind_param("sss", $hash, $code, $username);
  $stmt->execute();
} else {
  $stmt = $mysqli->prepare("INSERT INTO Accounts (`name`, `password_hash`, `verify_code`) VALUES (?, ?, ?);");
  $stmt->bind_param("sss", $username, $hash, $code);
  $stmt->execute();
}

$_SESSION['username'] = $username;

echo json_encode(['data' => [
  'message' => 'Please verify in game by whispering !marketplace register ' . $code,
]]);

function generateVerifyCode() {
  $code = '';

  for ($i = 0; $i < 5; $i++) {
    $code .= chr(rand(65, 90));
  }

  return $code;
}

?>
