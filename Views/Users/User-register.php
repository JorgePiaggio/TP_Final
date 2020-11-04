<main class="py-5">
     <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/toni-cuenca-bxoSoro8gd0-unsplash2.jpg');">  
          <h3 class="page-title up2">Register</h3><br>
          <form action="<?php echo FRONT_ROOT?>User/register" class="center" method="post">
               <div class="container up2">
                    <div class="floating-label-form">
                         <div class="floating-label">
                              <input type="text" maxlength="50" name="name" value="<?php if($this->user != null){echo $this->user->getName();}  ?>" placeholder=" " class="floating-input" required>
                              <span class="highlight"></span><label for="">Name</label>
                         </div>  <br>

                         <div class="floating-label">
                              <input type="text" maxlength="50" name="surname" value="<?php if($this->user != null){echo $this->user->getSurname();}  ?>" placeholder=" " class="floating-input" required>
                              <span class="highlight"></span><label for="">Surname</label>
                         </div>  <br>
                         <div class="floating-label">
                              <input type="text" maxlength="10" name="dni" value="<?php if($this->user != null){echo $this->user->getDni();}  ?>" placeholder=" " class="floating-input" required>
                              <span class="highlight"></span><label for="">DNI</label>
                         </div>  <br>
                         <div class="floating-label">
                              <input type="text" maxlength="50" name="street" value="<?php if($this->user != null){echo $this->user->getStreet();} ?>" placeholder=" " class="floating-input" required>
                              <span class="highlight"></span><label for="">Street</label>
                         </div> 
                         <div class="floating-label">
                              <input type="number" max="100000" name="number" value="<?php if($this->user != null){echo $this->user->getNumber();}  ?>" placeholder=""  class="floating-input" required>
                              <span class="highlight"></span><label for="">Number</label>
                         </div> <br> 
                         
                         <div class="floating-label">
                              <input type="email" maxlength="50" name="mail" maxvalue="<?php if($this->user != null){echo $this->user->getEmail();}  ?>" placeholder=" " class="floating-input" required>
                              <span class="highlight"></span><label for="">Email</label>
                         </div>   <br>                      

                         <div class="floating-label">
                              <input type="password" maxlength="16" name="pass" placeholder=" " class="floating-input" required>
                              <span class="highlight"></span><label for="">Password</label>
                         </div><br>
                         <div class="floating-label">
                              <input type="password" maxlength="16" name="pass2" placeholder=" " class="floating-input" required>
                              <span class="highlight"></span><label for="">Re-type Password</label>
                         </div><br>

                         <div class="floating-label">
                              <button type="submit" name="btn" class="btn btn2">Confirm</button>
                         </div>
                    </div>
                    <br>    
                    <?php if($this->msg != null){ //Muestro un mensaje con el error en el registro
                         ?>  <h4 class="msg"><?php echo $this->msg;
                    } ?> </h4>               
               </div>
          </form>
     </div>
</main>