<div class="wrapper row1">
  <header id="header" class="clear"> 
    <div id="logo" class="fl_left">
      <h1><a href="<?php echo FRONT_ROOT?>Home/Index">MoviePass</a></h1>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a class="drop" href="#">Actions</a>
          <ul>
          <?php if($_SESSION){   ?>
    
          <?php if($_SESSION["logedUser"]=="admin@moviepass.com")  { ?>
            <!---Admin*/-->
            <li><a href="<?php echo FRONT_ROOT?>Cinema/ShowAddView">Add Cinema</a></li>
            <li><a href="<?php echo FRONT_ROOT?>Cinema/ShowListView">List Cinema</a></li>
            <li><a href="<?php echo FRONT_ROOT?>Home/Logout">Sign out</a></li>
            
          <?php }else{ ?>
            <!---User*/-->
          <li><a href="<?php echo FRONT_ROOT?>Home/ShowProfile">Profile</a></li>
          <li><a href="<?php echo FRONT_ROOT?>Home/Logout">Sign out</a></li>
          <?php }?>
          <?php } else{ ?>  
          <!---Guest*/-->
          <li><a href="<?php echo FRONT_ROOT?>Home/ShowLogin">Login</a></li>
          <li><a href="<?php echo FRONT_ROOT?>Home/ShowRegister">Register</a></li>
        
          <?php } ?>
      </ul></ul>
    </nav>
  </header>
</div>