<?php

include './config.php';

$user = isset($_COOKIE['user']) ? json_decode($_COOKIE['user']) : null;

if ($user == null) {
  echo json_encode(['error' => 'You must be logged in to add an item']);
  exit;
}

$item_id = $_POST['id'];
$price = $_POST['price'];
$amount = $_POST['amount'];

// TODO: Make sure id exists and item is not reserved
if ($item_id < 3) {
  echo json_encode(['error' => 'Invalid item']);
  exit;
}

if ($price < 1) {
  echo json_encode(['error' => 'Invalid price']);
  exit;
}

if ($amount < 1) {
  echo json_encode(['error' => 'Invalid amount']);
  exit;
}

$mysqli = openConnection();

$stmt = $mysqli->prepare("INSERT INTO Offers (`account_id`, `item_id`, `amount`, `price`) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiii", $user->id, $item_id, $amount, $price);
$stmt->execute();

echo json_encode(['success' => true]);

?>
