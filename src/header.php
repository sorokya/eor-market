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
          <button type="button" class="signup-link">Signup</button>
        </form>
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

    <div id="signup-success" class="hidden">
      Your account has been registered! Please sent the below whisper to Marketplace in game to verify your account:
      <pre></pre>
      <button name="copy">Copy to clipboard</button>
      <button name="close">Close</button>
    </div>

    <button type="submit">Signup</button>
  </form>
</div>
