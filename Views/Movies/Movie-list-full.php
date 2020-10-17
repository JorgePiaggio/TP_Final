<!-- Top Background Image Wrapper -->
<div class="wrapper row3 gradient">
<h2 class="page-title">Movie List</h2>
  <main class="hoc container clear" > 
    <div class="content" > 
           <!-- ################################################################################################ -->
        <form action="<?php echo FRONT_ROOT?>Movie/UpdateMovieList" method="post">
        <?php /* if($_SESSION["loggedUser"]!="admin@moviepass.com"){  */ ?>
        <td><button type="submit" name="id" class="btn fl_left up2" value="">Update Movie List</button></td>
        <?php /* } */ ?>
         <!-- ################################################################################################ -->
      <div id="gallery">
        <figure>
          <ul class="nospace clear">
            <?php $indice=0;?>
            <?php foreach ($movieList as $movie){
            if($indice % 4 == 0){?>
            <li class="one_quarter first"><a href="#"><img src="<?php echo $movie->getPoster()?>" alt=""></a></li><?php $indice++;?>
            <?php }else{ ?>
            <li class="one_quarter"><a href="#"><img src="<?php echo $movie->getPoster()?>" alt=""></a></li><?php $indice++;?>
            <?php }} ?>
          </ul>
        </figure>
      </div>
    </div>
  </main>
</div>


