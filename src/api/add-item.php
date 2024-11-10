<?php

include './config.php';
include './utils/get_item_list.php';

$user = isset($_COOKIE['user']) ? json_decode($_COOKIE['user']) : null;

if ($user == null) {
  echo json_encode(['error' => 'You must be logged in to add an item']);
  exit;
}

$item_id = $_POST['id'];
$price = intval($_POST['price']);
$amount = intval($_POST['amount']);

$items = getItemList();

$item = array_values(array_filter($items, function($item) use ($item_id) {
    return $item['id'] == $item_id;
}));

// TODO: Make sure id exists and item is not reserved
if ($item_id < 3 || $item == null) {
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

$stmt = $mysqli->prepare("SELECT `item_id` FROM Offers WHERE `created_by` = ? AND `item_id` = ?");
$stmt->bind_param("ii", $user->id, $item_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  echo json_encode(['error' => 'You have already added this item. Please update your existing offer']);
  exit;
}

$stmt = $mysqli->prepare("INSERT INTO Offers (`created_by`, `item_id`, `amount`, `price`) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiii", $user->id, $item_id, $amount, $price);
$stmt->execute();

echo json_encode(['success' => true]);

?>
