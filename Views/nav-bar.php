<div class="wrapper row1">
  <header id="header" class="clear"> 
    <div id="logo" class="fl_left">
      <a href="<?php echo FRONT_ROOT?>Home/index">
        <svg width="500" height="61" viewBox="400 0 500 61" >
            <text x="450%" y="190%" width="100%" height="100%" transform="scale(.3, .4)" fill="transparent" text-anchor="middle">Moviepass</text>
        </svg>
      </a>
    </div>
    <nav id="mainav" class="hoc fl_right">
        <!----------------- MENU GENERAL -----------------------> 
      <ul class="clear">         
        <li><a href="<?php echo FRONT_ROOT?>Show/showBillboard">Billboard</a></li>
        <li><a href="<?php echo FRONT_ROOT?>Movie/showAllMovies">Movies</a></li>
        <li><a href="<?php echo FRONT_ROOT?>Cinema/showAllCinemas">Cinemas</a></li>


        
          <!----------------- MENU USUARIO (ICONO DEL CHABONCITO)-----------------------> 
          <?php if(isset($_SESSION["loggedUser"])){?>
        <li class="active"><a class="drop" href="#"><img class="icon" src="<?php echo IMG_PATH?>/icons/profile-user-logged.png"></a>
          <?php }else{ ?>
        <li class="active"><a class="drop" href="#"><img class="icon" src="<?php echo IMG_PATH?>/icons/profile-user-guest3.png"></a>
          <?php }?>

          <ul>
            <?php if(isset($_SESSION["loggedUser"])){   ?>
            <?php if($_SESSION["loggedUser"]=="admin@moviepass.com" || $_SESSION["role"] == 1)  { ?>
              
            <!---Admin-->
            <li class="active"><a>Cinemas</a>
              <ul>
                <li><a href="<?php echo FRONT_ROOT?>Cinema/showAddView">Add</a></li>
                <li><a href="<?php echo FRONT_ROOT?>Cinema/showListView">List / Edit</a></li>
              </ul>
            </li>
            <li class="active"><a>Rooms</a>
              <ul>
                <li><a href="<?php echo FRONT_ROOT?>Room/showAddRoom">Add</a></li>
                <li><a href="<?php echo FRONT_ROOT?>Room/showSelectCinema">List / Edit</a></li>
              </ul>
            </li>
            <li class="active"><a>Movies</a>
              <ul>
                <li><a href="<?php echo FRONT_ROOT?>Movie/showMoviePage">Add</a></li>
                <li><a href="<?php echo FRONT_ROOT?>Movie/showManageCatalogue">List / Edit</a></li>
              </ul>
            </li>
            <li class="active"><a>Shows</a>
              <ul>
                <li><a href="<?php echo FRONT_ROOT?>Show/showAddView">Add</a></li>
                <li><a href="<?php echo FRONT_ROOT?>Show/showListView">List / Edit</a></li>
              </ul>
            </li>
             <li class="active"><a>Users</a>
              <ul>
                <li><a href="<?php echo FRONT_ROOT?>User/showSelectUser">Change Role</a></li>
                <li><a href="<?php echo FRONT_ROOT?>User/showUserReviews">Reviews</a></li>
              </ul>
            <li><a href="<?php echo FRONT_ROOT?>User/logout">Sign out</a></li>
            <?php }else{ ?>

            <!---User-->
            <li><a href="<?php echo FRONT_ROOT?>User/showProfile">Profile</a></li>
            <li><a href="<?php echo FRONT_ROOT?>User/logout">Sign out</a></li>
            <?php }?>
            <?php } else{ ?>  
      
            <!---Guest-->
            <li><a href="<?php echo FRONT_ROOT?>User/showLogin">Login</a></li>
            <li><a href="<?php echo FRONT_ROOT?>User/showRegister">Register</a></li>
            <?php } ?>
          </ul>
        </li>
        <li><a class="" href="#"><img src=""></a></li><!--- boton ivisible para acomodar-->

      </ul>
    </nav>
  </header>
</div>