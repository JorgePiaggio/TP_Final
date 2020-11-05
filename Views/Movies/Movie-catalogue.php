<!-- ##################################### LISTA QUE EL ADMIN PIDE A LA BDD ########################################################### -->

<div class="wrapper row3 gradient">
  <h2 class="page-title"> Active Catalogue</h2> 
  <?php if($this->msg){?> 
    <div class="center "><h4 class="msg"><?php echo $this->msg;} ?></h4></div>
  <form action="<?php echo FRONT_ROOT?>Movie/changeState" method="POST" >
    <?php if($movieListActive != null){?>
    <div class="floating-label margin2">
      <button type="submit" name="idcinemamanage"  class="btn btn-primary ml-auto d-block">Remove movies</button><br><br>             
    </div><?php } ?>

   <!-- #######################################   CATALOGUE   MOVIE   GALLERY   ######################################################### peliculas disponibles para shows --> 
    <main class="hoc container clear up4 " > 
      <div class="content" > 
        <div id="gallery">
          <figure>
            <ul class="nospace clear">
              <?php $indice=0; 
              if($movieListActive != null){ 
                if(!is_array($movieListActive)){ ?>
                  <li class="one_quarter first anim1 slideDown">                                       <!--UNA SOLA PELICULA EN LISTA -->
                    <div class="check fl_right">
                      <input type="checkbox" id="<?php echo $movie->getTmdbID();?>" name="movies[]" value="<?php echo $movieListActive->getTmdbID();?>">
                      <label for="<?php echo $movie->getTmdbID();?>">Toggle</label>
                    </div>
                  <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movieListActive->getTmdbID()?>">
                  <img class="posterSmall shadow" src="<?php echo $movieListActive->getPoster()?>" alt=""></a>         
                  <p class="p-title"><?php echo $movieListActive->getTitle()?></p>
                  <p><i class="fa-spin fa fa-star"></i><?php echo " ".$movieListActive->getVoteAverage()?></p>
                  <p><i class="fa fa-tags"></i><?php $str=""; if(is_set($movieListActive->getGenres()->getName())){
                                                                if(!is_array($movieListActive->getGenres())){
                                                                    echo $movieListActive->getGenres()->getName();
                                                                }else{ 
                                                                  foreach($movieListActive->getGenres() as $genre){
                                                                  $str .=" ".$genre->getName()." /";
                                                                  }
                                                                  echo substr_replace($str,"", -1); 
                                                                }
                                                              }?></p><?php
                  }else{
                        foreach ($movieListActive  as $movie){
                        if($indice % 4 == 0){?>
                            <li class="one_quarter first anim1 slideDown">                                       <!-- PRIMERA IMAGEN DE LA FILA -->
                              <div class="check fl_right">
                                <input type="checkbox"  id="<?php echo $movie->getTmdbID();?>" name="movies[]" value="<?php echo $movie->getTmdbID();?>">
                                <label for="<?php echo $movie->getTmdbID();?>">Toggle</label>
                              </div>
                              <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movie->getTmdbID()?>">
                              <img class="posterSmall shadow" src="<?php echo $movie->getPoster()?>" alt=""></a>         
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
                            </li><?php 
                          }else{ ?>
                            <li class="one_quarter anim1 slideDown">                                             <!-- LAS OTRAS TRES IMAGENES DE LA FILA -->
                            <div class="check fl_right">
                              <input type="checkbox"  id="<?php echo $movie->getTmdbID();?>" name="movies[]" value="<?php echo $movie->getTmdbID();?>">
                              <label for="<?php echo $movie->getTmdbID();?>">Toggle</label>
                            </div>
                                <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movie->getTmdbID()?>">
                                <img class="posterSmall shadow" src="<?php echo $movie->getPoster()?>" alt=""></a>
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
                            </li><?php 
                          } $indice++; 
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
         <!-- #######################################    DATABASE    MOVIE    GALLERY    ######################################################### peliculas dadas de baja -->
<div class="wrapper row3 gradient"> 
  <h2 class="page-title">Inactive Catalogue</h2>
  <main class="hoc container clear" > 
    <div class="floating-label fl_right margin1">
      <form action="<?php echo FRONT_ROOT?>Movie/changeState" method="POST" >
       <?php if($movieListInactive != null){?>
        <button type="submit" name="manage" class="btn btn-primary ml-auto d-block">Add movies</button><br><br>
       <?php } ?>
      </div>
    <div class="content" > 
      <div id="gallery">
        <figure>
          <ul class="nospace clear">
            <?php $indice=0;
              if($movieListInactive != null){ 
                if(!is_array($movieListInactive)){ ?>
                  <li class="one_quarter first anim1 slideDown"> 
                                                      <!--UNA SOLA PELICULA EN LISTA -->
                <div class="check fl_right">
                  <input type="checkbox" id="<?php echo $movieListInactive->getTmdbId();?>" name="movies[]" value="<?php echo $movieListInactive->getTmdbId();?>">
                  <label for="<?php echo $movieListInactive->getTmdbId();?>">Toggle</label>
                </div>
                  <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movieListInactive->getTmdbId()?>">
                  <img class="posterSmall shadow" src="<?php echo $movieListInactive->getPoster()?>" alt=""></a>         
                  <p class="p-title"><?php echo $movieListInactive->getTitle()?></p>
                  <p><i class="fa-spin fa fa-star"></i><?php echo " ".$movieListInactive->getVoteAverage()?></p>
                  <p><i class="fa fa-tags"></i><?php $str=""; if(!is_array($movieListInactive->getGenres())){
                                                                  echo $movieListInactive->getGenres()->getName();
                                                              }else{ 
                                                                foreach($movieListInactive->getGenres() as $genre){
                                                                $str .=" ".$genre->getName()." /";
                                                                }
                                                                echo substr_replace($str,"", -1); 
                                                              }?></p><?php
                }else{
                  foreach ($movieListInactive as $film){ 
                    if($indice % 4 == 0){;?>
                    <li class="one_quarter first anim1 slideDown">                                       <!-- PRIMERA IMAGEN DE LA FILA -->
                    <div class="check fl_right">
                      <input type="checkbox" id="<?php echo $film->getTmdbId();?>"  name="movies[]" value="<?php echo $film->getTmdbId();?>">
                      <label for="<?php echo $film->getTmdbId();?>">Toggle</label>
                    </div>
                      <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $film->getTmdbId()?>">
                      <img class="posterSmall shadow" src="<?php echo $film->getPoster()?>" alt=""></a>         
                      <p class="p-title"><?php echo $film->getTitle()?></p>
                      <p><i class="fa-spin fa fa-star"></i><?php echo " ".$film->getVoteAverage()?></p>
                      <p><i class="fa fa-tags"></i><?php $str=""; if(!is_array($film->getGenres())){
                                                                      echo $film->getGenres()->getName();
                                                                  }else{ 
                                                                    foreach($film->getGenres() as $genre){
                                                                    $str .=" ".$genre->getName()." /";
                                                                    }
                                                                    echo substr_replace($str,"", -1); 
                                                                  }?></p>
                    </li>
                    <?php }else{ ?>
                    <li class="one_quarter anim1 slideDown">                                             <!-- LAS OTRAS TRES IMAGENES DE LA FILA -->
                    <div class="check fl_right">
                      <input type="checkbox" id="<?php echo $film->getTmdbId();?>" name="movies[]" value="<?php echo $film->getTmdbId();?>">
                      <label for="<?php echo $film->getTmdbId();?>">Toggle</label>
                    </div>
                      <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $film->getTmdbId()?>">
                      <img class="posterSmall shadow" src="<?php echo $film->getPoster()?>" alt=""></a>
                      <p class="p-title"><?php echo $film->getTitle()?></p>
                      <p><i class="fa-spin fa fa-star"></i><?php echo " ".$film->getVoteAverage()?></p>
                      <p><i class="fa fa-tags"></i><?php $str=""; if(!is_array($film->getGenres())){
                                                                      echo $film->getGenres()->getName();
                                                                  }else{ 
                                                                    foreach($film->getGenres() as $genre){
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

