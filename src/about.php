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
  <? include 'header.php'; ?>

  <p style="text-align: center">EO Market is a peer to peer marketplace for Endless Online. It is free to use and has no
    ads.</p>

  <p style="text-align: center">If you would like to support the project, you can buy me a Ko-fi <a
      href="https://ko-fi.com/sorokya" target="_blank">here</a>.</p>

  <footer>
    <a href="https://endless-online.com">Endless Online</a> &copy; Copyright 2024 <a
      href="https://www.vult-r.com/">Vult-r</a>
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    Powered by <a href="https://eor-api.exile-studios.com/">EOR API</a>
  </footer>

  <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/sweetalert.min.js"></script>
  <script type="text/javascript" src="js/index.js"></script>
</body>

</html>
