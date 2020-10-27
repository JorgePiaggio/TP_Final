<div class="wrapper row3 gradient">
  <h2 class="page-title">Cinema List</h2>
  <main class="hoc container clear" > 
    <div class="content" > 
      <!-- ################################################### CINEMA GALLERY ###################################################### -->
      <div id="gallery">
        <figure>
          <ul class="nospace clear">
            <?php $indice=0; 
              if($cinemaList != null){ 
                foreach($cinemaList as $cinema){ 
                    if($indice % 4 == 0){?>
                    <li class="one_quarter first anim1 slideDown">                                       <!-- PRIMERA IMAGEN DE LA FILA -->
                      <a href="<?php echo FRONT_ROOT?>Cinema/showCinema/<?php echo $cinema->getIdCinema()?>">
                      <img src="<?php echo $cinema->getPoster()?>" alt=""></a>         
                      <p class="p-title"><?php echo $cinema->getName()?></p>
                    </li>
              <?php } 
                    else{ ?>
                    <li class="one_quarter anim1 slideDown">                                             <!-- LAS OTRAS TRES IMAGENES DE LA FILA -->
                      <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $cinema->getIdCinema()?>">
                      <img src="<?php echo $cinema->getPoster()?>" alt=""></a>
                      <p class="p-title"><?php echo $cinema->getName()?></p>
                    </li>
                <?php }
                    $indice++;  
                  }
                } 
              else{ ?>
                <div class="center"><h4 class="msg">No matching results</h4></div>
        <?php } ?>
            </ul>
        </figure>
        </div>
    </div>
  </main>
</div>