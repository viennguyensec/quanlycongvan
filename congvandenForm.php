<?php
require_once 'authenticator.php';
require_once 'config.php';

checkAuthentication();

$userId = $kyhieu = $ngaybanhanh = $coquanbanhanhId = $loaiId = $ngaynhan = $nguoinhan = $nguoiky = $nguoiduyet = $noidung = $file = "";
$userId_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $input_userId = trim($_POST["userId"]);
  if (empty($input_userId)) {
    $userId_err = "Please enter userId .";
  } else {
    $userId = $input_userId;
  }

  if(empty($userId_err)){
    $kyhieu = $_POST['kyhieu'];
    $ngaybanhanh = $_POST['ngaybanhanh'];
    $coquanbanhanhId = $_POST['coquanbanhanhId'];
    $loaiId = $_POST['loaiId'];
		$ngaynhan = $_POST['ngaynhan'];
    $nguoinhan = $_POST['nguoinhan'];
    $nguoiky = $_POST['nguoiky'];
    $nguoiduyet = $_POST['nguoiduyet'];
		$noidung = $_POST['noidung'];


    if (!empty($filename = $_FILES['file'])) {
      $filename = $_FILES['file']['name'];
      if (!empty($filename)) {
        $file = UPLOAD_PATH . $filename;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
          //echo ("file moved");
        } else {
          //echo ("file not moved");
        }
      }
      else {
        $file = '';
      }
    } else if (isset($_POST['file'])){
      $file = $_POST['file'];
    }
    echo $file;

    if(isset($_POST["id"]) && !empty($_POST["id"])) {
      $sql = "UPDATE congvanden SET kyhieu=?, ngaybanhanh=?, coquanbanhanhId=?, loaiId=?, ngaynhan=?, nguoinhan=?, nguoiky=?, nguoiduyet=?, noidung=?, file=? WHERE id=?";
    } else {
      $sql = "INSERT INTO congvanden (userId, kyhieu, ngaybanhanh, coquanbanhanhId, loaiId, ngaynhan, nguoinhan, nguoiky, nguoiduyet, noidung, file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    }

    if($stmt = mysqli_prepare($connect, $sql)){
      if(isset($_POST["id"]) && !empty($_POST["id"])) {
        mysqli_stmt_bind_param($stmt, "ssiissssssi", $param_kyhieu, $param_ngaybanhanh, $param_coquanbanhanhId, $param_loaiId, $param_ngaynhan, $param_nguoinhan, $param_nguoiky, $param_nguoiduyet, $param_noidung, $param_file, $param_id);
        $param_id = $_POST["id"];
      } else {
        mysqli_stmt_bind_param($stmt, "issiissssss", $param_userId, $param_kyhieu, $param_ngaybanhanh, $param_coquanbanhanhId, $param_loaiId, $param_ngaynhan, $param_nguoinhan, $param_nguoiky, $param_nguoiduyet, $param_noidung, $param_file);
      }

      $param_userId = $_SESSION['userId'];
      $param_kyhieu = $kyhieu;
      $param_ngaybanhanh = $ngaybanhanh;
      $param_coquanbanhanhId = $coquanbanhanhId;
      $param_loaiId = $loaiId;
      $param_ngaynhan = $ngaynhan;
      $param_nguoinhan = $nguoinhan;
      $param_nguoiky = $nguoiky;
      $param_nguoiduyet = $nguoiduyet;
      $param_noidung = $noidung;
      $param_file = $file;

      if(mysqli_stmt_execute($stmt)){
        header("location: congvanden.php");
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
    $sql = "SELECT * FROM congvanden WHERE id = ?";
    if ($stmt = mysqli_prepare($connect, $sql)) {
      mysqli_stmt_bind_param($stmt, 'i', $param_id);
      $param_id = $id;
      if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) == 1) {
          $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
          $id = $row['id'];
          $kyhieu = $row['kyhieu'];
          $ngaybanhanh = $row['ngaybanhanh'];
          $coquanbanhanhId = $row['coquanbanhanhId'];
          $loaiId = $row['loaiId'];
      		$ngaynhan = $row['ngaynhan'];
          $nguoinhan = $row['nguoinhan'];
          $nguoiky = $row['nguoiky'];
          $nguoiduyet = $row['nguoiduyet'];
      		$noidung = $row['noidung'];
          $file = $row['file'];
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
      <h1 class="page-header">Công văn đến</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-2 col-lg-2"></div>
    <div class="col-sm-8 col-lg-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-wechat"></i> <?php echo (isset($_GET["id"]) && !empty(trim($_GET["id"]))) ? 'Chỉnh sửa Công văn đến' : 'Tạo mới Công văn đến' ?>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <div class="row">
              <div class="col-lg-12">
                <form action="congvandenForm.php" id="form-create-congvanden" method="post" enctype="multipart/form-data">
                  <?php
                    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
                      echo '<input type="hidden" name="id" value="' . $_GET['id'] . '"/>';
                    }
                    echo '<input type="hidden" name="userId" value="' . $_SESSION['userId'] . '"/>';
                  ?>
                  <div class="form-group">
                    <label>Ký hiệu</label>
                    <input type="text" name="kyhieu" class="form-control" maxlength="50" value='<?php echo $kyhieu ?>' />
                  </div>
                  <div class="form-group">
                    <label>Ngày ban hành</label>
                    <input type="date" name="ngaybanhanh" class="form-control" value='<?php echo $ngaybanhanh ?>' />
                  </div>
                  <div class="form-group <?php echo (!empty($coquanbanhanhId_err)) ? 'has-error' : ''; ?>">
                    <label>Cơ quan ban hành</label>
                    <select name="coquanbanhanhId" class="form-control" >
                      <?php
                        require_once 'config.php';

                        $sql = "SELECT * FROM coquanbanhanh";
                        if ($result = mysqli_query($connect, $sql)) {
                          if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                              echo "<option value='" . $row['id'] . "'>" . $row['ten'] . "</option>";
                            }
                          }
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group <?php echo (!empty($loaicongvanId_err)) ? 'has-error' : ''; ?>">
                    <label>Loại</label>
                    <select name="loaiId" class="form-control" >
                      <?php
                        require_once 'config.php';

                        $sql = "SELECT * FROM loaicongvan";
                        if ($result = mysqli_query($connect, $sql)) {
                          if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                              echo "<option value='" . $row['id'] . "'>" . $row['ten'] . "</option>";
                            }
                          }
                        }
                        mysqli_close($connect);
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Ngày nhận</label>
                    <input type="date" name="ngaynhan" class="form-control" value='<?php echo $ngaynhan ?>' />
                  </div>
                  <div class="form-group">
                    <label>Người nhận</label>
                    <input type="text" name="nguoinhan" class="form-control" value='<?php echo $nguoinhan ?>' />
                  </div>
                  <div class="form-group">
                    <label>Người ký</label>
                    <input type="text" name="nguoiky" class="form-control" value='<?php echo $nguoiky ?>' />
                  </div>
                  <div class="form-group">
                    <label>Người duyệt</label>
                    <input type="text" name="nguoiduyet" class="form-control" value='<?php echo $nguoiduyet ?>' />
                  </div>
                  <div class="form-group">
                    <label>Nội dung</label>
                    <textarea class="form-control" name="noidung" rows="4"><?php echo $noidung ?></textarea>
                  </div>
                  <div class="form-group">
                    <label>File</label>
                    <p class=""><?php echo $file ?></p>
                    <input type="file" name="file" class="form-control" value="<?php echo $file ?>"/>
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
