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
  <header>
    <h1>Endless Online Market</h1>
    <div id="nav-container">
      <div id="nav-main">
        <a href="/" class="active">Market</a>
        <a href="javascript:;">About</a>
      </div>
      <div id="nav-profile">
        <div class="<?=$user == null ? 'hidden' : ''?>">
          <p>Hello, <strong>
              <?=$user->name?>
            </strong> not
            <?=$user->name?>? <a id="btn-logout" href="javascript:;">Logout</a>
          </p>
        </div>
        <div class="<?=$user != null ? 'hidden' : ''?>">
          <form class="login-form">
            <input type="text" placeholder="Username" name="username" />
            <input type="password" placeholder="Password" name="password" />
            <button type="submit">Login</button>
          </form>
          <a href="javascript:;" class="signup-link">Sign Up</a>
        </div>
      </div>
    </div>
  </header>

  <form id="search">
    <input type="text" id="search-bar" placeholder="Search for items" />
    <label for="item-type">
      Item type:
    </label>
    <select id="select-item-type">
      <option value="all">All types</option>
      <? include './partials/item_type_options.php' ?>
    </select>
    <button id="btn-add" class="<?=$user == null ? 'hidden' : ''?>">Add Item</button>
  </form>

  <div id="results">
    <div class="item">
      <strong class="item-name"><a href="/items/81">Silver Fish</a></strong>
      <img src="https://eor-api.exile-studios.com/api/graphics/25/489" />
      <p><strong>Available:</strong>&nbsp;10,000</p>
      <p><strong>Price:</strong>&nbsp;20</p>
    </div>

    <div class="item">
      <strong class="item-name"><a href="/items/82">Fox Fur</a></strong>
      <img src="https://eor-api.exile-studios.com/api/graphics/25/359" />
      <p><strong>Available:</strong>&nbsp;106</p>
      <p><strong>Price:</strong>&nbsp;10</p>
    </div>
  </div>

  <footer>
    <a href="https://endless-online.com">Endless Online</a> &copy; Copyright 2024 <a
      href="https://www.vult-r.com/">Vult-r</a>
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    Powered by <a href="https://eor-api.exile-studios.com/">EOR API</a>
  </footer>

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

  <div id="dialog-signup" style="display: none">
    <form>
      <div>
        <label for="signup-username">Username</label>
        <input type="text" id="signup-username" name="username" required>
      </div>

      <div>
        <label for="signup-password">Password</label>
        <input type="password" id="signup-password" name="password" required>
      </div>

      <div>
        <label for="signup-confirm-password">Confirm Password</label>
        <input type="password" id="signup-confirm-password" name="confirm-password" required>
      </div>

      <br />

      <p id="signup-error" class="hidden"></p>
      <p id="signup-success" class="hidden"></p>

      <button type="submit">Signup</button>
    </form>
  </div>

  <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/sweetalert.min.js"></script>
  <script type="text/javascript" src="js/index.js"></script>
</body>

</html>
