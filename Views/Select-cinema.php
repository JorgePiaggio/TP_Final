<main class="py-5">
          <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/jeffrey-gruszka-INzXqOHMh44-unsplash.jpg');">  
          <h2 class="page-title up2">Select Cinema</h2> 
               <form action="<?php echo FRONT_ROOT?>Room/showRoomlist" class="center" method="post">
                         <div class="floating-label-form">
                         <div class="floating-label">
                                  <select name="selection cinema" class="selection">
                                      <?php foreach($cinemaList as $cinema){ ?>
                                      <option value="<?php echo $cinema->getId(); ?>"><?php echo $cinema->getName(); ?></option>
                                      <?php }?>
                                    </select>
                              <br><br>
                              <div class="floating-label">
                                   <button type="submit" name="continue" class="btn btn-primary ml-auto d-block">Continue</button><br><br>
                                
                              </div>
                         </div>            
               </form>
               
          </div>
</main>