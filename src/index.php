<!DOCTYPE html>
<html>

<?php

$username = $_COOKIE['user'] ?? null;

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
        <div class="<?=$username == null ? 'hidden' : ''?>">
          <p>Hello, <strong>
              <?=$username?>
            </strong> not
            <?=$username?>? <a id="btn-logout" href="javascript:;">Logout</a>
          </p>
        </div>
        <div class="<?=$username != null ? 'hidden' : ''?>">
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
      <option value="0">Static</option>
      <option value="1">General</option>
      <option value="2">Money</option>
      <option value="3">Potion</option>
      <option value="4">Teleport</option>
      <option value="5">Transformation</option>
      <option value="6">EXP Reward</option>
      <option value="7">Skill Book</option>
      <option value="8">Reserved</option>
      <option value="9">Key</option>
      <option value="10">Weapon</option>
      <option value="11">Shield</option>
      <option value="12">Clothing</option>
      <option value="13">Hat</option>
      <option value="14">Boots</option>
      <option value="15">Gloves</option>
      <option value="16">Accessory</option>
      <option value="17">Belt</option>
      <option value="18">Necklace</option>
      <option value="19">Ring</option>
      <option value="20">Bracelet</option>
      <option value="21">Bracer</option>
      <option value="22">Costume</option>
      <option value="23">Costume Hat</option>
      <option value="24">Wings</option>
      <option value="25">Buddy</option>
      <option value="26">Buddy 2</option>
      <option value="27">Torch</option>
      <option value="28">Beverage</option>
      <option value="29">Effect</option>
      <option value="30">Hairdye</option>
      <option value="31">Hairtool</option>
      <option value="32">Cure</option>
      <option value="33">Title</option>
      <option value="34">Visual Document</option>
      <option value="35">Audio Document</option>
      <option value="36">Transport Ticket</option>
      <option value="37">Fireworks</option>
      <option value="38">Explosive</option>
      <option value="39">Buff</option>
      <option value="40">Debuff</option>
    </select>
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

  <div id="dialog-signup" class="hidden">
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
  </div>

  <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/sweetalert.min.js"></script>
  <script type="text/javascript" src="js/index.js"></script>
</body>

</html>
