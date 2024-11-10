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
  <? include 'header.php'; ?>
  <div id="results">
  </div>

  <footer>
    <a href="https://endless-online.com">Endless Online</a> &copy; Copyright 2024 <a
      href="https://www.vult-r.com/">Vult-r</a>
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    Powered by <a href="https://eor-api.exile-studios.com/">EOR API</a>
  </footer>

  <div id="dialog-update" style="display: none">
    <form>
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
        <button type="button" id="btn-remove-item">Remove</button>
        <button type="submit">Update</button>
      </div>
    </form>
  </div>

  <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/sweetalert.min.js"></script>
  <script type="text/javascript" src="js/index.js"></script>
</body>

</html>
