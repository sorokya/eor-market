<?php

function getItemOffers($itemId) {
  $mysqli = openConnection();

  $stmt = $mysqli->prepare("SELECT `item_id`, `name`, `amount`, `price` FROM Offers INNER JOIN Accounts	ON Accounts.`id` = Offers.`created_by` WHERE `item_id` = ?  ORDER BY 1 ASC, 4 DESC");
  $stmt->bind_param("i", $itemId);
  $stmt->execute();

  $result = $stmt->get_result();

  $res = [];

  while ($row = $result->fetch_assoc()) {
    $res[] = $row;
  }

  return $res;
}

?>
