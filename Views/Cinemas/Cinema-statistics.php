<div class="wrapper bgded overlay" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/tickets.jpg');">
    <h2 class="page-title"><?php echo $cinema->getName() . " - Stadistics" ?></h2>
    <div class="cardStyle">
<!-- ################################################################### ESTADÍSTICAS RECAUDACIÓN ################################################################### -->
        <main class="hoc container clear"> 
            <div class="cardStyle">
                <h2 class="orange center">Statistics Cash <i class="fa fa-search" style="font-size: 1.73em"></i></h2>
            </div>

            <div class="cardStyle mrg_top">
                
                <div class="one_third">
                    <p> Choose date to search</p>  <br>
                    <div class="floating-label">
                        <form action="<?php echo FRONT_ROOT?>Ticket/showData/" class="center" method="post">
                            <input type="hidden" id="flag" name="flag" value="1">
                            <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                            <input type="date" name="date" value="" class="floating-input" required>
                            <span class="highlight"></span><label for="">Date </label>
                            <div> <br>
                                <button type="submit" name="search" class="btn btn-primary ml-auto d-block">Search</button>
                            </div>
                        </form>
                    </div> 
                    <div>
                            <?php if($data != -1 && $flag == 1){ ?>
                                <h4 class="msg"><?php  echo "Collection $date: $ $data";
                            } ?> </h4>
                    </div>
                </div>         

                <div class="one_third">
                    <p> Choose month this year to search</p>  <br>
                    
                        <span class="floating-label">
                            <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                                <input type="hidden" id="flag" name="flag" value="2">
                                <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                                <input type="number" max="<?php echo date('m') ?>" min="1" name="month" value="" class="floating-input" required>
                                <span class="highlight"></span><label for="">Month </label>
                                <div> <br>
                                    <button type="submit" name="search2" class="btn btn-primary ml-auto d-block">Search</button>
                                </div>
                            </form>
                        </span>
                        <div>
                                <?php if($data != -1 && $flag == 2){ ?>
                                    <h4 class="msg"><?php  echo "Collection month $date: $ $data";
                                } ?> </h4>
                        </div>
                </div>
            

                <div class="one_quarter right">
                    <p> Choose year to search</p>  <br>
                    
                        <span class="floating-label">
                            <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                                <input type="hidden" id="flag" name="flag" value="3">
                                <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                                <input type="number" max="<?php echo date('Y') ?>" min="2020" name="year" value="" class="floating-input" required>
                                <span class="highlight"></span><label for="">Year </label> 
                                <div><br>
                                    <button type="submit" name="search3" class="btn btn-primary ml-auto d-block">Search</button>
                                </div>
                            </form>
                        </span>
                        <div class="right">
                                <?php if($data != -1 && $flag == 3){ ?>
                                    <h4 class="msg"><?php  echo "Collection year $date: $ $data";
                                } ?> </h4>
                        </div>
                </div>
            </div>
        </main>

<!-- ################################################################### ESTADÍSTICAS RECAUDACIÓN ################################################################### -->
        <main class="hoc container clear"> 
            <div class="cardStyle">
                <h2 class="orange center">Statistics Tickets <i class="fa fa-ticket" style="font-size: 1.73em"></i>
            </div>

            <div class="cardStyle mrg_top">
                <div class="one_third">
                    <p> Choose date to search</p>  <br>
                    <div class="floating-label">
                        <form action="<?php echo FRONT_ROOT?>Ticket/showData/" class="center" method="post">
                            <input type="hidden" id="flag" name="flag" value="4">
                            <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                            <input type="date" name="date" value="" class="floating-input" required>
                            <span class="highlight"></span><label for="">Date </label>
                            <div> <br>
                                <button type="submit" name="search4" class="btn btn-primary ml-auto d-block">Search</button>
                            </div>
                        </form>
                    </div> 
                    <div>
                            <?php if($data != -1 && $flag == 4){ ?>
                                <h4 class="msg"><?php  echo "Tickets Sold $date: $data";
                            } ?> </h4>
                    </div>
                </div>
            
           

                <div class="one_third">
                    <p> Choose month this year to search</p>  <br>
                    
                        <span class="floating-label">
                            <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                                <input type="hidden" id="flag" name="flag" value="5">
                                <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                                <input type="number" max="<?php echo date('m') ?>" min="1" name="month" value="" class="floating-input" required>
                                <span class="highlight"></span><label for="">Month </label>
                                <div> <br>
                                    <button type="submit" name="search5" class="btn btn-primary ml-auto d-block">Search</button>
                                </div>
                            </form>
                        </span>
                        <div>
                                <?php if($data != -1 && $flag == 5){ ?>
                                    <h4 class="msg"><?php  echo "Tickets Sold $date: $data";
                                } ?> </h4>
                        </div>
                </div>
            

                <div class="one_quarter right">
                    <p> Choose year to search</p>  <br>
                    
                        <span class="floating-label">
                            <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                                <input type="hidden" id="flag" name="flag" value="6">
                                <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                                <input type="number" max="<?php echo date('Y') ?>" min="2020" name="year" value="" class="floating-input" required>
                                <span class="highlight"></span><label for="">Year </label> 
                                <div><br>
                                    <button type="submit" name="search6" class="btn btn-primary ml-auto d-block">Search</button>
                                </div>
                            </form>
                        </span>
                        <div class="right">
                                <?php if($data != -1 && $flag == 6){ ?>
                                    <h4 class="msg"><?php  echo "Tickets Sold $date: $data";
                                } ?> </h4>
                        </div>
                </div>
            </div>
        </main>

       
    </div>
</div>

<!-- ################################################################### BILLBOARD GALLERY ################################################################### -->
<div class="bordo">
  <div class="container ctr"> 
                       <!------------------------------------------------ CONTENT ------------------------------------------------>
    <h2 class="page-title up2 www">Billboard</h2>
    <div class="bkg">
      <main class="container clear " >         

                        <!------------------------------------------------ GALLERY ------------------------------------------------>
        <div class=" padSides">

              <?php $indice=0;
                  foreach($movieList as $movie){
                      if($indice % 4 == 0){?>
                      
                        <!------------------------------------------------ PRIMER CUARTO ------------------------------------------->
        
                        <div class="one_quarter first mrg_btm up">
                          <div class="cardStyle mrg_sides">

                          <button type="" class="notCollapsible"><?php echo $movie->getTitle()?></button>
                          
                            <div class="posterBillboard-hover-zoom posterBillboard-hover-zoom--slowmo">
                              <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movie->getTmdbID()?>">
                                <img class="posterBillboard" src="<?php echo $movie->getPoster()?>" alt="<?php echo $movie->getTitle()?> movie poster">
                              </a>
                            </div>
          
                            <div>
                              <button type="button" class="collapsible">Show List</button>
                              <div class="content1">
                                <?php  foreach($showList as $show){
                                          if($show->getMovie()->getTmdbId() == $movie->getTmdbId()){ ?>
                                            <a href="<?php echo FRONT_ROOT?>/Ticket/showPurchaseView/<?php echo $show->getIdShow()?>">
                                            <p class="p_orange">
                                                    <?php if(strlen($show->getRoom()->getName()) > 13){
                                                            $str1 = substr($show->getRoom()->getName(), 0, 11) . '...';
                                                            echo $str1; ?></h6><?php }else{
                                                            echo $show->getRoom()->getName();}?>
                                            </p> <hr>
                                              <p class="p_white">
                                                <?php echo date('l d M - H:i', strtotime($show->getDateTime()))." hs ";?>
                                              </p>
                                              <?php $ticketsSold = $show->getRoom()->getCapacity() - $show->getRemainingTickets(); ?>
                                                <p class="p_green"> <?php echo "Tickets sold: $ticketsSold";  ?> </p>
                                                <p class="p_red"> <?php echo "Remaining tickets: " . $show->getRemainingTickets(); ?></p>
                                              
                                            </a><?php 
                                          }
                                        } ?> 
                              </div> 
                            </div>

                          </div>
                        </div>
        
                          <?php 
                      } else { ?>
        
                              <!------------------------------------------------ LOS OTROS CUARTOS ---------------------------------->

                        <div class="one_quarter mrg_btm up">
                          <div class="cardStyle mrg_sides">
                            
                          <button type="" class="notCollapsible"><?php echo $movie->getTitle()?></button>

                            <div class="posterBillboard-hover-zoom posterBillboard-hover-zoom--slowmo">
                            <a href="<?php echo FRONT_ROOT?>Movie/showMovie/<?php echo $movie->getTmdbID()?>">
                              <img class="posterBillboard" src="<?php echo $movie->getPoster()?>" alt="<?php echo $movie->getTitle()?> movie poster">
                            </a>
                            </div>
            
                            <div>
                              <button type="button" class="collapsible">Show List</button>
                              <div class="content1">
                              <?php foreach($showList as $show){
                                          if($show->getMovie()->getTmdbId() == $movie->getTmdbId()){ ?>
                                            <a href="<?php echo FRONT_ROOT?>/Ticket/showPurchaseView/<?php echo $show->getIdShow()?>">
                                                <p class="p_orange">
                                                    <?php if(strlen($show->getRoom()->getName()) > 13){
                                                            $str1 = substr($show->getRoom()->getName(), 0, 11) . '...';
                                                            echo $str1; ?></h6><?php }else{
                                                            echo $show->getRoom()->getName();}?>
                                                </p> <hr>
                                              <p class="p_white">
                                                <?php echo date('l d M - H:i', strtotime($show->getDateTime()))." hs ";?>
                                              </p>
                                              <?php $ticketsSold = $show->getRoom()->getCapacity() - $show->getRemainingTickets(); ?>
                                                <p class="p_green"> <?php echo "Tickets sold: $ticketsSold";  ?> </p>
                                                <p class="p_red"> <?php echo "Remaining tickets: " . $show->getRemainingTickets(); ?></p>
                                            </a><?php 
                                          }
                                      }?> 
                              </div> 
                            </div>
                            </div>
                          </div>
                        <?php 
                      } $indice++;
                    }  ?>
                                 <!------------------------------------------- Error message ---------------------------------------------------------------->
                    <div class="hoc" margin-left="40%"><br>
                      <?php if($this->msg != null){?> 
                            <h4 class="msg"><?php  echo $this->msg;
                        } ?> </h4>
                    </div>      

                                  <!----------------------------------------------------------------------------------------------------------->
        </div>     
      </main>
    </div>
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



