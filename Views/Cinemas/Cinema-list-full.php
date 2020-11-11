<div class="wrapper bgded overlay" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/felix-mooneeram-evlkOfkQ5rE-unsplash.jpg');">
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
                    <li class="one_quarter first anim1" >
                      <h6 class="name shadow3"><?php if(strlen($cinema->getName()) > 13){
                                                $str1 = substr($cinema->getName(), 0, 11) . '...';
                                                echo $str1; 
                                                }else{
                                                echo $cinema->getName();}?></h6>                                      <!-- PRIMERA IMAGEN DE LA FILA -->
                      <a href="<?php echo FRONT_ROOT?>Cinema/showCinema/<?php echo $cinema->getIdCinema();?>">
                      <img class="cinemapic3 brd shadow2" src="<?php echo $cinema->getPoster();?>" alt=""></a>
                      <br><br><br><br><br><br>         
                    </li>
              <?php } 
                    else{ ?>
                    <li class="one_quarter anim1">
                      <h6 class="name shadow3"><?php if(strlen($cinema->getName()) > 13){
                                                $str1 = substr($cinema->getName(), 0, 11) . '...';
                                                echo $str1;
                                                }else{
                                                echo $cinema->getName();}?></h6>                                             <!-- LAS OTRAS TRES IMAGENES DE LA FILA -->
                      <a href="<?php echo FRONT_ROOT?>Cinema/showCinema/<?php echo $cinema->getIdCinema();?>">
                      <img class="cinemapic3 brd shadow2" src="<?php echo $cinema->getPoster();?>" alt=""></a>  
                    </li>
                    
                <?php }
                    $indice++;  
                  }
                } 
              else{ ?>
               <center><h4 class="msg">No matching results</h4></center>
        <?php } ?>
            </ul>
        </figure>
        </div>
    </div>
  </main>
</div>