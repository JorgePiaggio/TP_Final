<main class="py-5">
     <section id="listado" class="mb-5">
         <center>
          <form action="<?php echo FRONT_ROOT?>Home/Login" method="post">
          <div class="container">
               <h3 class="form-title">Login</h3>

                    <div class="floating-label-form">
                         <div class="floating-label">
                              <input type="email" name="mail" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Email</label>
                         </div>  <br>                       

                         <div class="floating-label">
                              <input type="password" name="pass" placeholder=" " class="floating-input" required>
                              <span class="highlight"></span><label for="">PassWord</label>
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