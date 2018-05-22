<?php
require_once 'authenticator.php';
checkAuthentication();
?>

<?php
if(isset($_POST["id"]) && !empty($_POST["id"])){
  require_once 'config.php';

  $sql = "DELETE FROM congvandi WHERE id = ?";

  if($stmt = mysqli_prepare($connect, $sql)){
    mysqli_stmt_bind_param($stmt, "s", $param_id);

    $param_id = trim($_POST["id"]);

    if(mysqli_stmt_execute($stmt)){
      header("location: congvandi.php");
      exit();
    } else{
      echo "Oops! Something went wrong. Please try again later.";
    }
  }

  mysqli_stmt_close($stmt);

  mysqli_close($connect);
} else {
  if(empty(trim($_GET["id"]))){
    header("location: error.php");
    exit();
  }
}
?>

<?php
require_once 'common/header.php';
?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Công văn đi</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-2 col-lg-2"></div>
    <div class="col-sm-8 col-lg-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-wechat"></i> Xoá công văn đi
        </div>
        <div class="panel-body">
          <form action="congvandiDelete.php" method="post">
            <div class="alert alert-danger fade in">
              <input type="hiddi" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
              <p>Bạn có chắc chắn muốn xoá công văn đi <?php echo trim($_GET["id"]); ?> không?</p><br>
              <p>
                <input type="submit" value="Có" class="btn btn-danger">
                <a href="congvandi.php" class="btn btn-default">Không</a>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
require_once 'common/footer.php';
?>
