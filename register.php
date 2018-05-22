<?php
  //Include config file
  require_once 'config.php';

  $firstname = "";
  $lastname = "";
  $username = "";
  $password = "";
  $confirm_password = "";
  $username_err = $password_err = $confirm_password_err = "";


  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);

    //Validate username
    if(empty(trim($_POST["username"]))){
      $username_err = "Please enter a username.";
    } else {
      $sql = 'SELECT username FROM user WHERE username = ?';
      if ($stmt = mysqli_prepare($connect, $sql)) {
        $username_param = trim($_POST['username']);
        mysqli_stmt_bind_param($stmt, 's', $username_param);
        if (mysqli_stmt_execute($stmt)) {
          mysqli_stmt_store_result($stmt);
          if (mysqli_stmt_num_rows($stmt) == 1) {
            $username = trim($_POST["username"]);
            $username_err = "this username is already exist";
          } else {
            $username = trim($_POST["username"]);
          }
        }
      } else {
        echo "Oops! Something went wrong. Please try again.";
      }
      mysqli_stmt_close($stmt);
    }

    //Validate password
    if (empty(trim($_POST['password']))) {
      $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST['password'])) < 6) {
      $password_err = "Password must have atleast 6 characters.";
    } else {
      $password = trim($_POST['password']);
    }

    //Validate confirm Password
    if (empty(trim($_POST['confirm_password']))) {
      $confirm_password_err = "Please confirm password.";
    } else {
      $confirm_password = trim($_POST['confirm_password']);
      if ($password != $confirm_password) {
        $confirm_password_err = "Password did not match.";
      }
    }

    //Check input errors before inserting in Database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
      $sql = "INSERT INTO user(username, password, firstname, lastname) VALUES (?, ?, ?, ?)";

      if($stmt = mysqli_prepare($connect, $sql)) {
        $username_param = $username;
        $password_param = password_hash($password, PASSWORD_DEFAULT);
        $firstname_param = $firstname;
        $lastname_param = $lastname;
        mysqli_stmt_bind_param($stmt, 'ssss', $username_param, $password_param, $firstname_param, $lastname_param);
        if (mysqli_stmt_execute($stmt)) {
          header("location: login.php");
        } else {
          echo "Something went wrong. Please try again later.";
        }
      }
      mysqli_stmt_close($stmt);
    }
  }
  mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
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
              <h3 class="panel-title">Register</h3>
            </div>
            <div class="panel-body">
              <form action="register.php" method="post">
                <div class="form-group">
                  <label>Firstname</label>
                  <input type="text" name="firstname"class="form-control" value="<?php echo $firstname; ?>">
                </div>
                <div class="form-group">
                  <label>Lastname</label>
                  <input type="text" name="lastname"class="form-control" value="<?php echo $lastname; ?>">
                </div>
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                  <label>Username</label>
                  <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                  <span class="help-block"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                  <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                  <label>Confirm Password</label>
                  <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                  <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group form-acions text-right">
                  <input type="reset" class="btn btn-default" value="Reset">
                  <input type="submit" class="btn btn-primary" value="Submit">
                </div>
                <p>Already have an account? <a href="login.php">Login here</a>.</p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
</html>
