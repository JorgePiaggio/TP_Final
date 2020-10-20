<div class="wrapper row1">
  <header id="header" class="clear"> 
    <div id="logo" class="fl_left">
      <h1 class="logo"><a href="<?php echo FRONT_ROOT?>Home/index"><img src="<?php echo IMG_PATH?>/icons/moviepass.png" alt=""></a></h1>
    </div>
    <nav id="mainav" class="fl_right">
      <!----------------- MENU GENERAL -----------------------> 
      <ul class="clear">         
        <li><a href="<?php echo FRONT_ROOT?>Movie/showAllMovies">Movies</a></li>
        <?php if($_SESSION){?>
      
      <!----------------- MENU USUARIO -----------------------> 
        <li class="active"><a class="drop" href="#"><img class="icon" src="<?php echo IMG_PATH?>/icons/profile-user-logged.png"></a>
        <?php }else{ ?>
        <li class="active"><a class="drop" href="#"><img class="icon" src="<?php echo IMG_PATH?>/icons/profile-user-guest.png"></a>
        <?php }?>
          <ul>
          <?php if($_SESSION){   ?>
          <?php if($_SESSION["loggedUser"]=="admin@moviepass.com")  { ?>
            
            <!---Admin-->
            <li><a href="<?php echo FRONT_ROOT?>Cinema/showAddView">Add Cinema</a></li>
            <li><a href="<?php echo FRONT_ROOT?>Cinema/showListView">List Cinema</a></li>
            <li><a href="<?php echo FRONT_ROOT?>Room/showAddRoom">Add Room</a></li>
            <li><a href="<?php echo FRONT_ROOT?>Room/showSelectCinema">List Room</a></li>
            <li><a href="<?php echo FRONT_ROOT?>Client/logout">Sign out</a></li>
            <?php }else{ ?>

            <!---User-->
            <li><a href="<?php echo FRONT_ROOT?>Client/showProfile">Profile</a></li>
            <li><a href="<?php echo FRONT_ROOT?>Client/logout">Sign out</a></li>
            <?php }?>
            <?php } else{ ?>  
      
            <!---Guest-->
            <li><a href="<?php echo FRONT_ROOT?>Client/showLogin">Login</a></li>
            <li><a href="<?php echo FRONT_ROOT?>Client/showRegister">Register</a></li>
            <?php } ?>
      </ul></ul>
    </nav>
  </header>
</div>