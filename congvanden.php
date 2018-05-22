<?php
require_once 'authenticator.php';
require_once 'common/header.php';
?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Công văn đến</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-12 col-lg-12">
      <div class="panel-group">
        <div class="panel panel-default">
          <div class="panel-heading panel-search">
            <a data-toggle="collapse" href="#collapse" style="display: block;">Search</a>
          </div>
          <div id="collapse" class="panel-collapse collapse panel-body">
            <form action="#" id="form-search-congvanden" name="searchForm" method="post">
              <div class="form-group">
                <label class="checkbox-inline"><input type="checkbox" name="cbid">ID</label>
                <label class="checkbox-inline"><input type="checkbox" name="cbKyhieu" checked>Ký hiệu</label>
                <label class="checkbox-inline"><input type="checkbox" name="cbFile">Tên file</label>
              </div>
              <div class="form-group">
                <label>Keyword</label>
                <input type="text" name="keyword" class="form-control" maxlength="200" />
              </div>
              <div class="form-group form-actions text-right">
                <button type="submit" name="submit" value="submit" class="btn btn-md btn-primary" >
                  <i class="fas fa-search fa-fw"></i>Search
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-wechat"></i> Công văn đến
          <div class="pull-right"> <button class="btn btn-success btn-xs" onclick="window.location='congvandenForm.php';"> <i class="fa fa-plus"></i> Thêm </button> </div>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table id="list-pb" class="table table-hover">
              <thead>
                <tr>
                  <th class="selectall-wrapper"> <input type="checkbox" id="selectAll" /> <button class="btn btn-default btn-xs" onclick="mulDelete()"><i class="fas fa-trash-alt fa-fw fa-xs"></i></button> </th>
                  <th>ID</th>
                  <th>Ký hiệu</th>
                  <th>Ngày ban hành</th>
                  <th>Cơ quan ban hành</th>
                  <th>Loại</th>
                  <th>Ngày nhận</th>
                  <th>Người nhận</th>
                  <th>Người ký</th>
                  <th>Người duyệt</th>
                  <th>File</th>
                  <th  class="text-center"><i class="fas fa-cog"></i></th>
                </tr>
              </thead>
              <tbody id="myTbody">
                <?php
                require_once 'config.php';

                $sql = "SELECT * FROM congvanden";

                if ($stmt = mysqli_prepare($connect, $sql)) {
                  if (mysqli_stmt_execute($stmt)) {
                    $result = mysqli_stmt_get_result($stmt);
                    if (mysqli_num_rows($result) > 0) {
                      while($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                          echo '<td><input type="checkbox" name="dl" value="' . $row['id'] .'" /></td>';
                          echo "<td>" . $row['id'] . "</td>";
                          echo "<td>" . $row['kyhieu'] . "</td>";
                          echo "<td>" . $row['ngaybanhanh'] . "</td>";
                          $sql1 = "SELECT * FROM coquanbanhanh WHERE id = ?";
                          if ($stmt1 = mysqli_prepare($connect, $sql1)) {
                            mysqli_stmt_bind_param($stmt1, 'i', $param_coquanbanhanhId);
                            $param_coquanbanhanhId = $row['coquanbanhanhId'];
                            if (mysqli_stmt_execute($stmt1)) {
                              $result1 = mysqli_stmt_get_result($stmt1);
                              if (mysqli_num_rows($result1) == 1) {
                                $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                                echo "<td>" . $row1['ten'] . "</td>";
                              } else {
                                echo "<td>" . $row['coquanbanhanhId'] . "</td>";
                              }
                            }
                          }
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
                          echo "<td>" . $row['ngaynhan'] . "</td>";
                          echo "<td>" . $row['nguoinhan'] . "</td>";
                          echo "<td>" . $row['nguoiky'] . "</td>";
                          echo "<td>" . $row['nguoiduyet'] . "</td>";
                          echo "<td><a href='" . $row['file'] . "'>" . $row['file'] . "</a></td>";
                          echo "<td class='text-center'>";
                            echo '<span class="btn-group btn-group-xs btn-gr-wrapper">';
                              echo '<a href="congvandenDetail.php?id='. $row['id'] .'&action=viewDetail" class="btn btn-default"><i class="fas fa-eye fa-fw fa-xs"></i></a>';
                              echo '<a href="congvandenForm.php?id='. $row['id'] .'&action=update" class="btn btn-default edit"><i class="fas fa-pencil-alt fa-fw fa-xs"></i></a>';
                              echo '<a href="congvandenDelete.php?id=' . $row['id'] . '&action=delete" class="btn btn-danger delete"><i class="fas fa-times fa-fw fa-xs"></i></a>';
                            echo '</span>';
                          echo "</td>";
                        echo "</tr>";
                      }
                    } else {
                      echo "<tr class='no-data'><td colspan='12' class='text-muted text-center'>There is no data!</td></tr>";
                    }
                  } else {
                    echo "<tr class='no-data'><td colspan='12' class='text-muted text-center'>ERROR: Could not able to execute $sql. " . mysqli_error($connect) . "</td></tr>";
                  }
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
  document.searchForm.submit.addEventListener("click", function(event){
    event.preventDefault();

    var cbid = document.searchForm.cbid.checked;
    var cbKyhieu = document.searchForm.cbKyhieu.checked;
    var cbFile = document.searchForm.cbFile.checked;
    var keyword = document.searchForm.keyword.value;
    // var diachi = document.searchForm.diachi.checked;
    var params = {
      cbid: cbid,
      cbKyhieu: cbKyhieu,
      cbFile: cbFile,
      keyword: keyword
    }
    $.get("congvandenSearch.php", params).done(function(data){
      document.getElementById('myTbody').innerHTML = data;
    });
  });
</script>

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
      $.post("congvandenMulDelete.php", {arrayID: arrayID}).done(function(data){
        if (data == "Successfully!") location.reload();
      });
    } else {
      alert("Bạn chưa chọn phòng ban nào.");
    }
  }
</script>

<?php
require_once 'common/footer.php';
?>
