<?php
define("APPID","372444494104218");
define("APPSECRET","584f98f8239ae686cc19ed7889d85138");
define("GRAPHVERSION",'v8.0');


if(!session_id()) {
  session_start();
}
require './vendor/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => APPID, // Replace {app-id} with your app id
  'app_secret' => APPSECRET,
  'default_graph_version' => GRAPHVERSION,
  ]);

$helper = $fb->getRedirectLoginHelper();
$_SESSION['FBRLH_state']=$_GET['state'];

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

// Logged in
echo '<h3>Access Token</h3>';
var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
echo '<h3>Metadata</h3>';
//var_dump($oAuth2Client);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId(APPID); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
    exit;
  }

  echo '<h3>Long-lived</h3>';
 // var_dump($accessToken->getValue());
}

$_SESSION['fb_access_token'] = (string) $accessToken;



  try {
    // Returns a `FacebookFacebookResponse` object
     $response = $fb->get('/me?fields=email,id,first_name,last_name',$accessToken);
  } catch(FacebookExceptionsFacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
  } catch(FacebookExceptionsFacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
  }

  $graphNode = $response->getGraphNode();
  
  if($graphNode){ 
    $_SESSION['facebookUser']['email']=$graphNode['email'];
    $_SESSION['facebookUser']['first_name']=$graphNode['first_name'];
    $_SESSION['facebookUser']['last_name']=$graphNode['last_name'];
    $_SESSION['facebookUser']['id']=$graphNode['id'];
    //var_dump($graphNode);

    // User is logged in with a long-lived access token.
    // You can redirect them to a members-only page.

    header('Location:User/userFacebook');

  }else{
    session_destroy();
    header('Location:User/login');

  }
?>