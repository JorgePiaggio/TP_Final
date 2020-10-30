<main class="py-5">
    <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/nahuel-maretich-EeCQy8ZOmO0-unsplash.jpg');">  
        <h2 class="page-title up2">Edit Show</h2> <br>
          
          <div class="hoc">

              <div class="floating-label-form">
    
                <form action="<?php echo FRONT_ROOT?>Show/edit" class="center span" method="post">                           
                        
                                <div class="floating-label">
                                        <select name="selection room" class="selection">
                                              <?php if(!$roomList){?>
                                                <option value="">No Rooms Found</option>
                                              <?php }?>
                                              <option value="<?php echo $editShow->getRoom()->getIdRoom(); ?>" selected disabled><?php echo $editShow->getRoom()->getName(); ?></option>
                                            <?php foreach($roomList as $room){ ?>
                                                
                                            <option value="<?php echo $room->getIdRoom(); ?>"><?php echo $room->getName(); ?></option>
                                            <?php }?>
                                        </select>                    
                                </div>

                                <div class="floating-label">
                                        <select name="selection cinema" class="selection">
                                        <?php if(!$movieList){?>
                                                <option value="">No actives movies Found</option>
                                              <?php }?>
                                              <option value="<?php echo $editShow->getMovie()->getTmdbId(); ?>" selected disabled><?php if(strlen($editShow->getMovie()->getTitle())>30){$title=substr($editShow->getMovie()->getTitle(),0,30); echo $title."...";}else{echo $editShow->getMovie()->getTitle();} ?></option>
                                            <?php foreach($movieList as $movie){ ?>
                                                
                                                <option value="<?php echo $movie->getTmdbId(); ?>"><?php if(strlen($movie->getTitle())>30){$title=substr($movie->getTitle(),0,30); echo $title."...";}else{echo $movie->getTitle();} ?></option>
                                            <?php }?>
                                        </select>                    
                                </div>

                                <div class="floating-label">
                                  <input type="date" name="date2" value="" placeholder="" class="floating-input" required>
                                  <span class="highlight"></span><label for="">Date</label>
                                </div> 

                                <div class="floating-label">
                                  <input type="time" name="time" value="" placeholder="" class="floating-input" required>
                                  <span class="highlight"></span><label for="">Time</label>
                                </div>

                                <input type="hidden" name="tickets" value="<?php echo $editShow->getRemainingTickets(); ?>">

                                <div class="hoc"><br>
                                    <?php if($roomList && $movieList){?>
                                    <button type="submit" name="save show" value="<?php echo $editShow->getIdShow();?>" class="btn btn-primary ml-auto d-block">Save</button>
                                    <?php 
                                  } ?>
                                </div>

                                <div class="hoc"><br>
                                  <?php if($this->msg != null){?> 
                                        <h4 class="msg"><?php  echo $this->msg;
                                    } ?> </h4>
                                </div>            
                </form>
            </div>
          </div>

     </div>
</main>