<div class="wrapper bgded overlay" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/roll.jpg');">
    <h2 class="page-title"><?php echo $cinema->getName() ?></h2>
    <main class="hoc container clear"> 
        <div class="cardStyle orange">

            <div class="one_half first">    

                <div class="one_half first mrg_top">
                    <div>
                        <h4>Address</h4><p><?php echo $cinema->getStreet() . " " .$cinema->getNumber();?></p>
                    </div><br><br>
                    <div>
                        <h4>Phone</h4><p><?php echo $cinema->getPhone(); ?></p>
                    </div><br> 
                    <div>
                        <h4>Total Capacity</h4><p><?php echo $cinemaCapacity; ?></p>
                    </div><br> 
                </div>

                <div class="one_half mrg_top">
                    <div>
                        <h4>City - Country</h4><p> <?php echo $cinema->getCity() . " - " . $cinema->getCountry();?></p>
                    </div><br><br>
                    <div>
                        <h4>Email</h4><p><?php echo $cinema->getEmail();?></p>
                    </div>    
                </div>
              
            </div>  
       

            <div class="one_half">      
                    <?php $address= $cinema->getNumber().$cinema->getStreet().$cinema->getCity().$cinema->getCountry();
                    if (isset($address))
                    {
                    $address = str_replace(" ", "+", $address);
                    ?>
                    <iframe class="map" width="100%" height="400" src="https://maps.google.com/maps?q=<?php echo $address; ?>&output=embed"></iframe>
                    <?php } ?>
            </div> 

        </div>


            <?php if($roomList){ ?>
            <div class="cardStyle hoc orange mrg_top">
                <center>
                <h4><u> Rooms</u></h4>


                <div class="one_third first"> 
                    <p class="orange2">Name</p>
                </div>

                <div class="one_third"> 
                    <p class="orange2">Capacity</p>
                </div>

                <div class="one_third"> 
                    <p class="orange2">Price</p>
                </div>




                <div class="one_third first"> 
                    <?php foreach($roomList as $room){ ?>
                        <p> <?php echo" ■ ".$room->getName()?> </p>
                        <?php } ?>    
                </div>

                <div class="one_third"> 
                    <?php foreach($roomList as $room){ ?>
                        <p> <?php echo $room->getCapacity(); ?> </p>
                        <?php } ?>    
                </div>

                <div class="one_third"> 
                    <?php foreach($roomList as $room){ ?>
                        <p> <?php echo "$ ".$room->getPrice(); ?> </p>
                        <?php } ?>    
                </div>

                </center>
            </div>
            <?php }?>


    </main>  
</div>  
   
    <!-- ################################################################### BILLBOARD GALLERY ################################################################### -->
 <div class="gradient">
    <h2 class="page-title mrg_btm3">Billboard</h2>
    <div class="clear grid" > 
        <div class="hoc"></div>
            <?php if($movieList){
                    foreach($movieList as $movie){?>
                    
                        <div class="cardStyle mrg_btm3  mrg_sides">
                            <button type="" class="notCollapsible"><?php echo $movie->getTitle()?></button>

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
                                                    <?php if(strlen($show->getRoom()->getName()) > 13){
                                                            $str1 = substr($show->getRoom()->getName(), 0, 11) . '...';
                                                            echo "Room: ".$str1; ?></h6><?php }else{
                                                            echo "Room: ".$show->getRoom()->getName();}?>
                                                    </p> <hr>
                                                    <p class="p_white">
                                                    <?php echo date('l d M - H:i', strtotime($show->getDateTime()))." hs";?>
                                                    <i class="fa fa-ticket" style="font-size: 1.73em"></i>
                                                    </p>
                                                </a><?php 
                                                }
                                            }
                                        }else{
                                            foreach($showList as $show){
                                                if($show->getMovie()->getTmdbId() == $movie->getTmdbId()){ ?>
                                                    <p class="p_orange">
                                                    <?php if(strlen($show->getRoom()->getName()) > 13){
                                                            $str1 = substr($show->getRoom()->getName(), 0, 11) . '...';
                                                            echo "Room: ".$str1; ?></h6><?php }else{
                                                            echo "Room: ".$show->getRoom()->getName();}?>
                                                    </p> <hr>
                                                    <p class="p_white">
                                                    <?php echo date('l d M - H:i', strtotime($show->getDateTime()))." hs";?>
                                                    <i class="fa fa-ticket" style="font-size: 1.73em"></i>
                                                    <?php echo "Login" ?>
                                                    </p>
                                                <?php
                                                }
                                            } 
                                        }?> 
                                    </div>

                            </div>

                                    </div><?php }
                    }?>
                        
        </div> 
               
    </div>

    <div class="center noBack"><br><br>
        <?php if($this->msg != null){?> 
        <h4 class="msg"><?php  echo $this->msg;} ?> </h4><br><br><br><br><br><br>
    </div>

</div>

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


