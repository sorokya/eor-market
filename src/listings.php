<?php

require './api/config.php';
require './api/utils/get_item_list.php';
require './api/utils/get_item_offers.php';

$user = isset($_COOKIE['user']) ? json_decode($_COOKIE['user']) : null;

$item_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($item_id == null) {
  header('Location: /');
  exit;
}

$items = getItemList();

$item = array_values(array_filter($items, function($item) use ($item_id) {
  return $item['id'] == $item_id;
}));


if (count($item) == 0) {
  header('Location: /');
  exit;
}

$item = $item[0];

$offers = getItemOffers($item_id);

?>

<!DOCTYPE html>
<html>

<head>
  <title>Endless Online Market -
    <?=$item['name']?>
  </title>
  <link rel="stylesheet" href="css/jquery-ui.min.css">
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <? include './header.php'; ?>

  <table id="item-offers">
    <thead>
      <tr>
        <th>Seller</th>
        <th>Amount</th>
        <th>Price per item</th>
        <th>Total</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <?foreach ($offers as $offer) { ?>
      <tr>
        <td>
          <?=$offer['name']?>
        </td>
        <td>
          <?=$offer['amount']?>
        </td>
        <td>
          <?=$offer['price']?>
        </td>
        <td>
          <?=$offer['price'] * $offer['amount']?>
        </td>
        <td>
          <button
            onClick="buyItem(<?=$item_id?>, '<?=$offer['name']?>', <?=$offer['price']?>, <?=$offer['amount']?>)">Buy</button>
        </td>
      </tr>
      <? } ?>
    </tbody>
  </table>

  <div id="dialog-buy" style="display: none">
    <label>Amount</label><br />
    <input name="amount" type="range" min="1" step="1" />
    <pre></pre>
    <button>Copy to clipboard</button>
  </div>

  <? include './footer.php'; ?>

  <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/sweetalert.min.js"></script>
  <script type="text/javascript" src="js/index.js"></script>
</body>

</html>
