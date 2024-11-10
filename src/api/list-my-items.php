<?php

$user = isset($_COOKIE['user']) ? json_decode($_COOKIE['user']) : null;

if ($user == null) {
  header('Location: /');
  exit;
}

include './config.php';
include './utils/get_item_list.php';

$items = getItemList();

$mysqli = openConnection();

$stmt = $mysqli->prepare("SELECT `item_id`, `amount`, `price` FROM Offers WHERE `account_id` = ?");
$stmt->bind_param("i", $user->id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
  echo json_encode([ 'error' => 'No results' ]);
  exit;
}

$res = [];

while ($row = $result->fetch_assoc()) {
  $item = array_values(array_filter($items, function($item) use($row) {
    return $item['id'] == $row['item_id'];
  }));

  if (count($item) > 0) {
    $res[] = [
      'id' => $row['item_id'],
      'amount' => $row['amount'],
      'price' => $row['price'],
      'name' => $item[0]['name'],
    ];
  }
}

echo json_encode([
  'data' => $res
]);

?>
