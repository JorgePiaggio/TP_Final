<main class="py-5">
     <section id="listado" class="mb-5">
         <center>
          <form action="<?php echo FRONT_ROOT?>Home/Register" method="post">
          <div class="container">
               <h3 class="form-title">Register</h3><br>

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
                              <button type="submit" name="btn" class="btn btn-primary ml-auto d-block">Confirm</button>
                         </div>
                    </div>    
                    <?php
                 if($_GET){
                    echo $_GET["alert"];
                    }   ?>                
          </div>

          </form>
     
</center>
     </section>
</main>