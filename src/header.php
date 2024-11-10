<?php

$user = isset($_COOKIE['user']) ? json_decode($_COOKIE['user']) : null;

?>

<header>
  <h1>Endless Online Market</h1>
  <div id="nav-container">
    <div id="nav-main">
      <a href="/" class="<?=$_SERVER['REQUEST_URI'] == '/' ? 'active' : ''?>">Market</a>
      <a href="about.php" class="<?=$_SERVER['REQUEST_URI'] == '/about.php' ? 'active' : ''?>">About</a>
      <? if ($user != null) { ?>
      <a href="manage.php" class="<?=$_SERVER['REQUEST_URI'] == '/manage.php' ? 'active' : ''?>">Manage</a>
      <?}?>
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