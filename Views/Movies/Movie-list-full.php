<div class="wrapper row3 gradient">
  <h2 class="page-title">Movie List</h2>
  <main class="hoc container clear" > 
    <div class="content" > 
           <!-- ####################################### OPTION GENRES ######################################################### -->
           <form action="<?php echo FRONT_ROOT?>Movie/filterByGenre" method="post" class= "genreselector">
              <select name="Genres" class=" selection" onchange="this.form.submit()" id="genre">
          <?php if($actualGenre){?>
            <option value="selected" selected disabled> <?php echo $actualGenre->getName();?> </option>
            <?php } ?>
           <option value=<?php echo $allGenre->getId();?> class=" selected"> <?php echo $allGenre->getName();?> </option>
           
            <?php foreach($genreList as $genre) { ?>
           <option value="<?php echo $genre->getId();?>">
              <?php echo $genre->getName();?>
           </option>
            <?php } ?> 
            </select>
        </form>
         <!-- ####################################### MOVIE GALLERY ######################################################### -->
      <div id="gallery">
        <figure>
          <ul class="nospace clear">
            <?php $indice=0; 
              if($movieList != null){ 
                if(!is_array($movieList)){ ?>
                  <li class="one_quarter first anim1 slideDown">                                       <!--UNA SOLA PELICULA EN LISTA -->
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
              else{ ?><h1 class="msg">No matching results</h1><?php
              } ?>
          </ul>
        </figure>
      </div>
    </div>
  </main>
</div>

