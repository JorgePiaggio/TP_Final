<main class="py-5">
    <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/voice-video-MF0JEFvNBeQ-unsplash.jpg');">  
        <h2 class="page-title up2">Add Show</h2> <br>
          
          <div class="hoc"><br><br>

              <div class=" floating-label-form">
                <?php if($cinemaList){?>
                <form action="<?php echo FRONT_ROOT?>Show/selectCinema" class=" hoc center span" method="post">
                                <div class="floating-label">
                                        <select name="selection cinema" class="selection" required onchange="this.form.submit()" required >
                                      
                                            
                                          
                                            <?php if($cinema){?>
                                          <option value="<?php echo $cinema->getIdCinema();?>" name="cinemasearch" selected disabled> <?php echo $cinema->getName(); ?></option>
                                            <?php }?>
                                              <?php foreach($cinemaList as $cinema){ ?>
                                          <option value="<?php echo $cinema->getIdCinema(); ?>" name="cinema"><?php echo $cinema->getName(); ?></option>
                                              <?php }?>
                                        </select>                    
                                </div><br><br>
                </form>


                <form action="<?php echo FRONT_ROOT?>Show/add" class="center hoc span" method="post">                           
                        
                                <div class="floating-label">
                                        <select name="selection room" class="selection" required>
                                        <option value="" selected disabled>Select Room</option>                                        
                                              <?php if(!$roomList){?>
                                                <option value="">No Rooms Found</option>
                                              <?php }?>
                                            <?php foreach($roomList as $room){ ?>
                                            <option value="<?php echo $room->getIdRoom(); ?>"><?php echo $room->getName(); ?></option>
                                            <?php }?>
                                        </select>                    
                                </div><br><br>
                              <div>
                                  <div class="floating-label">
                                          <select name="selection cinema" class="selection" required>
                                          <option value="" selected disabled>Select Movie</option>                                        
                                          <?php if(!$movieList){?>
                                                  <option value="">No actives movies Found</option>
                                                <?php }?>
                                              <?php foreach($movieList as $movie){ ?>
                                              <option value="<?php echo $movie->getTmdbId(); ?>"><?php if(strlen($movie->getTitle())>30){$title=substr($movie->getTitle(),0,30); echo $title."...";}else{echo $movie->getTitle();} ?></option>
                                              <?php }?>
                                          </select>                    
                                  </div>
                              </div><br><br>

                              <div class="">
                                  <div class="floating-label">
                                    <input type="date" name="date2" value="" placeholder="" min="<?php echo date('Y-m-d');?>" class="floating-input" required>
                                    <span class="highlight"></span><label for="">Date</label>
                                  </div> 

                                  <div class="floating-label">
                                    <input type="time" name="date" value="" placeholder="" class="floating-input" required>
                                    <span class="highlight"></span><label for="">Time</label>
                                  </div>
                              </div><br>

                              <div class="hoc"><br>
                                  <?php if($cinemaList && $roomList && $movieList){?>
                                  <button type="submit" name="" class="btn btn-primary ml-auto d-block">Add</button>
                                  <?php 
                                } ?>
                              </div>

                              <div class="hoc"><br>
                                <?php if($this->msg != null){?> 
                                      <h4 class="msg"><?php  echo $this->msg;
                                  } ?> </h4>
                              </div>            
                </form>
              <?php } 
                else { ?>
                  <center><h4 class="msg">No cinemas found</h4></center>
         <?php  } ?>
            </div>
          </div>

     </div>
</main>


