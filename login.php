<?php
  require_once 'config.php';

  $userId = $username = $password = "";
  $username_err = $password_err = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST['username']))) {
      $username_err = "Please enter username.";
    } else {
      $username = trim($_POST['username']);
    }

    if (empty(trim($_POST['password']))) {
      $password_err = "Please enter password.";
    } else {
      $password = trim($_POST['password']);
    }

    if (empty($username_err) && empty($password_err)) {
      $sql = "SELECT id, username, password FROM user WHERE username = ?";
      if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $username);
      }
      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
          mysqli_stmt_bind_result($stmt, $userId, $username, $hashed_password);
          if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($password, $hashed_password)) {
              session_start();
              $_SESSION['userId'] = $userId;
              $_SESSION['username'] = $username;
              header("location: congvanden.php");
            } else {
              $password_err = "The password you entered was not valid.";
            }
          }
        } else {
          $username_err = "No account found with that username.";
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
      mysqli_stmt_close($stmt);
    }
  }
  mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>Login</title>
  <link rel="stylesheet" href="./css/bootstrap.css"/>
  <style type="text/css">
    body {
      font: 14px sans-serif;
    }
    .panel-login {
      margin-top: 25%;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default panel-login">
          <div class="panel-heading">
            <h3 class="panel-title">Login</h3>
          </div>
          <div class="panel-body">
            <form action="login.php" method="POST">
              <div class="form-group <?php echo empty($username_err)?'':'has-error'?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>"/>
                <span class="help-block"><?php echo $username_err; ?></span>
              </div>
              <div class="form-group <?php echo empty($password_err)?'':'has-error'?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control"/>
                <span class="help-block"><?php echo $password_err; ?></span>
              </div>
              <div class="form-group form-acions text-right">
                <input type="submit" class="btn btn-primary" value="Login"/>
              </div>
              <p>Don't have an account? <a href="register.php">Sign up</a>.</p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
