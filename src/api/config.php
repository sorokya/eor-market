<?php

$api_token = $_ENV['API_TOKEN'];
$mysql_host = $_ENV['MYSQL_HOST'];
$mysql_user = $_ENV['MYSQL_USER'];
$mysql_password = $_ENV['MYSQL_PASSWORD'];
$mysql_database = $_ENV['MYSQL_DATABASE'];

function openConnection() {
  $mysqli = new mysqli($GLOBALS['mysql_host'], $GLOBALS['mysql_user'], $GLOBALS['mysql_password'], $GLOBALS['mysql_database']);
  return $mysqli;
}

?>
