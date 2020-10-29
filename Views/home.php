<div class="bgded overlay back" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/cineBack2.jpg');"> 
  <!-- ###################################### FLEXSLIDER ######################################## -->
  <div id="pageintro" class="hoc clear"> 
    <div class="flexslider basicslider">
      <ul class="slides"> 
        <?php $cant=null; if(isset($movieListSlider)){$cant = count($movieListSlider);}
        if($cant>0){
          for($i=0; $i<$cant; $i++){ ?>
            <li>
              <article>
                <h2 class="heading headingcolor"><?php $str1=""; 
                          if($movieListSlider[$i]->getBackdropPath()){
                            if(strlen($movieListSlider[$i]->getTitle()) > 33){
                              $str1 = substr($movieListSlider[$i]->getTitle(), 0, 30) . '...';
                              echo $str1;
                              }else{ 
                              echo $movieListSlider[$i]->getTitle(); 
                            } ?>
                </h2>
                <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movieListSlider[$i]->getTmdbID()?>">
                    <img class="poster" src="https:\/\/image.tmdb.org\/t\/p\/w1280\/<?php echo $movieListSlider[$i]->getBackdropPath(); ?>" 
                    alt="<?php echo $movieListSlider[$i]->getTitle(); ?> movie poster">
                </a>
                <p><?php $str=""; 
                  if(strlen($movieListSlider[$i]->getDescription()) > 250){
                    $str = substr($movieListSlider[$i]->getDescription(), 0, 247) . '...';
                    echo $str;
                  }else{ 
                    echo $movieListSlider[$i]->getDescription();
                  } 
                  }?>
                </p> 
                <footer>
                  <ul class="nospace inline pushright">
                    <li><a class="btn" href="#">Buy ticket</a></li>
                    <li><a class="btn inverse" href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movieListSlider[$i]->getTmdbID()?>">Movie description</a></li>
                  </ul>
                </footer>
              </article>
            </li>
           <?php 
          }
        } ?>
      </ul>
    </div>
  </div>
</div>
<!-- ########################################### PUBLICIDADES ##################################################### -->
<div class="wrapper row4" >
  <div class="background-pic-promo" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/alex-litvin-MAYsdoYpGuk-unsplash.jpg');">
    <h2 class="page-title page-title-special">Promos</h2> 
  </div> 
  <img class="promo" src="<?php echo IMG_PATH?>promoAlt.jpg" alt="popcorn promo poster">
  <img class="promo" src="<?php echo IMG_PATH?>25off.png" alt="25% off promo poster">
</div>
<!-- ########################################### TOP RATED MOVIES  ##################################################### -->
<div class="background-pic gradient" >
<h2 class="page-title">Top Rated Movies</h2>  
<main class="hoc container clear"> 
  <div id="gallery">
        <figure>
          <ul class="nospace clear">
              <?php $indice = 0;                         /* indice para ordenarlas */
              if(isset($movieList)){
                foreach ($movieList as $movie){
                    if($indice %4 == 0){ ?>                               
                  <li class="one_quarter first anim1 slideDown">                                            <!--- primer pelicula de la izquierda -->
                    <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movie->getTmdbID()?>">
                    <img class="posterSmall" src="<?php echo $movie->getPoster()?>" alt=""></a>
                    <p class="p-title"><?php echo $movie->getTitle()?></p>
                    <p><i class="fa-spin fa fa-star"></i><?php echo " ".$movie->getVoteAverage()?></p>
                    <p><i class="fa fa-tags"></i><?php $str=""; if($movie->getGenres()){ 
                                                                  if(!is_array($movie->getGenres())){
                                                                    echo $movie->getGenres()->getName();
                                                                  }else{
                                                                    foreach($movie->getGenres() as $genre){
                                                                    $str .=" ".$genre->getName()." /";
                                                                    }
                                                                    echo substr_replace($str,"", -1); 
                                                                  }} ?></p>
                  </li>
                  <?php }else{ ?>
                  <li class="one_quarter anim1 slideDown">                                                  <!--- las otras 3 peliculas de la fila -->
                    <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movie->getTmdbID()?>">
                    <img class="posterSmall" src="<?php echo $movie->getPoster()?>" alt=""></a>
                    <p class="p-title"><?php echo $movie->getTitle()?></p>
                    <p><i class="fa-spin fa fa-star"></i><?php echo " ".$movie->getVoteAverage()?></p>
                    <p><i class="fa fa-tags"></i><?php $str=""; if($movie->getGenres()){ 
                                                                if(!is_array($movie->getGenres())){
                                                                  echo $movie->getGenres()->getName();
                                                                }else{ 
                                                                  foreach($movie->getGenres() as $genre){
                                                                  $str .=" ".$genre->getName()." /";
                                                                  }
                                                                  echo substr_replace($str,"", -1);
                                                                }} ?></p>
                  </li> <?php } 
                  $indice++;  
                }
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
      <?php $indice=0;
            if(is_array($cinemaList)){
              foreach ($cinemaList as $cinema){
                if($indice % 4 == 0){?>
                  <li class="one_quarter first">
                    <h6 class="heading font-x2 center"><?php if(strlen($cinema->getName()) > 13){
                                                              $str1 = substr($cinema->getName(), 0, 11) . '...';
                                                              echo $str1; ?></h6><?php }else{
                                                              echo $cinema->getName();?></h6><?php } ?>
                    <article class="excerpt"><a href="#"><img class="cinemapic" src="<?php echo $cinema->getPoster();?>" alt="cinema <?php echo $cinema->getName();?> photo"></a>
                      <div class="excerpttxt">
                        <footer><a class="btn" href="#">Billboard &raquo;</a></footer>
                      </div>
                    </article>
                  </li><?php 
                }else{?>
                  <li class="one_quarter">
                    <h6 class="heading font-x2 center"><?php if(strlen($cinema->getName()) > 13){
                                                              $str1 = substr($cinema->getName(), 0, 11) . '...';
                                                              echo $str1; ?></h6><?php }else{
                                                              echo $cinema->getName();?></h6><?php } ?>
                    <article class="excerpt"><a href="#"><img class="cinemapic" src="<?php echo $cinema->getPoster();?>" alt="cinema <?php echo $cinema->getName();?> photo"></a>
                      <div class="excerpttxt">
                        <footer><a class="btn" href="#">Billboard &raquo;</a></footer>
                      </div>
                    </article>
                  </li><?php 
                } $indice++;
              }
            }else{?>
                <li class="one_quarter first">
                <h6 class="heading font-x2 center"><?php if(strlen($cinema->getName()) > 13){
                                                              $str1 = substr($cinema->getName(), 0, 11) . '...';
                                                              echo $str1;?></h6><?php }else{
                                                              echo $cinema->getName();?></h6><?php } ?>
                <article class="excerpt"><a href="#"><img class="cinemapic" src="<?php echo $cinemaList->getPoster();?>" alt="cinema <?php echo $cinemaList->getName();?> photo"></a>
                  <div class="excerpttxt">
                    <footer><a class="btn" href="#">Billboard &raquo;</a></footer>
                  </div>
                </article>
              </li><?php 
            }?>
    </ul>
  </section>
</div>
<!-- ################################################################################################ -->
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
