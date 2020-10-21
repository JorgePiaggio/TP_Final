<div class="bgded overlay" style="background-image:url('https:\/\/image.tmdb.org\/t\/p\/w1280\/<?php echo $movie->getBackdropPath() ?>');"> 
  <h2 class="page-title">Movie Overview</h2>
  <main class="hoc container clear"> 
      <div class="content up">
        <h2 class="center page-title-variation"><?php echo $movie->getTitle()?></h2>
      </div>
          <!-- ####################################### COLUMNA IZQUIERDA - DETALLES ######################################################### -->
        <div class="one_half first cardStyle">              
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
            <p><h4>Description</h4><?php echo $movie->getDescription()?></p>
          </div>
          <div>
            <p><h4>Trailer</h4><?php if(!$movie->getVideoPath()){
                                      echo "Not Available";}else{}?></p>
                                      <iframe width="560" height="315" src="<?php echo $movie->getVideoPath();?>" frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                                      </iframe>
                                    
          </div>
        </div>   
            <!-- ####################################### COLUMNA DERECHA - POSTER ######################################################### -->
        <div class="one_half">                 
          <img src="<?php echo $movie->getPoster() ?>" alt="<?php echo $movie->getTitle()?> poster">
        </div>
  </main>
</div>