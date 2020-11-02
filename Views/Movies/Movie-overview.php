    <?php if($movie->getBackdropPath() != null) { ?>
<div class="bgded overlay gradient" style="background-image:url('https:\/\/image.tmdb.org\/t\/p\/w1280\/<?php echo $movie->getBackdropPath() ?>');background-repeat:no-repeat;background-size:cover;"> 
    <?php }else { ?>
  <div class="bgded overlay gradient"> 
    <?php } ?>

  <h2 class="page-title">Movie Overview</h2>
  <main class="hoc container clear"> 
      <div class="content up">
        <h2 class="center page-title-variation "><?php echo $movie->getTitle()?></h2>
        <?php if($_SESSION && $_SESSION["role"] == 1){ ?>
          <form action="<?php echo FRONT_ROOT?>Movie/addMovieToDatabase" method="post">
            <div class="floating-label fl_right margin3 up2">
              <button type="submit" name="btn" value="<?php echo $movie->getTmdbID() ?>" class="btn btn2">Add</button>
            </div>
      </div>
          </form>
        <?php } ?>
        <div class="cardStyle">
        <!-- ####################################### COLUMNA IZQUIERDA - DETALLES ######################################################### -->
        <div>
          <div class="one_half first ">              
            <div class="one_half first">
              <div>
                <p><h4>Release Date</h4><?php echo $movie->getReleaseDate()?></p>
              </div><br>
              <div>
                <p><h4>Genre</h4><?php $str=""; foreach($movie->getGenres() as $genre){
                                                            $str .=" ".$genre->getName()." /";}
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
                                                            echo substr_replace($str,"", -1); ?></p><br>
            </div>
            
            <div class="up">                                           <!-- si hay trailer se muestra, si no en ese espacio se muestra la descripcion -->
              <?php if(!$movie->getVideoPath()){ ?>     
                      <p><h4>Description</h4><?php echo $movie->getDescription()?></p>
                      <?php }else{ ?></p><h4>Trailer</h4>
                      <iframe class="" width="440" height="300" src="https://www.youtube.com/embed/<?php echo $movie->getVideoPath();?>" 
                      frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                      </iframe> <?php } ?>
            </div>
          </div>   
              <!-- ####################################### COLUMNA DERECHA - POSTER ######################################################### -->
          <div class="one_half">                 
            <img class="brd2" src="<?php echo $movie->getPoster() ?>" alt="<?php echo $movie->getTitle()?> poster">
          </div>
              <!-- ####################################### MITAD INFERIOR - FUNCIONES, DESCRIPCION Y REVIEW ######################################################### -->

          <div class="mrg_btm">
              <button type="button" class="collapsible"><span class="">Show List<span></button>
              <div class="content1">
              <?php if(!$showList){ ?>
                        <p class="p_orange">No shows on schedule</p> <hr><?php
                    }else{
                        if($_SESSION && $_SESSION["loggedUser"] != "admin@moviepass.com"){
                          foreach($showList as $show){
                            if($show->getMovie()->getTmdbId() == $movie->getTmdbId()){ ?>
                              <a href="<?php echo FRONT_ROOT?>/Ticket/showPurchaseView/<?php echo $show->getIdShow()?>">
                                <p class="p_orange">
                                  <?php if(strlen($show->getRoom()->getCinema()->getName()) > 13){
                                        $str1 = substr($show->getRoom()->getCinema()->getName(), 0, 11) . '...';
                                        echo $str1." "; ?><?php }else{
                                        echo $show->getRoom()->getCinema()->getName();} ?>
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
                                      echo $str1." "; ?><?php }else{
                                      echo $show->getRoom()->getCinema()->getName();} ?>
                              </p> <hr>
                              <p class="p_white">
                                <?php echo date('l d M - H:i', strtotime($show->getDateTime()))." hs ";?><i class="fa fa-ticket" style="font-size: 1.73em"></i>
                                <?php echo "Login to buy tickets" ?>
                              </p>
                            <?php 
                          }
                        }
                       }
                    }?> 
              </div> 
            </div>
        </div>
        <div class="container clear up ">
            <div class="up2">
              <?php if($movie->getVideoPath()){ ?>           <!-- si hay trailer, la descripcion se muestra debajo -->
              <p><h4>Description</h4><?php echo $movie->getDescription()?></p><br>
            </div> <?php } ?>
            <p><h4>Review</h4><?php if($movie->getReview()){
                                    echo $movie->getReview()['content'];} else {echo "Not reviewed yet";} ?></p>
            <p class= "fl_right"><?php if($movie->getReview()){
                                        echo $movie->getReview()['author'];}?></p>
          </div>
        </div>
  </main>
</div>









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