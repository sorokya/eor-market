<?php

setcookie("user", "", [
  'secure' => true,
  'httponly' => true,
  'expires' => time() - 3600,
  'sameSite' => 'Lax',
  'path' => '/',
]);

echo json_encode(['success' => true]);

?>
