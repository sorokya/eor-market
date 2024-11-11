<?php

$user = isset($_COOKIE['user']) ? json_decode($_COOKIE['user']) : null;

?>

<!DOCTYPE html>
<html>

<head>
  <title>Endless Online Market - About
  </title>
  <link rel="stylesheet" href="css/jquery-ui.min.css">
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <? include './header.php'; ?>

  <div class="about">
    <p style="text-align: center">EO Market is a peer to peer marketplace for Endless Online. It is free to use and has
      no
      ads.</p>

    <p style="text-align: center">If you would like to support the project, you can buy me a Ko-fi <a
        href="https://ko-fi.com/sorokya" target="_blank">here</a>.</p>
  </div>

  <br />

  <div class="about">
    <h3>Planned features:</h3>
    <ul style="display: table; margin: auto; text-align:left;">
      <li>Show online status of players</li>
      <li>Add buy offers in addition to sell offers</li>
      <li>View recent verified trades</li>
      <li>View price data for all traded items</li>
      <li>Leaderboard (player with most trades)</li>
    </ul>
  </div>

  <? include './footer.php'; ?>

  <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/sweetalert.min.js"></script>
  <script type="text/javascript" src="js/index.js"></script>

  <script async src="https://stats.richardleek.com/script.js"
    data-website-id="0d0dbc74-41de-4e7d-b1f2-622481b9531b"></script>
</body>

</html>
