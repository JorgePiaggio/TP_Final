<div class="bgded overlay back" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/cineBack2.jpg');">   
                      <?php if($this->msg != null){?> 
                            <h4 class="msg"><?php  echo $this->msg;?> </h4> <?php
                        } ?> 
                     
  <!-- ###################################### FLEXSLIDER ######################################## -->
  <div id="pageintro" class="hoc clear"> 
    <div class="flexslider basicslider">
      <ul class="slides"> 
        <?php $cant=null;  if(isset($movieListSlider)){$cant = count($movieListSlider);}

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
                    <li><a class="btn inverse invisible" href="">LOL!</a></li> <!--- BOTON INVISIBLE, LA UNICA FORMA DE CENTRAR AL BOTON Q SIGUE -->
                    <li><a class="btn" href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movieListSlider[$i]->getTmdbID()?>">SHOWS</a></li>
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
<!-- ########################################### UPCOMING SHOWS  ##################################################### -->
<div class="bkg" >
  <h2 class="page-title">UPCOMING SHOWS</h2>  
              <span></span> <!-- no borrar ! -->
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
  <main class="clear grid" > 
        <?php foreach($movieShows as $movie){?>
          
          <div class="cardStyle mrg_btm3 mrg_top">
            <button type="" class="notCollapsible"><?php if(strlen($movie->getTitle()) > 30){
                                                          $str1 = substr($movie->getTitle(), 0, 27) . '...';
                                                          echo $str1; ?><?php }else{ echo $movie->getTitle(); } ?></button>

            <div class="posterBillboard-hover-zoom posterBillboard-hover-zoom--slowmo">
              <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movie->getTmdbID()?>">
                <img class="posterBillboard posterBillboardHome" src="<?php echo $movie->getPoster()?>" alt="<?php echo $movie->getTitle()?> movie poster">
              </a>
            </div>

            <div>
              <button type="" class="notCollapsible nc2"><?php echo $movie->getGenres()[0]->getName()?></button>
              <button type="button" class="collapsible">Show List</button>
              <div class="content1">
              <?php if($_SESSION && $_SESSION["loggedUser"] != "admin@moviepass.com"){
                      foreach($showList as $show){
                        if($show->getMovie()->getTmdbId() == $movie->getTmdbId()){ ?>
                          <a href="<?php echo FRONT_ROOT?>/Ticket/showPurchaseView/<?php echo $show->getIdShow()?>">
                            <p class="p_orange">
                              <?php if(strlen($show->getRoom()->getCinema()->getName()) > 13){
                                    $str1 = substr($show->getRoom()->getCinema()->getName(), 0, 11) . '...';
                                    echo $str1; ?></h6><?php }else{
                                    echo $show->getRoom()->getCinema()->getName();}?>
                            </p> <hr>
                            <p class="p_white">
                              <?php echo date('l d M - H:i', strtotime($show->getDateTime()))." hs ";?>
                              <i class="fa fa-ticket" style="font-size: 1.73em"></i>
                            </p>
                          </a><?php 
                        }
                      }
                    }
                    else{
                      foreach($showList as $show){
                        if($show->getMovie()->getTmdbId() == $movie->getTmdbId()){ ?>
                            <p class="p_orange">
                              <?php if(strlen($show->getRoom()->getCinema()->getName()) > 13){
                                    $str1 = substr($show->getRoom()->getCinema()->getName(), 0, 11) . '...';
                                    echo $str1; ?></h6><?php }else{
                                    echo $show->getRoom()->getCinema()->getName();}?>
                            </p> <hr>
                            <p class="p_white">
                              <?php echo date('l d M - H:i', strtotime($show->getDateTime()))." hs ";?>
                              <i class="fa fa-ticket" style="font-size: 1.73em"></i>
                              <?php echo "Login" ?>
                            </p>
                          <?php 
                        }
                      } 
                    }?> 
              </div> 
            </div>

          </div><?php
        }?>
  </main>
</div>

<!-- ########################################### PUBLICIDADES ##################################################### -->
<div class="wrapper row4 " >
  <div class="background-pic-promo heightDef" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/alex-litvin-MAYsdoYpGuk-unsplash.jpg');">
    <h2 class="page-title page-title-special">Promos</h2>  <br><br>
    <div class="grid marginAuto">
      <img class="promo marginAuto" src="<?php echo IMG_PATH?>promoAlt.jpg" alt="popcorn promo poster">
      <img class="promo marginAuto" src="<?php echo IMG_PATH?>25off.png" alt="25% off promo poster">
  </div>
  </div> 
</div>
<!-- #########################################################   OUR CINEMAS  ##################################################### -->
<div class="background-pic not" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/christian-wiediger-AEeoY_aqvNk-unsplash.jpg');">
  <h2 class="page-title backg">Our Cinemas</h2>  
  <section class="hoc container clear up6 "> 
    <ul class="nospace group">
      <?php $indice=0;
        if(isset($cinemaList)){   // para evitar errores cuando la bdd esta vacia
            if(is_array($cinemaList)){
              foreach ($cinemaList as $cinema){
                if($indice % 4 == 0){?>
                  <li class="one_quarter first">
                    <h6 class="heading font-x1 center"><?php if(strlen($cinema->getName()) > 13){
                                                              $str1 = substr($cinema->getName(), 0, 11) . '...';
                                                              echo $str1; ?></h6><?php }else{
                                                              echo $cinema->getName();?></h6><?php } ?>
                    <article class="excerpt"><a href="<?php echo FRONT_ROOT?>Cinema/showCinema/<?php echo $cinema->getIdCinema();?>">
                    <img class="cinemapic br shadow2" src="<?php echo $cinema->getPoster();?>" alt="cinema <?php echo $cinema->getName();?> photo"></a>
                      <div class="excerpttxt up7 mrg_btm2">
                        <footer><a class="btn" href="<?php echo FRONT_ROOT?>Cinema/showCinema/<?php echo $cinema->getIdCinema();?>">About &raquo;</a></footer>
                      </div>
                    </article>
                  </li><?php 
                }else{?>
                  <li class="one_quarter">
                    <h6 class="heading font-x1 center"><?php if(strlen($cinema->getName()) > 13){
                                                              $str1 = substr($cinema->getName(), 0, 11) . '...';
                                                              echo $str1; ?></h6><?php }else{
                                                              echo $cinema->getName();?></h6><?php } ?>
                    <article class="excerpt"><a href="<?php echo FRONT_ROOT?>Cinema/showCinema/<?php echo $cinema->getIdCinema();?>">
                    <img class="cinemapic br shadow2" src="<?php echo $cinema->getPoster();?>" alt="cinema <?php echo $cinema->getName();?> photo"></a>
                      <div class="excerpttxt up7 mrg_btm2">
                        <footer><a class="btn" href="<?php echo FRONT_ROOT?>Cinema/showCinema/<?php echo $cinema->getIdCinema();?>">About &raquo;</a></footer>
                      </div>
                    </article>
                  </li><?php 
                } $indice++;
              }
            }else{?>
                <li class="one_quarter first">
                <h6 class="heading font-x1 center"><?php if(strlen($cinema->getName()) > 13){
                                                              $str1 = substr($cinema->getName(), 0, 11) . '...';
                                                              echo $str1;?></h6><?php }else{
                                                              echo $cinema->getName();?></h6><?php } ?>
                <article class="excerpt"><a href="<?php echo FRONT_ROOT?>Cinema/showCinema/<?php echo $cinema->getIdCinema();?>">
                <img class="cinemapic br shadow2" src="<?php echo $cinemaList->getPoster();?>" alt="cinema <?php echo $cinemaList->getName();?> photo"></a>
                  <div class="excerpttxt up7 mrg_btm2">
                    <footer><a class="btn" href="<?php echo FRONT_ROOT?>Cinema/showCinema/<?php echo $cinema->getIdCinema();?>">About &raquo;</a></footer>
                  </div>
                </article>
              </li><?php 
            }}?>
    </ul>
  </section>
</div>
<!-- ########################################### TOP RATED MOVIES  ##################################################### -->
<div class="bkg up" >
              <span></span> <!-- no borrar ! -->
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
  <div class="background-pic gradient" >
    <h2 class="page-title">Top Rated Movies</h2>
      <main class="down clear grid"> 
        <div id="gallery">
        
              <figure>
                <ul class="nospace clear">
                    <?php $indice = 0;                         /* indice para ordenarlas */
                    if(isset($movieList)){
                      foreach ($movieList as $movie){
                          if($indice %4 == 0){ ?>                         
                        <li class="one_quarter first anim1 slideDown spec">                                            <!--- primer pelicula de la izquierda -->
                          <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movie->getTmdbID()?>">
                          <div class="cardStyle2"> 
                            <img class="posterSmall xxx" src="<?php echo $movie->getPoster()?>" alt=""></a>
                          </div>
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

                        <li class="one_quarter anim1 slideDown spec">                                                <!--- las otras 3 peliculas de la fila -->
                          <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movie->getTmdbID()?>">
                          <div class="cardStyle2">  
                            <img class="posterSmall xxx" src="<?php echo $movie->getPoster()?>" alt=""></a>
                          </div>
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
                        </li><?php } 
                        $indice++;  
                      }
                    }?>
                </ul>
              </figure>

        </div>
      </main>
  </div>
</div>


<!-- ################################################################################################ -->
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>




<!-- ################################################################################################ -->
<!-- ################################################################################################ -->

<script>
var coll = document.getElementsByClassName("collapsible");
var i;
for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    }
  });
}</script>

<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
