<?php 

#session_start();

require './vendor/autoload.php';

$fb = new Facebook\Facebook([

    'app_id' => APPID,
    'app_secret' => APPSECRET,
    'default_graph_version' => GRAPHVERSION

]); 

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

                   
                    <?php if(empty($access_token)) { ?>
                      
                    <div class="floating-label">
                         <span>&nbsp;</span>
                         <a class="btn inverse" href="<?php echo "{$fb->getRedirectLoginHelper()->getLoginUrl('http://localhost/TP_Final/User/showLogin')}" ?>" >Log in with Facebook</a>
                    </div>   
                   
                  <?php

                  /*Step 3 : Get Access Token*/
                  $access_token = $fb->getRedirectLoginHelper()->getAccessToken();
                  }
                  
                  /*Step 4: Get the graph user*/
                  if(isset($access_token)){
                    
                    try {
                   #     $response = $fb->get('/me?fields=id,name,email',$access_token);
                        $response = $fb->get('/me?locale=en_US&fields=name,email',$access_token);
                        $fb_user = $response->getGraphUser();

                        # var_dump($fb_user);
                        echo  $fb_user->getName();
                        
                    } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                        echo  'Graph returned an error: ' . $e->getMessage();
                    } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                        // When validation fails or other local issues
                        echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    }
                  
                  }
                  
                  
                  ?>
                   

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


