<main class="py-5">
          <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/karen-zhao-jLRIsfkWRGo-unsplash.jpg');">  
          <h2 class="page-title up2">Add Show</h2> <br>
          
          <div class="floating-label-form">
          <form action="<?php echo FRONT_ROOT?>Show/selectCinema" class="center" method="post">
          <div class="floating-label">
                                    <select name="selection cinema" class="selection" onchange="this.form.submit()">
                                    <?php if(!$cinemaList){?>
                                            <option value="">No Cinemas Found</option>
                                          <?php }?>
                                    <?php if($cinema){?>
                                    <option value="<?php echo $cinema->getIdCinema();?>" name="cinemasearch" selected disabled> <?php echo $cinema->getName(); ?></option>
                                    <?php }?>
                                        <?php foreach($cinemaList as $cinema){ ?>
                                        
                                        <option value="<?php echo $cinema->getIdCinema(); ?>" name="cinema"><?php echo $cinema->getName(); ?></option>
                                        <?php }?>
                                    </select>                    
                            </div>
          
                            </form>
               <form action="<?php echo FRONT_ROOT?>Show/add" class="center" method="post">
                         <div class="floating-label-form">
                           
                    
                            <div class="floating-label">
                                    <select name="selection room" class="selection">
                                          <?php if(!$roomList){?>
                                            <option value="">No Rooms Found</option>
                                          <?php }?>
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
                                        <?php foreach($movieList as $movie){ ?>
                                        <option value="<?php echo $movie->getTmdbId(); ?>"><?php echo $movie->getTitle(); ?></option>
                                        <?php }?>
                                    </select>                    
                            </div>
                            <div class="floating-label">
                              <input type="date" name="date2" value="" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Date</label>
                            </div> 
                            <div class="floating-label">
                              <input type="time" name="date" value="" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Time</label>
                            </div>
                                <?php if($cinemaList && $roomList && $movieList){?>
                                <button type="submit" name="" class="btn btn-primary ml-auto d-block">Add</button>
                                <?php 
                              } ?>
                            </div>
                              <br>
                             <?php if($this->msg != null){?> 
                                   <h4 class="msg"><?php  echo $this->msg;
                              } ?> </h4>
                         </div>            
               </form>
               </div>
          </div>
</main>


