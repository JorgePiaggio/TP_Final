<!-- Top Background Image Wrapper -->
<div class="wrapper row3 gradient">
  <h2 class="page-title">Movie List</h2>
  <main class="hoc container clear" > 
    <div class="content" > 
           <!-- ################################################################################################ -->
        <?php  if($_SESSION && $_SESSION["loggedUser"]=="admin@moviepass.com"){   ?>
          
          <form action="<?php echo FRONT_ROOT?>Movie/updateMovieList" method="post">
            <td><button type="submit" name="id" class="btn fl_left up2" value="">Update Movie List</button></td> 
          </form>

          <form action="<?php echo FRONT_ROOT?>Genre/updateGenreList" method="post">
            <td><button type="submit" name="id" class="btn fl_left" value="">Update Genre List</button></td> 
          </form>

        <?php  } ?>
         <!-- ################################################################################################ -->
        <form action="<?php echo FRONT_ROOT?>Movie/filterByGenre" method="post"><select name="Genres" onchange="this.form.submit()" id="genre">
          <option value="Genres" selected disabled> Genres </option>
          <?php foreach($genreList as $genre) { ?>
              <option value="<?php echo $genre->getId();?>">
              <?php echo $genre->getName();?>
              </option>
          <?php } ?> 
            </select>
        </form>
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

