<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container center up2 background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/maxence-pira-uX5nG3AKeXM-unsplash.jpg');">
          <h2 class="page-title">Login</h2>
          <form action="<?php echo FRONT_ROOT?>Client/login" method="post">
                    <div class="floating-label-form">
                         <div class="floating-label">
                              <input type="email" name="mail" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Email</label>
                         </div> <br>                      

                         <div class="floating-label">
                              <input type="password" name="pass" placeholder=" " class="floating-input" required>
                              <span class="highlight"></span><label for="">Password</label>
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
     </section>
</main>