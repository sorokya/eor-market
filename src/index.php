<!DOCTYPE html>
<html>

<?php

$user = isset($_COOKIE['user']) ? json_decode($_COOKIE['user']) : null;

?>

<head>
  <title>Endless Online Market</title>
  <link rel="stylesheet" href="css/jquery-ui.min.css">
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <? include './header.php'; ?>
  <form id="search">
    <input type="text" id="search-bar" placeholder="Search for items" disabled />
    <button id="btn-add" class="<?=$user == null ? 'hidden' : ''?>">Add Item</button>
    <br />
  </form>

  <div id="results">
  </div>

  <? include './footer.php'; ?>

  <div id="dialog-add" style="display: none">
    <form id="dialog-item-search">
      <input type="text" placeholder="Item Name" name="item-name">
      <div id="add-item-search-results">
      </div>
    </form>
    <form id="dialog-item-add" class="hidden">
      <div id="add-item-preview">
        <img src="#" />
        <span class="item-name"></span>
      </div>
      <div>
        <div>
          <label for="add-item-amount">Amount</label><br />
          <input type="number" name="amount" id="add-item-amount">
        </div>
        <div>
          <label for="add-item-price">Price</label><br />
          <input type="number" name="price" id="add-item-price">
        </div>
        <br />
        <button type="button">Cancel</button>
        <button type="submit">Add Item</button>
      </div>
    </form>
  </div>

  <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/sweetalert.min.js"></script>
  <script type="text/javascript" src="js/index.js"></script>

  <script async src="https://stats.richardleek.com/script.js"
    data-website-id="0d0dbc74-41de-4e7d-b1f2-622481b9531b"></script>
</body>

</html>
