<?php
require_once 'authenticator.php';
require_once 'config.php';

checkAuthentication();

$ten = $mota = "";
$ten_err = $mota_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $input_ten = $_POST['ten'];
  if (empty($input_ten)) {
    $ten_err = "Please enter a name";
  } else {
    $ten = $input_ten;
  }

  $input_mota = $_POST['mota'];
  $mota = $input_mota;

  if(empty($ten_err)){
    if(isset($_POST["id"]) && !empty($_POST["id"])) {
      $sql = "UPDATE loaicongvan SET ten=?, mota=? WHERE id=?";
    } else {
      $sql = "INSERT INTO loaicongvan (ten, mota) VALUES (?, ?)";
    }

    if($stmt = mysqli_prepare($connect, $sql)){
      if(isset($_POST["id"]) && !empty($_POST["id"])) {
        mysqli_stmt_bind_param($stmt, "ssi", $param_ten, $param_mota, $param_id);
        $param_id = $_POST["id"];
      } else {
        mysqli_stmt_bind_param($stmt, "ss", $param_ten, $param_mota);
      }

      $param_ten = $ten;
      $param_mota = $mota;

      if(mysqli_stmt_execute($stmt)){
        header("location: loaicongvan.php");
        exit();
      } else{
        echo "Something went wrong. Please try again later.";
      }
    }

    mysqli_stmt_close($stmt);
  }

  mysqli_close($connect);
} else {
  if(isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);
    $sql = "SELECT * FROM loaicongvan WHERE id = ?";
    if ($stmt = mysqli_prepare($connect, $sql)) {
      mysqli_stmt_bind_param($stmt, 'i', $param_id);
      $param_id = $id;
      if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) == 1) {
          $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
          $ten = $row['ten'];
          $mota = $row['mota'];
        } else {
          header("location: error.php");
          exit();
        }
      } else{
        echo "Oops! Something went wrong. Please try again later.";
      }
    }
  }
}
?>

<?php
require_once 'common/header.php';
?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Loại công văn</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-2 col-lg-2"></div>
    <div class="col-sm-8 col-lg-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-wechat"></i> <?php echo (isset($_GET["id"]) && !empty(trim($_GET["id"]))) ? 'Chỉnh sửa Loại công văn' : 'Tạo mới Loại công văn' ?>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <div class="row">
              <div class="col-lg-12">
                <form action="loaicongvanForm.php" id="form-create-loaicongvan" method="post">
                  <?php
                    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
                      echo '<input type="hidden" name="id" value="' . $_GET['id'] . '"/>';
                    }
                  ?>
                  <div class="form-group <?php echo (!empty($ten_err)) ? 'has-error' : ''; ?>">
                    <label>Tên <span class="text-danger">*</span></label>
                    <input type="text" name="ten" class="form-control" required maxlength="100" value="<?php echo $ten ?>"/>
                    <p class="help-block"><em>The maximum number of characters allowed is <strong>100</strong></em></p>
                    <span class="help-block"><?php echo $ten_err;?></span>
                  </div>
                  <div class="form-group <?php echo (!empty($mota_err)) ? 'has-error' : ''; ?>">
                    <label>Mô tả</label>
                    <input type="text" name="mota" class="form-control" maxlength="100" value="<?php echo $mota ?>"/>
                    <span class="help-block"><?php echo $mota_err;?></span>
                  </div>
                  <div class="form-group form-actions text-right">
                    <button type="submit" name="submit" value="submit" class="btn btn-md btn-success">
                      <i class="fas fa-check fa-fw"></i><?php echo (isset($_GET["id"]) && !empty(trim($_GET["id"]))) ? 'Sửa' : 'Thêm' ?>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
require_once 'common/footer.php';
?>
