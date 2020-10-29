<main class="py-5">
          <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/ethan-robertson-nwfuaYecNUs-unsplash.jpg');">  
          <h2 class="page-title up2">Search user</h2> 
               <form action="<?php echo FRONT_ROOT?>User/showUserView" class="center" method="post">
                         <div class="floating-label-form">
                            <div class="floating-label">
                            <div class="floating-label">
                                   <input type="email" name="email" placeholder=" " class="floating-input" required>
                                   <span class="highlight"></span><label for="">Email</label>
                            </div>      
                            <br><br>
                            <div class="floating-label">
                                   <button type="submit" name="continue" class="btn btn-primary ml-auto d-block">Continue</button><br><br>
                                        <?php if($this->msg){ ?>
                                        <h4 class="msg"><?php echo $this->msg;} ?></h4>
                            </div>
                         </div>            
               </form>
               
          </div>
</main>