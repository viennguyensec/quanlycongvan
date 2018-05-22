<?php
require_once 'authenticator.php';
?>

<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>

  </div>

  <ul class="nav navbar-top-links navbar-right">
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Hello,<strong><?php if (isLogin()) echo htmlspecialchars($_SESSION['username']); else echo 'Guest'; ?></strong> <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
      </a>
      <ul class="dropdown-menu dropdown-user">
        <?php
          if (isLogin()) {
            echo '<li><a href="logout.php"><i class="fa fa-sign-out-alt fa-fw"></i> Logout</a></li>';
          } else {
            echo '<li><a href="login.php"><i class="fa fa-sign-in-alt fa-fw"></i> Login</a></li>';
          }
        ?>
      </ul>
    </li>
  </ul>


  <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
      <ul class="nav" id="side-menu">
        <li>
          <a href="congvanden.php" class="<?php echo ($_SERVER['PHP_SELF'] == '/quanLyCV/congvanden.php') ? 'active' : ''; ?>"><i class="fas fa-box-open fa-fw mr-5"></i>Công văn đến</a>
        </li>
        <li>
          <a href="congvandi.php?type=sent" class="<?php echo ($_SERVER['PHP_SELF'] == '/quanLyCV/congvandi.php') ? 'active' : ''; ?>"><i class="far fa-share-square fa-fw mr-5"></i>Công văn đi</a>
        </li>
        <li>
          <a href="coquanbanhanh.php" class="<?php echo ($_SERVER['PHP_SELF'] == '/quanLyCV/coquanbanhanh.php') ? 'active' : ''; ?>"><i class="fas fa-cubes fa-fw mr-5"></i>Cơ quan ban hành</a>
        </li>
        <li>
          <a href="loaicongvan.php" class="<?php echo ($_SERVER['PHP_SELF'] == '/quanLyCV/loaicongvan.php') ? 'active' : ''; ?>"><i class="fas fa-list-alt fa-fw mr-5"></i>Loại công văn</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
