<!-- Top Background Image Wrapper -->
<div class="wrapper row3 gradient">
  <h2 class="page-title">Movie List</h2>
  <main class="hoc container clear" > 
    <div class="content" > 
      
           <!-- ####################################### OPTION GENRES ######################################################### -->
           <form action="<?php echo FRONT_ROOT?>Movie/filterByGenre" method="post" class= "genreselector">
              <select name="Genres" class=" selection" onchange="this.form.submit()" id="genre">
          <?php if($actualGenre){?>
            <option value="selected" selected disabled> <?php echo $actualGenre->getName();?> </option>
            <?php } ?>
           <option value=<?php echo $allGenre->getId();?> class=" selected"> <?php echo $allGenre->getName();?> </option>
            <?php foreach($genreList as $genre) { ?>
           <option value="<?php echo $genre->getId();?>">
              <?php echo $genre->getName();?>
           </option>
            <?php } ?> 
            </select>
        </form>

           <!-- ##################################### ADMIN BUTTONS ########################################################### -->
        <?php  if($_SESSION && $_SESSION["loggedUser"]=="admin@moviepass.com"){   ?>
          
          <form action="<?php echo FRONT_ROOT?>Movie/updateMovieList" method="post">
            <td><button type="submit" name="id" class="btn fl_left up2" value="">Update Movie List</button></td> 
          </form>

          <form action="<?php echo FRONT_ROOT?>Genre/updateGenreList" method="post">
            <td><button type="submit" name="id" class="btn fl_right up2" value="">Update Genre List</button></td> 
          </form>

        <?php  } ?>
        
         <!-- ####################################### MOVIE GALLERY ######################################################### -->
      <div id="gallery">
        <figure>
          <ul class="nospace clear">
            <?php $indice=0;?>
            <?php foreach ($movieList as $movie){
            if($indice % 4 == 0){?>
            <li class="one_quarter first anim1 slideDown">                                       <!-- PRIMERA IMAGEN DE LA FILA -->
              <a href="#"><img src="<?php echo $movie->getPoster()?>" alt=""></a>         
              <p class="p-title"><?php echo $movie->getTitle()?></p>
              <p><i class="fa-spin fa fa-star"></i><?php echo " ".$movie->getVoteAverage()?></p>
              <p><i class="fa fa-tags"></i><?php echo " ".$movie->getVoteAverage()?></p>
            </li><?php $indice++;?>
            <?php }else{ ?>
            <li class="one_quarter anim1 slideDown">                                             <!-- LAS OTRAS TRES IMAGENES DE LA FILA -->
              <a href="#"><img src="<?php echo $movie->getPoster()?>" alt=""></a>
              <p class="p-title"><?php echo $movie->getTitle()?></p>
              <p><i class="fa-spin fa fa-star"></i><?php echo " ".$movie->getVoteAverage()?></p>
              <p><i class="fa fa-tags"></i><?php echo " ".$movie->getVoteAverage()?></p>
            </li><?php $indice++;?>
            <?php }} ?>
          </ul>
        </figure>
      </div>
    </div>
  </main>
</div>

