<main class="py-5">
     <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/toni-cuenca-bxoSoro8gd0-unsplash2.jpg');">  
          <h3 class="page-title up2">Register</h3><br>
          <form action="<?php echo FRONT_ROOT?>User/register" class="center" method="post">
               <div class="container up2">
                    <div class="floating-label-form">
                         <div class="floating-label">
                              <input type="text" name="name" value="<?php if($this->user != null){echo $this->user->getName();}  ?>" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Name</label>
                         </div>  <br>

                         <div class="floating-label">
                              <input type="text" name="surname" value="<?php if($this->user != null){echo $this->user->getSurname();}  ?>" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Surname</label>
                         </div>  <br>
                         <div class="floating-label">
                              <input type="text" name="dni" value="<?php if($this->user != null){echo $this->user->getDni();}  ?>" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">DNI</label>
                         </div>  <br>
                         <div class="floating-label">
                              <input type="text" name="street" value="<?php if($this->street != null){echo $this->street;} ?>" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Street</label>
                         </div> 
                         <div class="floating-label">
                              <input type="number" name="number" value="<?php if($this->number != null){echo $this->number;}  ?>" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Number</label>
                         </div> <br> 
                         <div class="floating-label">
                              <input type="text" name="phone" value="<?php if($this->user != null){echo $this->user->getPhone();}  ?>" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Phone</label>
                         </div>  <br>
                         
                         <div class="floating-label">
                              <input type="email" name="mail" value="<?php if($this->user != null){echo $this->user->geEmail();}  ?>" placeholder="" class="floating-input" required>
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
                    </div>
                    <br>    
                    <h1 class="msg"> <?php if($this->msg != null){ //Muestro un mensaje con el error en el registro
                         echo $this->msg;
                    } ?> </h1>               
               </div>
          </form>
     </div>
</main>