
<div class="wrapper bgded overlay" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/roll.jpg');">
    <h2 class="page-title"><?php echo $cinema->getName() ?></h2>
    <main class="hoc container clear"> 
        <div class="cardStyle">
            <div class="one_half first">  
                <div class="one_half first">
                    <div>
                        <p><h4>Address</h4><?php echo $cinema->getStreet() . " " .$cinema->getNumber();?></p>
                    </div><br><br>
                    <div>
                        <p><h4>Phone</h4><?php echo $cinema->getPhone(); ?></p>
                    </div><br>
                    
                </div>

                <div class="one_half">
                    <div>
                        <p><h4>City-Country</h4>Mar del Plata-Argentina</p>
                    </div><br><br>
                    <div>
                        <p><h4>Email</h4><?php echo $cinema->getEmail();?></p>
                    </div>    
                </div>
                                
                <div class="one_half right">                 
                    <img class="cinemapic2 brd" src="<?php echo $cinema->getPoster();?>" alt="">
                </div>
            </div>  
        </div>
        <?php if($roomList){ ?>
            <div class="cardStyle mrg_top">
                <div>                        
                    <p><h4>Rooms</h4> </p>
                    <?php foreach($roomList as $room){ ?>
                        <p> <?php echo" ■ ".$room->getName()." $".$room->getPrice(); ?> </p>
                    <?php } ?>     
            </div>
    <?php }?>
        </div>
    </main>     
    <!-- ################################################################### BILLBOARD GALLERY ################################################################### -->
    <h2 class="page-title">Billboard</h2>
    <main class="hoc container clear" > 
        <div class="content" > 
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
                        else{ ?><div class="center"><h4 class="msg">No matching results</h4></div><?php
                        } ?>
                    </ul>
                </figure>
            </div>
        </div>
    </main>
</div>  

