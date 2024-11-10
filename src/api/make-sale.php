<?php

include './config.php';
include './utils/get_item_list.php';

$user = isset($_COOKIE['user']) ? json_decode($_COOKIE['user']) : null;

if ($user == null) {
  echo json_encode(['error' => 'You must be logged in to update an item']);
  exit;
}

$item_id = $_POST['id'];
$buyer = $_POST['buyer'];
$total = intval($_POST['total']);
$amount = intval($_POST['amount']);

if ($item_id < 3) {
  echo json_encode(['error' => 'Invalid item']);
  exit;
}

if ($total < 1) {
  echo json_encode(['error' => 'Invalid total']);
  exit;
}

if ($amount < 1) {
  echo json_encode(['error' => 'Invalid amount']);
  exit;
}

if (strlen($buyer) < 3 || strlen($buyer) > 12) {
  echo json_encode(['error' => 'Invalid buyer']);
  exit;
}

$mysqli = openConnection();

$stmt = $mysqli->prepare("UPDATE Offers SET `amount` = `amount` - ?, `updated_at` = NOW() WHERE `created_by` = ? AND `item_id` = ?");
$stmt->bind_param("iii", $amount, $user->id, $item_id);
$stmt->execute();

$stmt = $mysqli->prepare("INSERT INTO Sales (`item_id`, `amount`, `total`, `buyer`, `created_by`) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iiisi", $item_id, $amount, $total, $buyer, $user->id);
$stmt->execute();

$mysqli->query("DELETE FROM Offers WHERE `amount` < 1");

echo json_encode(['success' => true]);

?>
