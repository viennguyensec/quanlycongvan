<?php
require_once 'authenticator.php';
?>

<?php
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
  require_once 'config.php';

  $sql = "SELECT * FROM congvanden WHERE id = ?";

  if($stmt = mysqli_prepare($connect, $sql)){
    mysqli_stmt_bind_param($stmt, "i", $param_id);

    $param_id = trim($_GET["id"]);

    if(mysqli_stmt_execute($stmt)){
      $result = mysqli_stmt_get_result($stmt);

      if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
      } else{
        header("location: error.php");
        exit();
      }

    } else{
      echo "Oops! Something went wrong. Please try again later.";
    }
  }
  mysqli_stmt_close($stmt);
  mysqli_close($connect);
} else{
  header("location: error.php");
  exit();
}
?>

<?php
require_once 'common/header.php';
?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Công văn đến</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-2 col-lg-2"></div>
    <div class="col-sm-8 col-lg-8">
      <div id="view-post" class="panel panel-default">
        <div dir='auto' class="panel-heading">
          <div class="pull-right">
            <?php if (isLogin()) echo '<a href="congvandenForm.php?id='. $row['id'] .'&action=update" class="btn btn-default edit"><i class="fas fa-pencil-alt fa-fw"></i></a>'; ?>
            <?php if (isLogin()) echo '<a href="congvandenDelete.php?id=' . $row['id'] . '&action=delete" class="btn btn-danger delete"><i class="fas fa-times fa-fw"></i></a>'; ?>
          </div>
        	<h5><?php echo $row["kyhieu"]; ?></h5>
        </div>

        <div class="panel-body">
        	<div class="row">
        		<div class="col-lg-12">
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <th>id</th>
                    <td><?php echo $row["id"]; ?></td>
                  </tr>
                  <tr>
                    <th>Ký hiệu</th>
                    <td><?php echo $row["kyhieu"]; ?></td>
                  </tr>
                  <tr>
                    <th>Ngày ban hành</th>
                    <td><?php echo $row["ngaybanhanh"]; ?></td>
                  </tr>
                  <tr>
                    <th>Cơ quan ban hành</th>
                    <td><?php echo $row["coquanbanhanhId"]; ?></td>
                  </tr>
                  <tr>
                    <th>Loại</th>
                    <td><?php echo $row["loaiId"]; ?></td>
                  </tr>
                  <tr>
                    <th>Ngày nhận</th>
                    <td><?php echo $row["ngaynhan"]; ?></td>
                  </tr>
                  <tr>
                    <th>Người nhận</th>
                    <td><?php echo $row["nguoinhan"]; ?></td>
                  </tr>
                  <tr>
                    <th>Người ký</th>
                    <td><?php echo $row["nguoiky"]; ?></td>
                  </tr>
                  <tr>
                    <th>Người duyệt</th>
                    <td><?php echo $row["nguoiduyet"]; ?></td>
                  </tr>
                  <tr>
                    <th>Nội dung</th>
                    <td><?php echo $row["noidung"]; ?></td>
                  </tr>
                  <tr>
                    <th>File</th>
                    <td><?php echo "<a href='" . $row['file'] . "'>" . $row['file'] . "</a>" ?></td>
                  </tr>
                </tbody>
              </table>
              <p><a href="congvanden.php" class="btn btn-primary">Back</a></p>
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
