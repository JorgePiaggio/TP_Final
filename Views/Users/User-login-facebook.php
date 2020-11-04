<?php 

#session_start();

require './vendor/autoload.php';

$fb = new Facebook\Facebook([

    'app_id' => APPID,
    'app_secret' => APPSECRET,
    'default_graph_version' => GRAPHVERSION

]);
?>

<!-- *********************** FACEBOOK LOGIN ************************* -->
<?php/* if(empty($access_token)) { ?>
   
   <div class="floating-label">
        <a class="fa fa-facebook bb" href="<?php echo "{$fb->getRedirectLoginHelper()->getLoginUrl('https://localhost/TP_Final/User/showLogin',['email'])}" ?>" > <p> Log in with Facebook</p></a>
   </div><br><br>
  
 <?php
 /* Get Access Token*/
/*   $access_token = $fb->getRedirctLoginHelper()->getAccessToken();
 }
 
 /* Get the graph user*/
/* if(isset($access_token)){
                    
   try {
     // Returns a `FacebookFacebookResponse` object
     $response = $fb->get('/me?fields=email,id,first_name,last_name',$access_token);
   } catch(FacebookExceptionsFacebookResponseException $e) {
     echo 'Graph returned an error: ' . $e->getMessage();
     exit;
   } catch(FacebookExceptionsFacebookSDKException $e) {
     echo 'Facebook SDK returned an error: ' . $e->getMessage();
     exit;
   }

   $graphNode = $response->getGraphNode(); 
   var_dump($graphNode);
}*/
 ?>
 


