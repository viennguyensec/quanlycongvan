<?php
require_once 'authenticator.php';

if(isset($_POST["arrayID"]) && isLogin()){
  require_once 'config.php';

  $values = join("', '", $_POST["arrayID"]);
  $attr = "( '" . $values . "' )";
  $sql = "DELETE FROM loaicongvan WHERE id in " . $attr;

  if(mysqli_query($connect, $sql)){
    echo "Successfully!";
  } else{
    echo "Oops! Something went wrong. Please try again later.";
  }

  mysqli_close($connect);
}
?>
