<div class="bgded overlay" style="background-image:url('https:\/\/image.tmdb.org\/t\/p\/w1280\/<?php echo $movie->getBackdropPath() ?>');"> 
  <h2 class="page-title">Movie Overview</h2>
  <main class="hoc container clear"> 
    <div class="content up"> 
      <h2 class="center orange"><?php echo $movie->getTitle()?></h2>
      <div class="cardStyle">
        <div>
          <div class="one_half first">               <!--- COLUMNA IZQUIERDA - DETALLES -->
            <p><h4>Runtime</h4><?php echo $movie->getRuntime()?> minutes</p>
            <p><h4>Release Date</h4><?php echo $movie->getReleaseDate()?></p>
            <p><h4>Description</h4><?php echo $movie->getDescription()?></p>
            <?php if($movie->getHomepage() != null){ ?>
              <p><h4>Homepage</h4><a href="<?php echo $movie->getHomepage()?>" target="_blank">
              <?php echo $movie->getHomepage()?></a></p> 
            <?php }?>
          </div>    
          <div class="one_half">                     <!--- COLUMNA DERECHA - POSTER -->
            <img src="<?php echo $movie->getPoster() ?>" alt="<?php echo $movie->getTitle()?> poster">
          </div>
        </div>
      </div>
    </div>
  </main>
</div>