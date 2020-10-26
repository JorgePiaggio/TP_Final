<main class="py-5">
          <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/jake-hills-23LET4Hxj_U-unsplash.jpg');">  
          <h2 class="page-title up2">Add Room</h2><br><br>
               <form action="<?php echo FRONT_ROOT?>Room/add" class="center" method="post">
                         <div class="floating-label-form">
                         <div class="floating-label">
                                  <select name="selection cinema" class="selection">
                                      <?php foreach($cinemaList as $cinema){ ?>
                                      <option value="<?php echo $cinema->getIdCinema(); ?>"><?php echo $cinema->getName(); ?></option>
                                      <?php }?>
                                  </select>
                              <div class="floating-label">
                                   <input type="name" name="name" placeholder=" " class="floating-input" required>
                                   <span class="highlight"></span><label for="">Name</label>
                              </div>                         

                              <div class="floating-label">
                                   <input type="number" name="size" placeholder=" " class="floating-input" required>
                                   <span class="highlight"></span><label for="">Capacity</label>
                              </div>

                              <div class="floating-label"><label for="" class="orange">Type</label>
                                  <select name="typeRoom" class="selection">
                                      <option value="2D">2D</option>
                                      <option value="3D">3D</option>
                                  </select>
                                   <span class="highlight"></span>
                              </div>
                              <div class="floating-label">
                                   <input type="number" name="price" placeholder=" " class="floating-input" required>
                                   <span class="highlight"></span><label for="">Price</label>
                              </div>
                              <br><br>
                              <div class="floating-label">
                                   <span>&nbsp;</span>
                                   <button type="submit" name="" class="btn btn-primary ml-auto d-block">Add</button><br><br>
                                   
                                   <?php if($this->msg){  //Si ya existe una sala con ese número en el mismo cine muestro el mensaje
                                        ?><h4 class="msg"> <?php echo $this->msg;} 
                                   ?></h4>
                              </div>
                         </div>            
               </form>
               
          </div>
</main>

