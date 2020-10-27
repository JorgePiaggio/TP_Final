    <!------ My billboard----->
<div class="wrapper row3 gradient">
  <h2 class="page-title"><?php echo $cinema->getName(); ?> Billboard</h2> 
  <?php if($this->msg){?> 
    <div class="center"><h4 class="msg"><?php echo $this->msg;} ?></h4></div>
  <form action="<?php echo FRONT_ROOT?>Cinema/removeFromBillboard" method="POST" >
    <?php if($cinemaBillboard != null){?>
    <div class="floating-label margin2">
      <button type="submit" name="idcinemamanage" value="<?php echo $cinema->getIdCinema();?>" class="btn btn-primary ml-auto d-block">Remove movies</button><br><br>             
    </div><?php } ?>

   <!-- ####################################### MOVIE GALLERY ######################################################### -->
  <main class="hoc container clear up4" > 
    <div class="content" > 
      <div id="gallery">
        <figure>
          <ul class="nospace clear">
            <?php $indice=0; 
              if($cinemaBillboard != null){ 
                if(!is_array($cinemaBillboard)){ ?>
                  <li class="one_quarter first anim1 slideDown">                                       <!--UNA SOLA PELICULA EN LISTA -->
                    <div class="check fl_right">
                      <input type="checkbox" id="<?php echo $movie->getTmdbID();?>" name="moviess[]" value="<?php echo $cinemaBillboard->getTmdbID();?>">
                      <label for="<?php echo $movie->getTmdbID();?>">Toggle</label>
                    </div>
                  <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $cinemaBillboard->getTmdbID()?>">
                  <img src="<?php echo $cinemaBillboard->getPoster()?>" alt=""></a>         
                  <p class="p-title"><?php echo $cinemaBillboard->getTitle()?></p>
                  <p><i class="fa-spin fa fa-star"></i><?php echo " ".$cinemaBillboard->getVoteAverage()?></p>
                  <p><i class="fa fa-tags"></i><?php $str=""; if(!is_array($cinemaBillboard->getGenres())){
                                                                  echo $cinemaBillboard->getGenres()->getName();
                                                              }else{ 
                                                                foreach($cinemaBillboard->getGenres() as $genre){
                                                                $str .=" ".$genre->getName()." /";
                                                                }
                                                                echo substr_replace($str,"", -1); 
                                                              }?></p><?php
                      }else{
                      foreach ($cinemaBillboard  as $movie){
                      if($indice % 4 == 0){?>
                    <li class="one_quarter first anim1 slideDown">                                       <!-- PRIMERA IMAGEN DE LA FILA -->
                      <div class="check fl_right">
                        <input type="checkbox" name="moviess[]" value="<?php echo $movie->getTmdbID();?>">
                        <label for="<?php echo $movie->getTmdbID();?>">Toggle</label>
                      </div>
                      <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movie->getTmdbID()?>">
                      <img src="<?php echo $movie->getPoster()?>" alt=""></a>         
                      <p class="p-title"><?php echo $movie->getTitle()?></p>
                      <p><i class="fa-spin fa fa-star"></i><?php echo " ".$movie->getVoteAverage()?></p>
                      <p><i class="fa fa-tags"></i><?php $str=""; if(!is_array($movie->getGenres())){
                                                                      echo $movie->getGenres()->getName();
                                                                  }else{ 
                                                                    foreach($movie->getGenres() as $genre){
                                                                    $str .=" ".$genre->getName()." /";
                                                                    }
                                                                    echo substr_replace($str,"", -1); 
                                                                  }?></p>
                    </li>
                      <?php }else{ ?>
                    <li class="one_quarter anim1 slideDown">                                             <!-- LAS OTRAS TRES IMAGENES DE LA FILA -->
                      <input type="checkbox" name="moviess[]" value="<?php echo $movie->getTmdbID();?>">
                        <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movie->getTmdbID()?>">
                        <img src="<?php echo $movie->getPoster()?>" alt=""></a>
                        <p class="p-title"><?php echo $movie->getTitle()?></p>
                        <p><i class="fa-spin fa fa-star"></i><?php echo " ".$movie->getVoteAverage()?></p>
                        <p><i class="fa fa-tags"></i><?php $str=""; if(!is_array($movie->getGenres())){
                                                                        echo $movie->getGenres()->getName();
                                                                    }else{ 
                                                                      foreach($movie->getGenres() as $genre){
                                                                      $str .=" ".$genre->getName()." /";
                                                                      }
                                                                      echo substr_replace($str,"", -1); 
                                                                    } ?></p>
                    </li><?php }
                    $indice++; 
                  }
                }
              }
              else{ ?><div class="center"><h4 class="msg">No matching results</h4></div><?php
              } ?>

                
            </form>
          </ul>
        </figure>
      </div>
    </div>
  </main>
</div>

<div class="wrapper row3 gradient"> 
  <h2 class="page-title">Database</h2>
  <main class="hoc container clear" > 
    <div class="floating-label fl_right margin1">
      <form action="<?php echo FRONT_ROOT?>Cinema/addToBillboard" method="POST" >
       <?php if($movieList != null){?>
        <button type="submit" name="manage" value="<?php echo $cinema->getIdCinema();?>" class="btn btn-primary ml-auto d-block">Add movies</button><br><br>
       <?php } ?>
      </div>
    <div class="content" > 
      
         <!-- ####################################### MOVIE GALLERY ######################################################### -->
      <div id="gallery">
        <figure>
          <ul class="nospace clear">

         
            <?php $indice=0;
              if($movieList != null){ 
                if(!is_array($movieList)){ ?>
                  <li class="one_quarter first anim1 slideDown"> 
                                                      <!--UNA SOLA PELICULA EN LISTA -->
                <input type="checkbox" name="movies[]" value="<?php echo $movieList->getTmdbID();?>">
                  <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movieList->getTmdbID()?>">
                  <img src="<?php echo $movieList->getPoster()?>" alt=""></a>         
                  <p class="p-title"><?php echo $movieList->getTitle()?></p>
                  <p><i class="fa-spin fa fa-star"></i><?php echo " ".$movieList->getVoteAverage()?></p>
                  <p><i class="fa fa-tags"></i><?php $str=""; if(!is_array($movieList->getGenres())){
                                                                  echo $movieList->getGenres()->getName();
                                                              }else{ 
                                                                foreach($movieList->getGenres() as $genre){
                                                                $str .=" ".$genre->getName()." /";
                                                                }
                                                                echo substr_replace($str,"", -1); 
                                                              }?></p><?php
                }else{
                  foreach ($movieList as $movie){
                    if($indice % 4 == 0){?>
                    <li class="one_quarter first anim1 slideDown">                                       <!-- PRIMERA IMAGEN DE LA FILA -->
                    <input type="checkbox" name="movies[]" value="<?php echo $movie->getTmdbID();?>">
                      <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movie->getTmdbID()?>">
                      <img src="<?php echo $movie->getPoster()?>" alt=""></a>         
                      <p class="p-title"><?php echo $movie->getTitle()?></p>
                      <p><i class="fa-spin fa fa-star"></i><?php echo " ".$movie->getVoteAverage()?></p>
                      <p><i class="fa fa-tags"></i><?php $str=""; if(!is_array($movie->getGenres())){
                                                                      echo $movie->getGenres()->getName();
                                                                  }else{ 
                                                                    foreach($movie->getGenres() as $genre){
                                                                    $str .=" ".$genre->getName()." /";
                                                                    }
                                                                    echo substr_replace($str,"", -1); 
                                                                  }?></p>
                    </li>
                    <?php }else{ ?>
                    <li class="one_quarter anim1 slideDown">                                             <!-- LAS OTRAS TRES IMAGENES DE LA FILA -->
                    <input type="checkbox" name="movies[]" value="<?php echo $movie->getTmdbID();?>">
                      <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movie->getTmdbID()?>">
                      <img src="<?php echo $movie->getPoster()?>" alt=""></a>
                      <p class="p-title"><?php echo $movie->getTitle()?></p>
                      <p><i class="fa-spin fa fa-star"></i><?php echo " ".$movie->getVoteAverage()?></p>
                      <p><i class="fa fa-tags"></i><?php $str=""; if(!is_array($movie->getGenres())){
                                                                      echo $movie->getGenres()->getName();
                                                                  }else{ 
                                                                    foreach($movie->getGenres() as $genre){
                                                                    $str .=" ".$genre->getName()." /";
                                                                    }
                                                                    echo substr_replace($str,"", -1); 
                                                                  } ?></p>
                    </li><?php }
                    $indice++; 
                  }
                }
              }
              else{ ?><span class="center"><h4 class="msg">No matching results</h4></span><?php
              } ?>
                
            </form>
          </ul>
        </figure>
      </div>
    </div>
  </main>
</div>

