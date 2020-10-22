<div class="bgded overlay gradient" style="background-image:url('https:\/\/image.tmdb.org\/t\/p\/w1280\/<?php echo $movie->getBackdropPath() ?>');background-repeat:no-repeat;background-size:cover;"> 
  <h2 class="page-title">Movie Overview</h2>
  <main class="hoc container clear"> 
      <div class="content up">
        <h2 class="center page-title-variation cardStyle"><?php echo $movie->getTitle()?></h2>
      </div>
          <!-- ####################################### COLUMNA IZQUIERDA - DETALLES ######################################################### -->
        <div>
          <div class="one_half first cardStyle2">              
            <div class="one_half first">
              <div>
                <p><h4>Release Date</h4><?php echo $movie->getReleaseDate()?></p>
              </div><br>
              <div>
                <p><h4>Genre</h4><?php $str=""; foreach($movie->getGenreStrings() as $genre){
                                                            $str .=" ".$genre." /";}
                                                            echo substr_replace($str,"", -1); ?></p>
              </div>
            </div>
            <div class="one_half">
              <div>
                <p><h4>Runtime</h4><?php echo $movie->getRuntime()?> minutes</p>
              </div><br>
              <div>
                <p><h4>Homepage</h4>
                  <?php if($movie->getHomepage() != null){ ?>
                          <a href="<?php echo $movie->getHomepage()?>" target="_blank"> 
                          <?php echo $movie->getHomepage();?></a><?php
                          }else{ echo "Not Available";}?></p><br>
              </div>   
            </div>
            <div>
              <p><h4>Director/s</h4><?php  $str=""; foreach($movie->getDirector() as $director){ 
                                                          $str .=" ".$director." -";}
                                                            echo substr_replace($str,"", -1); ?></p>
            </div>
            
            <div>                                           <!-- si hay trailer se muestra, si no en ese espacio se muestra la descripcion -->
              <?php if(!$movie->getVideoPath()){ ?>     
                      <p><h4>Description</h4><?php echo $movie->getDescription()?></p>
                      <?php }else{ ?></p><p><h4>Trailer</h4>
                      <iframe width="440" height="300" src="https://www.youtube.com/embed/<?php echo $movie->getVideoPath();?>" 
                      frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                      </iframe> <?php } ?>
            </div>
          </div>   
              <!-- ####################################### COLUMNA DERECHA - POSTER ######################################################### -->
          <div class="one_half cardStyle">                 
            <img src="<?php echo $movie->getPoster() ?>" alt="<?php echo $movie->getTitle()?> poster">
          </div>
        </div>
        <div class="container clear up cardStyle3">
            <div>
              <?php if($movie->getVideoPath()){ ?>           <!-- si hay trailer, la descripcion se muestra debajo -->
              <p><h4>Description</h4><?php echo $movie->getDescription()?></p>
              </div> <?php } ?>
            <p><h4>Review</h4><?php if($movie->getReview()){
                                    echo $movie->getReview()['content'];} else {echo "Not reviewed yet";} ?></p>
            <p class= "fl_right"><?php if($movie->getReview()){
                                       echo $movie->getReview()['author'];}?></p>
        </div>
  </main>
</div>