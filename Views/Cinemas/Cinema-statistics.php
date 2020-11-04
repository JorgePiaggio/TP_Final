<div class="wrapper bgded overlay" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/tickets.jpg');">
    <h2 class="page-title"><?php echo $cinema->getName() . " - Stadistics" ?></h2>
    <div class="cardStyle">
<!-- ############################################################ ESTADÍSTICAS RECAUDACIÓN POR FECHAS ############################################################## -->
        <main class="hoc container clear"> 
            <div class="cardStyle">
                <h2 class="orange center">Statistics Cash <i class="fa fa-search" style="font-size: 1.73em"></i></h2>
            </div>

            <div class="cardStyle mrg_top">
                
                <div class="one_third">
                    <p> Choose date to search</p>  <br>
                    <div class="floating-label">
                        <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                            <input type="hidden" id="flag" name="flag" value="1">
                            <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                            <input type="date" name="date" value="" class="floating-input" required>
                            <span class="highlight"></span><label for="">Date </label>
                            <div> <br>
                                <button type="submit" name="search" class="btn btn-primary ml-auto d-block">Search</button>
                            </div>
                        </form>
                    
                        <div>
                                <?php if($flag == 1){ ?>
                                  <p class="p_green"> <?php echo "COLLECT: $$data" ?> </p> 
                                  <p class="p_white"> <?php echo "DATE: $date"; ?> </p>
                              <?php } ?> 
                        </div>
                    </div> 
                </div>         

                <div class="one_third">
                    <p> Choose month this year to search</p>  <br>
                        <div class="floating-label">
                            <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                                <input type="hidden" id="flag" name="flag" value="2">
                                <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                                <input type="number" max="<?php echo date('m') ?>" min="1" name="month" value="" class="floating-input" required>
                                <span class="highlight"></span><label for="">Month </label>
                                <div> <br>
                                    <button type="submit" name="search2" class="btn btn-primary ml-auto d-block">Search</button>
                                </div>
                            </form>
                        
                            <div>
                                    <?php if($flag == 2){ ?>
                                      <p class="p_green"> <?php echo "COLLECT: $$data" ?> </p> 
                                      <p class="p_white"> <?php echo "MONTH: $date"; ?> </p>
                              <?php } ?> 
                            </div>
                        </div>
                </div>
            

                <div class="one_quarter right">
                    <p> Choose year to search</p>  <br>
                    
                        <div class="floating-label">
                            <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                                <input type="hidden" id="flag" name="flag" value="3">
                                <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                                <input type="number" max="<?php echo date('Y') ?>" min="2020" name="year" value="" class="floating-input" required>
                                <span class="highlight"></span><label for="">Year </label> 
                                <div><br>
                                    <button type="submit" name="search3" class="btn btn-primary ml-auto d-block">Search</button>
                                </div>
                            </form>
                        
                            <div class="right">
                                    <?php if($flag == 3){ ?>
                                      <p class="p_green"> <?php echo "COLLECT: $$data" ?> </p> 
                                      <p class="p_white"> <?php echo "YEAR: $date"; ?> </p>
                              <?php } ?> 
                            </div>
                        </div>
                </div>
            </div>
        </main>

        

<!-- ############################################################## ESTADÍSTICAS TICKETS POR FECHAS ############################################################### -->
        <main class="hoc container clear"> 
            <div class="cardStyle">
                <h2 class="orange center">Statistics Tickets <i class="fa fa-ticket" style="font-size: 1.73em"></i>
            </div>

            <div class="cardStyle mrg_top">
                <div class="one_third">
                    <p> Choose date to search</p>  <br>
                    <div class="floating-label">
                        <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                            <input type="hidden" id="flag" name="flag" value="4">
                            <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                            <input type="date" name="date" value="" class="floating-input" required>
                            <span class="highlight"></span><label for="">Date </label>
                            <div> <br>
                                <button type="submit" name="search4" class="btn btn-primary ml-auto d-block">Search</button>
                            </div>
                        </form>
                     
                        <div>
                                <?php if($flag == 4){ ?>
                                  <p class="p_green"> <?php echo "TICKETS SOLD: $data" ?> </p>
                                  <p class="p_white"> <?php echo "DATE: $date"; ?> </p> 
                                <?php } ?> 
                        </div>
                    </div>
                </div>
            
           

                <div class="one_third">
                    <p> Choose month this year to search</p>  <br>
                        <div class="floating-label">
                            <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                                <input type="hidden" id="flag" name="flag" value="5">
                                <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                                <input type="number" max="<?php echo date('m') ?>" min="1" name="month" value="" class="floating-input" required>
                                <span class="highlight"></span><label for="">Month </label>
                                <div> <br>
                                    <button type="submit" name="search5" class="btn btn-primary ml-auto d-block">Search</button>
                                </div>
                            </form>
                        
                            <div>
                                <?php if($flag == 5){ ?>
                                  <p class="p_green"> <?php echo "TICKETS SOLD: $data" ?> </p>
                                  <p class="p_white"> <?php echo "MONTH: $date"; ?> </p> 
                                <?php } ?> 
                            </div>
                        </div>
                </div>
            

                <div class="one_quarter right">
                    <p> Choose year to search</p>  <br>
                        <div class="floating-label">
                            <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                                <input type="hidden" id="flag" name="flag" value="6">
                                <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                                <input type="number" max="<?php echo date('Y') ?>" min="2020" name="year" value="" class="floating-input" required>
                                <span class="highlight"></span><label for="">Year </label> 
                                <div><br>
                                    <button type="submit" name="search6" class="btn btn-primary ml-auto d-block">Search</button>
                                </div>
                            </form>
                        
                          <div class="right">
                              <?php if($flag == 6){ ?>
                                <p class="p_green"><?php  echo "TICKETS SOLD: $data" ?> </p>
                                <p class="p_white"> <?php echo "YEAR: $date"; ?> </p> 
                              <?php } ?> 
                          </div>
                        </div>
                </div>
            </div>

<!-- ######################################################### ESTADÍSTICAS TICKETS POR FECHAS POR TURNO ######################################################### -->
            <div class="cardStyle mrg_top">

                <div class="one_third">
                    <p> Choose date and shift to search</p>  <br>
                    <div class="floating-label">
                        <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                            <input type="hidden" id="flag" name="flag" value="7">
                            <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                            
                            <input type="date" name="date" value="" class="floating-input" required>
                            <span class="highlight"></span><label for="">Date </label> <br> <br>
                            <select name="shift" class="selection" required>
                                <option value="" selected disabled>Select Shift</option>                                        
                                <option value="Morning">Morning</option>
                                <option value="Afternoon">Afternoon</option>
                                <option value="Night">Night</option>
                            </select><br>  <br> 
                            <div> 
                                <button type="submit" name="search7" class="btn btn-primary ml-auto d-block">Search</button>
                            </div>
                        </form>
                    
                        <div>
                          <?php if($flag == 7){ ?>
                                  <p class="p_green"><?php  echo "TICKETS SOLD: $data" ?> </p>
                                  <p class="p_white"> <?php echo "DATE: $date - SHIFT: $shift"; ?> </p> 
                                <?php } ?> 
                        </div>
                    </div> 
                </div>
              
           

                <div class="one_third">
                    <p> Choose month this year and shift </p>  <br>
                    
                        <div class="floating-label">
                            <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                                <input type="hidden" id="flag" name="flag" value="8">
                                <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                                <input type="number" max="<?php echo date('m') ?>" min="1" name="month" value="" class="floating-input" required>
                                <span class="highlight"></span><label for="">Month </label> <br> <br>
                                <select name="shift" class="selection" required>
                                    <option value="" selected disabled>Select Shift</option>                                        
                                    <option value="Morning">Morning</option>
                                    <option value="Afternoon">Afternoon</option>
                                    <option value="Night">Night</option>
                                </select><br>  
                                <div> <br>
                                    <button type="submit" name="search8" class="btn btn-primary ml-auto d-block">Search</button>
                                </div>
                            </form>
                        
                            <div>
                              <?php if($flag == 8){ ?>
                                  <p class="p_green"><?php  echo "TICKETS SOLD: $data" ?> </p>
                                  <p class="p_white"> <?php echo "MONTH: $date - SHIFT: $shift"; ?> </p> 
                                <?php } ?> 
                            </div>
                        </div>
                </div>
            

                <div class="one_quarter right">
                    <p> Choose year and select shift</p>  <br>     
                        <div class="floating-label">
                            <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                                <input type="hidden" id="flag" name="flag" value="9">
                                <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                                <input type="number" max="<?php echo date('Y') ?>" min="2020" name="year" value="" class="floating-input" required>
                                <span class="highlight"></span><label for="">Year </label> <br> <br>
                                <select name="shift" class="selection" required>
                                    <option value="" selected disabled>Select Shift</option>                                        
                                    <option value="Morning">Morning</option>
                                    <option value="Afternoon">Afternoon</option>
                                    <option value="Night">Night</option>
                                </select><br>
                                <div><br>
                                    <button type="submit" name="search9" class="btn btn-primary ml-auto d-block">Search</button>
                                </div>
                            </form>
                            <div class="right">
                                <?php if($flag == 9){ ?>
                                  <p class="p_green"><?php  echo "TICKETS SOLD: $data" ?> </p>
                                  <p class="p_white"> <?php echo "YEAR: $date - SHIFT: $shift"; ?> </p> 
                                <?php } ?> 
                            </div>
                        </div>
                </div>
            </div>
           
<!-- ######################################################### ESTADÍSTICAS TICKETS POR PELICULA  ######################################################### -->
            <div class="cardStyle mrg_top">
                <div class="one_third right">
                    <p> Choose movie to search</p>  <br>
                    <div class="floating-label">
                        <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                            <input type="hidden" id="flag" name="flag" value="10">
                            <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                            <input type="hidden" id="date" name="date" value="">
                            <input type="hidden" id="shift" name="shift" value="">
                        
                            <select name="idMovie" class="selection" required>
                                <option value="" selected disabled>Select Movie</option>
                                
                                <?php if($allMovies){ 
                                    foreach($allMovies as $film){  ?>
                                      <option name="idMovie" value="<?php echo $film->getTmdbId(); ?>"> <?php echo $film->getTitle();?> </option>
                                <?php } 
                                }?>
                                
                            </select><br>  <br> 

                            <div> 
                                <button type="submit" name="search10" class="btn btn-primary ml-auto d-block">Search</button> 
                            </div>
                        </form>
                     
                      <div>
                        <?php if($flag == 10){ ?>
                                <p class="p_green"><?php  echo "TICKETS SOLD: $data" ?> </p>
                                <p class="p_white"> <?php echo "MOVIE: ".$movie2->getTitle()  ?> </p> 
                              <?php } ?> 
                      </div>
                    </div>
                </div>
            

              <div class="two_quarter right">
                    <p> Choose movie and shift to search</p>  <br>
                    <div class="floating-label">
                        <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                            <input type="hidden" id="flag" name="flag" value="11">
                            <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                            <input type="hidden" id="date" name="date" value="">

                            <select name="shift" class="selection" required>
                                    <option value="" selected disabled>Select Shift</option>                                        
                                    <option value="Morning">Morning</option>
                                    <option value="Afternoon">Afternoon</option>
                                    <option value="Night">Night</option>
                            </select>

                            <select name="idMovie" class="selection" required>
                                <option value="" selected disabled>Select Movie</option>
                                
                                <?php if($allMovies){ 
                                    foreach($allMovies as $film){  ?>
                                      <option name="idMovie" value="<?php echo $film->getTmdbId(); ?>"> <?php echo $film->getTitle();?> </option>
                                <?php } 
                                }?>     
                            </select> <br> <br>

                            

                            <div> 
                                <button type="submit" name="search11" class="btn btn-primary ml-auto d-block">Search</button> 
                            </div>
                        </form>
                     
                        <div>
                          <?php if($flag == 11){ ?>
                                  <p class="p_green"><?php  echo "TICKETS SOLD: $data" ?> </p>
                                  <p class="p_white"> <?php echo "MOVIE: ".$movie2->getTitle()." - SHIFT: ".$shift; ?> </p> 
                                <?php } ?> 
                        </div>
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
                  if($movieList){
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
                      } 
                    }   ?>
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



