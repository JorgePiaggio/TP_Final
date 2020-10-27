<main class="py-5">
          <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/jeffrey-gruszka-INzXqOHMh44-unsplash.jpg');">  
          <h2 class="page-title up2">Select Cinema</h2> 
               <form action="<?php echo FRONT_ROOT?>Cinema/showManageBillboard" class="center" method="post">
                         <div class="floating-label-form">
                         <div class="floating-label">
                                  <select name="selection cinema" class="selection">
                                      <?php var_dump($cinemaList);foreach($cinemaList as $cinema){ ?>
                                      <option value="<?php echo $cinema->getIdCinema(); ?>"><?php echo $cinema->getName(); ?></option>

                                      <?php }?>
                                    </select>
                              <br><br>
                              <div class="floating-label">
                                   <button type="submit" name="continue" class="btn btn-primary ml-auto d-block">Billboard</button><br><br>
                                        <?php if($this->msg){?> <h4 class="msg"><?php echo $this->msg;} ?></h4>
                              </div>
                         </div>            
               </form>
               
          </div>
</main>