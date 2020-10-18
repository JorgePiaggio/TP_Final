<main class="py-5">
     <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/toni-cuenca-bxoSoro8gd0-unsplash2.jpg');">  
          <h3 class="page-title up2">Register</h3><br>
          <form action="<?php echo FRONT_ROOT?>Client/register" class="center" method="post">
               <div class="container up2">
                    <div class="floating-label-form">
                         <div class="floating-label">
                              <input type="text" name="name" value="<?php if($_GET){echo $_GET["name"];}  ?>" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Name</label>
                         </div>  <br>

                         <div class="floating-label">
                              <input type="text" name="surname" value="<?php if($_GET){echo $_GET["surname"];}  ?>" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Surname</label>
                         </div>  <br>
                         <div class="floating-label">
                              <input type="text" name="dni" value="<?php if($_GET){echo $_GET["dni"];}  ?>" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">DNI</label>
                         </div>  <br>
                         <div class="floating-label">
                              <input type="text" name="street" value="<?php if($_GET){echo $_GET["street"];}  ?>" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Street</label>
                         </div> 
                         <div class="floating-label">
                              <input type="number" name="number" value="<?php if($_GET){echo $_GET["number"];}  ?>" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Number</label>
                         </div> <br> 
                         <div class="floating-label">
                              <input type="text" name="phone" value="<?php if($_GET){echo $_GET["phone"];}  ?>" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Phone</label>
                         </div>  <br>
                         
                         <div class="floating-label">
                              <input type="email" name="mail" value="<?php if($_GET){echo $_GET["email"];}  ?>" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Email</label>
                         </div>   <br>                      

                         <div class="floating-label">
                              <input type="password" name="pass" placeholder=" " class="floating-input" required>
                              <span class="highlight"></span><label for="">Password</label>
                         </div><br>
                         <div class="floating-label">
                              <input type="password" name="pass2" placeholder=" " class="floating-input" required>
                              <span class="highlight"></span><label for="">Re-type Password</label>
                         </div><br>

                         <div class="floating-label">
                              <span>&nbsp;</span>
                              <button type="submit" name="btn" class="btn btn2">Confirm</button>
                         </div>
                    </div><br>    
                    <?php if($_GET){echo $_GET["alert"];}?>                
               </div>
          </form>
     </div>
</main>