<?php
session_start();

function checkAuthentication() {
  if (!isset($_SESSION['userId'])) {
		if (isset($_COOKIES['userId']) && isset($_COOKIES['username'])) {
			$_SESSION['userId'] = $_COOKIES['userId'];
			$_SESSION['username'] = $_COOKIES['username'];
		}
	}

  if(!isset($_SESSION['userId']) || empty($_SESSION['userId'])) {
    header("location: login.php");
    exit;
  }
}

function isLogin() {
  return (isset($_SESSION['userId']) && !empty($_SESSION['userId']));
}
?>
