<?php

$user = isset($_COOKIE['user']) ? json_decode($_COOKIE['user']) : null;

if ($user == null) {
  header('Location: /');
  exit;
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Endless Online Market</title>
  <link rel="stylesheet" href="css/jquery-ui.min.css">
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <? include './header.php'; ?>

  <div id="results">
  </div>

  <? include './footer.php'; ?>

  <div id="dialog-update" style="display: none">
    <div id="add-item-preview">
      <img src="#" />
      <span class="item-name"></span>
    </div>
    <div>
      <form id="form-make-sale">
        <fieldset>
          <legend>Sell Item</legend>
          <em>Note: Buyer will be asked to confirm the sale in order for it to effect marketplace
            statistics..</em><br /><br />

          <label>Buyer name</label><br />
          <input type="text" name="buy-name" /><br />
          <label>Amount</label><br />
          <input type="text" name="buy-amount" /><br />
          <label>Total</label><br />
          <input type="number" name="buy-total" /><br /><br />
          <button id="btn-make-sale">Make Sale</button>
        </fieldset>
      </form>
      <form id="form-update-item">
        <fieldset>
          <legend>Update Item</legend>
          <em>Note: Updates the current amount and price of the item. Will not effect marketplace
            statistics.</em><br /><br />

          <label>Amount</label><br />
          <input type="text" name="amount" /><br />
          <label>Price</label><br />
          <input type="number" name="price" /><br /><br />
          <button id="btn-update-item">Update</button>
          <button id="btn-delete-item">Delete</button>
        </fieldset>
      </form>
    </div>
  </div>

  <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/sweetalert.min.js"></script>
  <script type="text/javascript" src="js/index.js"></script>
</body>

</html>
