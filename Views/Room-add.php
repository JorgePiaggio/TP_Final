<main class="py-5">
          <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/karen-zhao-jLRIsfkWRGo-unsplash.jpg');">  
          <h2 class="page-title up2">Add Room</h2> 
               <form action="<?php echo FRONT_ROOT?>Room/add" class="center" method="post">
                         <div class="floating-label-form">
                         <div class="floating-label">
                                  <select name="selection cinema" >
                                      <?php foreach($cinemaList as $cinema){ ?>
                                      <option value="<?php echo $cinema->getId(); ?>"><?php echo $cinema->getName(); ?></option>
                                      <?php }?>
                                  </select>
                              <div class="floating-label">
                                   <input type="number" name="number" placeholder=" " class="floating-input" required>
                                   <span class="highlight"></span><label for="">Number</label>
                              </div>                         

                              <div class="floating-label">
                                   <input type="number" name="size" placeholder=" " class="floating-input" required>
                                   <span class="highlight"></span><label for="">Capacity</label>
                              </div>

                              <div class="floating-label">
                                  <select name="typeRoom" >
                                      <option value="2D">2D</option>
                                      <option value="3D">3D</option>
                                  </select>
                                   <span class="highlight"></span><label for="">Type</label>
                              </div>
                              
                              <div class="floating-label">
                                  <select name="stateRoom" >
                                      <option value="1">Active</option>
                                      <option value="0">Inactive</option>
                                  </select>
                                   <span class="highlight"></span><label for="">State</label>
                              </div>
                              <br><br>
                              <div class="floating-label">
                                   <span>&nbsp;</span>
                                   <button type="submit" name="" class="btn btn-primary ml-auto d-block">Add</button><br><br>
                                   <li><?php if($this->msg){ echo $this->msg;} ?></li>
                              </div>
                         </div>            
               </form>
               
          </div>
</main>

