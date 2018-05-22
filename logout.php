<?php
  session_start();
  if (isset($_COOKIES['userId']) && isset($_COOKIES['username'])) {
    setcookie('userId', '',time() - 3600);
    setcookie('username', '',time() - 3600);
  }
  $_SESSION = array();
  session_destroy();
  header("location: login.php");
  exit;
 ?>
