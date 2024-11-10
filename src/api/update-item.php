<?php

include './config.php';
include './utils/get_item_list.php';

$user = isset($_COOKIE['user']) ? json_decode($_COOKIE['user']) : null;

if ($user == null) {
  echo json_encode(['error' => 'You must be logged in to update an item']);
  exit;
}

$item_id = $_POST['id'];
$price = intval($_POST['price']);
$amount = intval($_POST['amount']);

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

$stmt = $mysqli->prepare("UPDATE Offers SET `amount` = ?, `price` = ? WHERE `account_id` = ? AND `item_id` = ?");
$stmt->bind_param("iiii", $amount, $price, $user->id, $item_id);
$stmt->execute();

echo json_encode(['success' => true]);

?>
