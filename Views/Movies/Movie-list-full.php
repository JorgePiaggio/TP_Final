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
          
          <form action="<?php echo FRONT_ROOT?>Movie/showMoviePage" method="post">
                <div class="floating-label">
                    <input type="number" name="pass" placeholder="# Page" value="<?php if($page){echo $page;} ?>" class="floating-input fl_left pageNumber" min="1" max="1000" required>
                   
                </div>
                    <button type="submit" name="id" class="btn fl_left up2" value="">Show Movie Page</button> 
          </form>

          <form action="<?php echo FRONT_ROOT?>Genre/updateGenreList" method="post">
            <button type="submit" name="id" class="btn fl_right up4" value="">Update Genre List</button>
          </form>

        <?php  } ?>
        
         <!-- ####################################### MOVIE GALLERY ######################################################### -->
      <div id="gallery">
        <figure>
          <ul class="nospace clear">
            <?php $indice=0; ?>
            <?php foreach ($movieList as $movie){
            if($indice % 4 == 0){?>
            <li class="one_quarter first anim1 slideDown">                                       <!-- PRIMERA IMAGEN DE LA FILA -->
              <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movie->getTmdbID()?>">
              <img src="<?php echo $movie->getPoster()?>" alt=""></a>         
              <p class="p-title"><?php echo $movie->getTitle()?></p>
              <p><i class="fa-spin fa fa-star"></i><?php echo " ".$movie->getVoteAverage()?></p>
              <p><i class="fa fa-tags"></i><?php $str=""; foreach($movie->getGenreStrings() as $genre){
                                                            $str .=" ".$genre." /";}
                                                            echo substr_replace($str,"", -1); ?></p>
            </li><?php $indice++;?>
            <?php }else{ ?>
            <li class="one_quarter anim1 slideDown">                                             <!-- LAS OTRAS TRES IMAGENES DE LA FILA -->
              <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movie->getTmdbID()?>">
              <img src="<?php echo $movie->getPoster()?>" alt=""></a>
              <p class="p-title"><?php echo $movie->getTitle()?></p>
              <p><i class="fa-spin fa fa-star"></i><?php echo " ".$movie->getVoteAverage()?></p>
              <p><i class="fa fa-tags"></i><?php $str=""; foreach($movie->getGenreStrings() as $genre){
                                                            $str .=" ".$genre." /";}
                                                            echo substr_replace($str,"", -1); ?></p>
            </li><?php $indice++;?>
            <?php }} ?>
          </ul>
        </figure>
      </div>
    </div>
  </main>
</div>

