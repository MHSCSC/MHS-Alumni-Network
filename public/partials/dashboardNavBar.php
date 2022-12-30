<?php
// get current page uri		  		
$uri = $_SERVER['REQUEST_URI'];

echo "<form method=\"post\" action=\"$uri\" id=\"dashboard\">";
?>

<nav class="navbar fixed-bottom navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo $uri;?>">
      <img src="<?php echo plugin_dir_url( __FILE__ ) . "imgs/download.jpg";?>" alt="" width="30" height="24" class="d-inline-block align-text-top">
    </a>
    <a class="navbar-brand" href="<?php echo $uri . "?type=posts";?>">
      <img src="<?php echo plugin_dir_url( __FILE__ ) . "imgs/download1.jpg";?>" alt="" width="30" height="24" class="d-inline-block align-text-top">
    </a>
    <a class="navbar-brand" href="<?php echo $uri;?>">
      <img src="<?php echo plugin_dir_url( __FILE__ ) . "imgs/download2.jpg";?>" alt="" width="30" height="24" class="d-inline-block align-text-top">
    </a>
    <a class="navbar-brand" href="<?php echo $uri;?>">
      <img src="<?php echo plugin_dir_url( __FILE__ ) . "imgs/download3.jpg";?>" alt="" width="30" height="24" class="d-inline-block align-text-top">
    </a>
  </div>
</nav>
<?php
echo "</form>";
?>