<?php

include './config.php';

$user = isset($_COOKIE['user']) ? json_decode($_COOKIE['user']) : null;

if ($user == null) {
  echo json_encode(['error' => 'You must be logged in to delete an item']);
  exit;
}

$item_id = $_POST['id'];

if ($item_id < 3) {
  echo json_encode(['error' => 'Invalid item']);
  exit;
}

$mysqli = openConnection();

$stmt = $mysqli->prepare("DELETE FROM Offers WHERE `created_by` = ? AND `item_id` = ?");
$stmt->bind_param("ii", $user->id, $item_id);
$stmt->execute();

echo json_encode(['success' => true]);

?>
