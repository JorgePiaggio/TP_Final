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
                        <p><h4>City-Country</h4> <?php echo $cinema->getCity() . " - " . $cinema->getCountry();?></p>
                    </div><br><br>
                    <div>
                        <p><h4>Email</h4><?php echo $cinema->getEmail();?></p>
                    </div>    
                </div>
                                
                <div class="one_half right">                 
                    <?php $address= $cinema->getNumber().$cinema->getStreet()." Mar del Plata";
                    if (isset($address))
                    {
                    $address = str_replace(" ", "+", $address);
                    ?>
                    <iframe class="map" width="200%" height="400" src="https://maps.google.com/maps?q=<?php echo $address; ?>&output=embed"></iframe>
                    <?php } ?>
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
</div>  
   
    <!-- ################################################################### BILLBOARD GALLERY ################################################################### -->
 <div class="gradient">
    <h2 class="page-title mrg_btm3">Billboard</h2>
    <div class="clear grid" > 
        <div class="hoc "></div>
            <?php if($movieList){
                    foreach($movieList as $movie){?>
                    
                        <div class="cardStyle mrg_btm3  mrg_sides">
                            <button type="" class="notCollapsible"><?php echo $movie->getTitle()?></button>

                            <div class="posterBillboard-hover-zoom posterBillboard-hover-zoom--slowmo">
                            <img class="posterBillboard posterBillboardHome" src="<?php echo $movie->getPoster()?>" alt="<?php echo $movie->getTitle()?> movie poster">
                            </div>

                            <div>
                                <button type="" class="notCollapsible nc2"><?php echo $movie->getGenres()[0]->getName()?></button>
                                <button type="button" class="collapsible">Show List</button>
                                    <div class="content1">
                                        <?php foreach($showList as $show){
                                                if($show->getMovie()->getTmdbId() == $movie->getTmdbId()){ ?>
                                                <a href="">
                                                    <p class="p_orange">
                                                    <?php if(strlen($show->getRoom()->getName()) > 13){
                                                            $str1 = substr($show->getRoom()->getName(), 0, 11) . '...';
                                                            echo "Room: ".$str1; ?></h6><?php }else{
                                                            echo "Room: ".$show->getRoom()->getName();}?>
                                                    </p> <hr>
                                                    <p class="p_white">
                                                    <?php echo date('l d M - H:i', strtotime($show->getDateTime()))." hs";?>
                                                    </p>
                                                </a><?php 
                                                }
                                            }?> 
                                    </div>

                            </div>

                        </div><?php
                    }
                }?>
                <div class="hoc"><br>
                            <?php if($this->msg != null){?> 
                                    <h4 class="msg"><?php  echo $this->msg;
                                } ?> </h4><br><br><br>
                </div>  
    </div><br><br><br><div id =”my-map” style = “width:800px; height:600px;”></div>
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


