<?php 

#session_start();

require './vendor/autoload.php';

$fb = new Facebook\Facebook([

    'app_id' => '372444494104218',
    'app_secret' => '584f98f8239ae686cc19ed7889d85138',
    'default_graph_version' => 'v2.7'

]);

$helper = $fb->getRedirectLoginHelper();
$loginUrl = $helper->getLoginUrl('http://localhost/TP_Final/User/showLogin');

# print_r($loginUrl);

/*try{    

    $accessToken= $helper->getAccessToken();

    if(isset($accessToken)){
        var_dump($accessToken);        
        $_SESSION['loggedUser']=(string)$accessToken;
    }

}catch(Exception $e){
        echo $e->getMessage();
}*/

if(empty($access_token)) {

 # echo "<a href='{$fb->getRedirectLoginHelper()->getLoginUrl("http://localhost/TP_Final/User/showLogin")}'>Login with Facebook </a>";
}

/*Step 3 : Get Access Token*/
$access_token = $fb->getRedirectLoginHelper()->getAccessToken();


/*Step 4: Get the graph user*/
if(isset($access_token)) {


  try {
      $response = $fb->get('/me',$access_token);

      $fb_user = $response->getGraphUser();

      echo  $fb_user->getName();




      //  var_dump($fb_user);
  } catch (\Facebook\Exceptions\FacebookResponseException $e) {
      echo  'Graph returned an error: ' . $e->getMessage();
  } catch (\Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
  }

}


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

                   
                   
                    <div class="floating-label">
                         <span>&nbsp;</span>
                         <a class="btn inverse" href="<?php echo "{$fb->getRedirectLoginHelper()->getLoginUrl('http://localhost/TP_Final/User/showLogin')}" ?>" >Log in with Facebook</a>
                    </div>   
                   
                   
                   

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


