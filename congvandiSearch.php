<?php
require_once 'authenticator.php';
require_once 'config.php';
checkAuthentication();

if(isset($_REQUEST['cbid']) && isset($_REQUEST['cbKyhieu']) && isset($_REQUEST['cbFile']) && isset($_REQUEST['keyword'])){
	$userId = $_SESSION['userId'];
  $cbid = $_REQUEST['cbid'];
  $cbKyhieu = $_REQUEST['cbKyhieu'];
  $cbFile = $_REQUEST['cbFile'];
  $keyword = $_REQUEST['keyword'];
  $count = 0;

  $sql = "SELECT * FROM congvandi WHERE ";

  if ($cbid == 'true') {
    $sql = $sql . " id LIKE '%" . $keyword . "%'";
    $count++;
  }
  if ($cbKyhieu == 'true') {
    if ($count == 0) $sql = $sql . " kyhieu LIKE '%" . $keyword . "%'";
    else $sql = $sql . " OR kyhieu LIKE '%" . $keyword . "%'";
    $count++;
  }
  if ($cbFile == 'true') {
    if ($count == 0) $sql = $sql . " file LIKE '%" . $keyword . "%'";
    else $sql = $sql . " OR file LIKE '%" . $keyword . "%'";
    $count++;
  }
  if ($count == 0) $sql = $sql . " userId = '$userId'";
  else $sql = $sql . " AND userId = '$userId'";


  if($result = mysqli_query($connect, $sql)){

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_array($result)) {
				echo "<tr>";
					echo '<td><input type="checkbox" name="dl" value="' . $row['id'] .'" /></td>';
					echo "<td>" . $row['id'] . "</td>";
					echo "<td>" . $row['kyhieu'] . "</td>";
					echo "<td>" . $row['ngaybanhanh'] . "</td>";
					echo "<td>" . $row['noinhan'] . "</td>";
					$sql2 = "SELECT * FROM loaicongvan WHERE id = ?";
					if ($stmt2 = mysqli_prepare($connect, $sql2)) {
						mysqli_stmt_bind_param($stmt2, 'i', $param_loaiId);
						$param_loaiId = $row['loaiId'];
						if (mysqli_stmt_execute($stmt2)) {
							$result2 = mysqli_stmt_get_result($stmt2);
							if (mysqli_num_rows($result2) == 1) {
								$row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
								echo "<td>" . $row2['ten'] . "</td>";
							} else {
								echo "<td>" . $row['loaiId'] . "</td>";
							}
						}
					}
					echo "<td>" . $row['nguoigui'] . "</td>";
					echo "<td>" . $row['nguoiky'] . "</td>";
					echo "<td>" . $row['nguoiduyet'] . "</td>";
					echo "<td><a href='" . $row['file'] . "'>" . $row['file'] . "</a></td>";
					echo "<td class='text-center'>";
						echo '<span class="btn-group btn-group-xs btn-gr-wrapper">';
							echo '<a href="congvandiDetail.php?id='. $row['id'] .'&action=viewDetail" class="btn btn-default"><i class="fas fa-eye fa-fw fa-xs"></i></a>';
							echo '<a href="congvandiForm.php?id='. $row['id'] .'&action=update" class="btn btn-default edit"><i class="fas fa-pencil-alt fa-fw fa-xs"></i></a>';
							echo '<a href="congvandiDelete.php?id=' . $row['id'] . '&action=delete" class="btn btn-danger delete"><i class="fas fa-times fa-fw fa-xs"></i></a>';
						echo '</span>';
					echo "</td>";
				echo "</tr>";
      }
    } else{
      echo "<tr class='no-data'><td colspan='5' class='text-muted text-center'>No matches found</td></tr>";
    }
  } else{
    echo "<tr class='no-data'><td colspan='5' class='text-muted text-center'>ERROR: Could not able to execute $sql. " . mysqli_error($connect) . "</td></tr>";
  }
}

mysqli_close($connect);
?>
