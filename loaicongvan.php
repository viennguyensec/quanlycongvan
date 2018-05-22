<?php
require_once 'authenticator.php';
require_once 'common/header.php';
checkAuthentication();
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
          <i class="fa fa-wechat"></i> Loại công văn
          <div class="pull-right"> <button class="btn btn-success btn-xs" onclick="window.location='loaicongvanForm.php';"> <i class="fa fa-plus"></i> Thêm </button> </div>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table id="list-pb" class="table table-hover">
              <thead>
                <tr>
                  <th> <input type="checkbox" id="selectAll" /> <button class="btn btn-default btn-xs" onclick="mulDelete()"><i class="fas fa-trash-alt fa-fw fa-xs"></i></button> </th>
                  <th>id</th>
                  <th>Tên</th>
                  <th>Mô tả</th>
                  <th  class="text-center"><i class="fas fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                <?php
                require_once 'config.php';

                $sql = "SELECT * FROM loaicongvan";
                if ($result = mysqli_query($connect, $sql)) {
                  if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)) {
                      echo "<tr>";
                        echo '<td><input type="checkbox" name="dl" value="' . $row['id'] .'" /></td>';
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['ten'] . "</td>";
                        echo "<td>" . $row['mota'] . "</td>";
                        echo "<td class='text-center'>";
                          echo '<span class="btn-group btn-group-xs">';
                            //echo '<a href="timkiem.php?loaicongvanId='. $row['id'] .'" class="btn btn-default"><i class="fas fa-eye fa-fw fa-xs"></i></a>';
                            echo '<a href="loaicongvanForm.php?id='. $row['id'] .'&action=update" class="btn btn-default edit"><i class="fas fa-pencil-alt fa-fw fa-xs"></i></a>';
                            echo '<a href="loaicongvanDelete.php?id=' . $row['id'] . '&action=delete" class="btn btn-danger delete"><i class="fas fa-times fa-fw fa-xs"></i></a>';
                          echo '</span>';
                        echo "</td>";
                      echo "</tr>";
                    }
                  } else {
                    echo "<tr class='no-data'><td colspan='5' class='text-muted text-center'>There is no data!</td></tr>";
                  }
                } else {
                  echo "<tr class='no-data'><td colspan='5' class='text-muted text-center'>ERROR: Could not able to execute $sql. " . mysqli_error($connect) . "</td></tr>";
                }
                mysqli_close($connect);
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function(event) {
    $('#selectAll').click(function (e) {
      $('table').find('td input:checkbox[name="dl"]').prop('checked', this.checked);
    });
  });
  function mulDelete() {
    var arrayID = [];
    $('table').find('td > input:checkbox[name="dl"]').each(function(i) {
      if ($(this)[0].checked == true) {
        arrayID.push($(this)[0].value);
      }
    });
    if (arrayID.length) {
      $.post("loaicongvanMulDelete.php", {arrayID: arrayID}).done(function(data){
        if (data == "Successfully!") location.reload();
        else alert(data);
      });
    } else {
      alert("Bạn chưa chọn loại nào.");
    }
  }
</script>

<?php
require_once 'common/footer.php';
?>
