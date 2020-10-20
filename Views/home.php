<div class="bgded overlay back" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/cineBack2.jpg');"> 
  <!-- ###################################### FLEXSLIDER ######################################## -->
  <div id="pageintro" class="hoc clear"> 
    <div class="flexslider basicslider">
      <ul class="slides">
        <?php for($i=0; $i<5; $i++){ ?>
          <li>
            <article>
              <h2 class="heading headingcolor"><?php $str1=""; 
                        if(strlen($movieList[$i]->getTitle()) > 33){
                        $str1 = substr($movieList[$i]->getTitle(), 0, 30) . '...';
                        echo $str1;
                        }else{ 
                        echo $movieList[$i]->getTitle(); } ?>
              </h2>
              <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movieList[$i]->getTmdbID()?>">
                <img class="poster" src="https:\/\/image.tmdb.org\/t\/p\/w1280\/<?php echo $movieList[$i]->getBackdropPath(); ?>" alt="<?php echo $movieList[$i]->getTitle(); ?> movie poster">
              </a>
              <p> <?php $str=""; 
                        if(strlen($movieList[$i]->getDescription()) > 250){
                        $str = substr($movieList[$i]->getDescription(), 0, 247) . '...';
                        echo $str;
                        }else{ 
                        echo $movieList[$i]->getDescription();} ?>
              </p> 
              <footer>
                <ul class="nospace inline pushright">
                  <li><a class="btn" href="#">Buy ticket</a></li>
                  <li><a class="btn inverse" href="#">Movie description</a></li>
                </ul>
              </footer>
            </article>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>
<!-- ########################################### PUBLICIDADES ##################################################### -->
<div class="wrapper row4" >
  <div class="background-pic-promo" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/alex-litvin-MAYsdoYpGuk-unsplash.jpg');">
    <h2 class="page-title page-title-special">Promos</h2> 
  </div> 
  <img class="promo" src="<?php echo IMG_PATH?>promo25.jpg" alt="25% off promo poster">
  <img class="promo" src="<?php echo IMG_PATH?>promo25.jpg" alt="25% off promo poster">
</div>
<!-- ########################################### TOP RATED MOVIES  ##################################################### -->
<div class="background-pic gradient" >
<h2 class="page-title">Top Rated Movies</h2>  
<main class="hoc container clear"> 
  <div id="gallery">
        <figure>
          <ul class="nospace clear">
            <?php $indice = 0;
            foreach ($movieList as $movie){
              if($indice %4 == 0){?>
            <li class="one_quarter first anim1 slideDown">
              <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movie->getTmdbID()?>">
              <img src="<?php echo $movie->getPoster()?>" alt=""></a>
              <p class="p-title"><?php echo $movie->getTitle()?></p>
              <p><i class="fa-spin fa fa-star"></i><?php echo " ".$movie->getVoteAverage()?></p>
              <p><i class="fa fa-tags"></i><?php $str=""; foreach($movie->getGenreStrings() as $genre){
                                                            $str .=" ".$genre." /";}
                                                            echo substr_replace($str,"", -1); ?></p>
            </li>
            <?php }else{ ?>
            <li class="one_quarter anim1 slideDown">
              <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movie->getTmdbID()?>">
              <img src="<?php echo $movie->getPoster()?>" alt=""></a>
              <p class="p-title"><?php echo $movie->getTitle()?></p>
              <p><i class="fa-spin fa fa-star"></i><?php echo " ".$movie->getVoteAverage()?></p>
              <p><i class="fa fa-tags"></i><?php $str=""; foreach($movie->getGenreStrings() as $genre){
                                                            $str .=" ".$genre." /";}
                                                            echo substr_replace($str,"", -1); ?></p>
            </li>
            <?php }
            $indice++;
            }?>
          </ul>
        </figure>
      </div>
  </main>
</div>
<!-- ###########################################   OUR CINEMAS  ##################################################### -->
<div class="wrapper bgded overlay" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/christian-wiediger-AEeoY_aqvNk-unsplash.jpg');">
<h2 class="page-title">Our Cinemas</h2>  
  <section class="hoc container clear"> 
    <ul class="nospace group">
      <li class="one_quarter first">
        <h6 class="heading font-x2 center">Ambassador</h6>
        <article class="excerpt"><a href="#"><img class="cinemapic" src="<?php echo IMG_PATH?>cinema1.jpg" alt="cinema 1 photo"></a>
          <div class="excerpttxt">
            <footer><a class="btn" href="#">Read More &raquo;</a></footer>
          </div>
        </article>
      </li>
      <li class="one_quarter">
        <h6 class="heading font-x2 center">Del Paseo</h6>
        <article class="excerpt"><a href="#"><img class="cinemapic" src="<?php echo IMG_PATH?>cinema2.jpg" alt="cinema 2 photo"></a>
          <div class="excerpttxt">
            <footer><a class="btn" href="#">Read More &raquo;</a></footer>
          </div>
        </article>
      </li>
        <li class="one_quarter">
      <h6 class="heading font-x2 center">Cine Puerto</h6>
        <article class="excerpt"><a href="#"><img class="cinemapic" src="<?php echo IMG_PATH?>cinema3.jpg" alt="cinema 3 photo"></a>
          <div class="excerpttxt">
            <footer><a class="btn" href="#">Read More &raquo;</a></footer>
          </div>
        </article>
      </li>
      <li class="one_quarter">
        <h6 class="heading font-x2 center">Atlas</h6>
        <article class="excerpt"><a href="#"><img class="cinemapic" src="<?php echo IMG_PATH?>cinema4.jpg" alt="cinema 4 photo"></a>
          <div class="excerpttxt">
            <footer><a class="btn" href="#">Read More &raquo;</a></footer>
          </div>
        </article>
      </li>
    </ul>
  </section>
</div>
<!-- ################################################################################################ -->
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
