<main class="py-5">
          <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/karen-zhao-jLRIsfkWRGo-unsplash.jpg');">  
          <h2 class="page-title up2">Add Cinema</h2> 
               <form action="<?php echo FRONT_ROOT?>Cinema/add" class="center" method="post">
                         <div class="floating-label-form">
                              <div class="floating-label">
                                   <input type="text" name="name" placeholder=" " class="floating-input" required>
                                   <span class="highlight"></span><label for="">Name</label>
                              </div>                         

                              <div class="floating-label">
                                   <input type="text" name="street" placeholder=" " class="floating-input" required>
                                   <span class="highlight"></span><label for="">Street</label>
                              </div>

                              <div class="floating-label">
                                   <input type="number" name="number" placeholder=" " class="floating-input" required>
                                   <span class="highlight"></span><label for="">Number</label>
                              </div>
                              <br>
                              <div class="floating-label">
                                   <input type="number" name="phone" placeholder=" " class="floating-input" required>
                                   <span class="highlight"></span><label for="">Phone</label>
                              </div>

                              <div class="floating-label">
                                   <input type="email" name="email" placeholder=" " class="floating-input" required>
                                   <span class="highlight"></span><label for="">Email</label>
                              </div>

                              <div class="floating-label">
                                   <input type="number" name="price" placeholder=" " class="floating-input" required>
                                   <span class="highlight"></span><label for="">Price</label>
                              </div>
                              <br><br>
                              <div class="floating-label">
                                   <span>&nbsp;</span>
                                   <button type="submit" name="" class="btn btn-primary ml-auto d-block">Add</button>
                              </div>
                              <br>
                              <?php if($this->msg != null){ //Si el cine ya existe muestra el mensaje
                                   echo $this->msg;
                              } ?>
                         </div>            
               </form>
          </div>
</main>


