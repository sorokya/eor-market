<?php

include './utils/get_item_list.php';

$items = getItemList();

echo json_encode([ 'data' => $items ]);

?>
