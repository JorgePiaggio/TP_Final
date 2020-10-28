<main class="py-5">
          <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/karen-zhao-jLRIsfkWRGo-unsplash.jpg');">  
          <h2 class="page-title up2">Add Show</h2> <br>
               <form action="<?php echo FRONT_ROOT?>Show/add" class="center" method="post">
                         <div class="floating-label-form">
                       
                            <div class="floating-label">
                                    <select name="selection room" class="selection">
                                        <?php foreach($roomList as $room){ ?>
                                        <option value="<?php echo $room->getIdRoom(); ?>"><?php echo $room->getName(); ?></option>
                                        <?php }?>
                                    </select>                    
                            </div>
                            <div class="floating-label">
                                    <select name="selection cinema" class="selection">
                                        <?php foreach($movieList as $movie){ ?>
                                        <option value="<?php echo $movie->getTmdbId(); ?>"><?php echo $movie->getTitle(); ?></option>
                                        <?php }?>
                                    </select>                    
                            </div>
                            <div class="floating-label">
                              <input type="date" name="date" value="" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Date</label>
                            </div> 
                            <div class="floating-label">
                              <input type="time" name="date" value="" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Time</label>
                            </div>
                                <button type="submit" name="" class="btn btn-primary ml-auto d-block">Add</button>
                            </div>
                              <br>
                             <?php if($this->msg != null){?> 
                                   <h4 class="msg"><?php  echo $this->msg;
                              } ?> </h4>
                         </div>            
               </form>
          </div>
</main>


