
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
  <div class="sidebar-brand-icon ml-3">
    <!-- <i class="fas fa-laugh-wink"></i> -->
    <img class="w-50" src="Specific/Src/Images/Logo_H_White.png" alt="">
  </div>
  <div class="sidebar-brand-text mx-3">hCloud</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
  <a class="nav-link" href="index.php?url=Home">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Accueil</span>
  </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  Interface
</div>

<?php
  function builMenu($menuArray) {
    foreach( $menuArray as $oneMenuItem) {
      //if (is_array() && (length... == 3))
      echo addMenuItem($oneMenuItem[0], $oneMenuItem[1], $oneMenuItem[2], $oneMenuItem[3]);
    }
  }
  function addMenuItem($text, $lien, $icon,$specific) {
    $uri = "url";
    if ($specific) {$uri = "p";}
    ob_start();
    ?>
      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="index.php?<?php echo $uri; ?>=<?php echo $lien; ?>">
          <i class="fas fa-fw <?php echo $icon ; ?>"></i>
          <span><?php echo $text ; ?></span>
        </a>
      </li>
    <?php
    return ob_get_clean() ;
  }
  builMenu ( $menuItems );
?>
</ul>