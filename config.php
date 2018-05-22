<?php
  const DB_SERVER = 'localhost';
  const DB_USERNAME = 'root';
  const DB_PASSWORD = '';
  const DB_NAME = 'quanlycongvan';
  const DB_CHARSET = 'utf8';
  const UPLOAD_PATH = 'files/';

  $connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
  if (!$connect) {
    die('ERROR: Could not connect. '.mysqli_connect_error());
  }
  $connect->set_charset(DB_CHARSET);
?>
