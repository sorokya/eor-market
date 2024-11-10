<?php

include './config.php';
include './utils/get_item_list.php';

if (!isset($_GET['token']) || $_GET['token'] !== $GLOBALS['api_token']) {
  header('Content-Type: application/json');
  http_response_code(400);
  echo json_encode(['error' => 'Invalid token']);
  exit;
}

$mysqli = openConnection();

$result = $mysqli->query("SELECT `Sales`.`id`, `item_id`, `amount`, `total`, `buyer`, `name` FROM Sales INNER JOIN Accounts ON Accounts.`id` = Sales.`created_by` WHERE Sales.`verified` = 0 AND Sales.`notified` = 0 ORDER BY 1 ASC");

$res = [];

$items = getItemList();

while ($row = $result->fetch_assoc()) {
  $item = array_values(array_filter($items, function($item) use($row) {
    return $item['id'] == $row['item_id'];
  }));

  if (count($item) == 0) {
    continue;
  }

  $res[] = [
    'id' => $row['id'],
    'item_name' => $item[0]['name'],
    'buyer' => $row['buyer'],
    'seller' => $row['name'],
    'amount' => $row['amount'],
    'total' => $row['total'],
  ];
}

header('Content-Type: application/json');
echo json_encode($res);

?>
