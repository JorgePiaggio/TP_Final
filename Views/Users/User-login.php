<?php 

#session_start();  
/*
if(!session_id()) {
     session_start();
}
*/

/* COMENTAR SI SE USA WAMPP */

require './vendor/autoload.php';

$fb = new Facebook\Facebook([

'app_id' => APPID,
'app_secret' => APPSECRET,
'default_graph_version' => GRAPHVERSION

]);

$helper = $fb->getRedirectLoginHelper(); 


$permissions = ['email']; // Optional permissions
$callbackUrl = htmlspecialchars('https://localhost/TP_Final/User-login-facebook.php');
$loginUrl = $helper->getLoginUrl($callbackUrl, $permissions);


/* COMENTAR SI SE USA WAMPP */

?>






<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container center up2 background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/maxence-pira-uX5nG3AKeXM-unsplash.jpg');">
               <h2 class="page-title">Login</h2><br>
               <form action="<?php echo FRONT_ROOT?>User/login" method="post">
                    <div class="floating-label-form">
                        <i class="fa fa-envelope" style="font-size: 1.73em"></i>
                        <div class="floating-label">  
                            <input type="email" maxlength="50" name="mail" placeholder="" class="floating-input" required>
                            <span class="highlight"></span><label for="">Email</label>
                        </div> <br>                      

                        <i class="fa fa-lock" style="font-size: 1.73em"></i>
                        <div class="floating-label">
                            
                            <input type="password" maxlength="16" name="pass" placeholder=" " class="floating-input" required>
                            <span class="highlight"></span><label for="">Password</label>
                        </div><br>

                        <div class="floating-label">
                            <span>&nbsp;</span>
                            <button type="submit" name="btn" class="btn btn-primary ml-auto d-block">Confirm</button>
                        </div><br>
                    </div>


                         <!-- *********************** FACEBOOK LOGIN ************************* -->
                         <div class="floating-label">
                         <a class="fa fa-facebook bb" href="<?php echo $loginUrl ?>" > <p> Log in with Facebook</p></a>
                         </div><br><br>

                 
                         <!-- *********************** FACEBOOK LOGIN ************************* -->


                    <!-- Muestro un mensaje si no existe mail o no coincide pass -->
                    <?php if($this->msg != null){?>      
                         <h4 class="msg"><?php echo $this->msg;
                         } ?>
                    </h4>   <br><br>

                    <div class="floating-label">
                         <h4 class="msg">Not registered?</h4>            
                    </div><br>

                    <div class="floating-label">
                         <span>&nbsp;</span>
                         <a class="btn inverse" href="<?php echo FRONT_ROOT?>User/showRegister">Register</a>
                    </div>              
               </form>
          </div>
     </section>
</main>


