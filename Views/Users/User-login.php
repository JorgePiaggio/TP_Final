<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container center up2 background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/maxence-pira-uX5nG3AKeXM-unsplash.jpg');">
               <h2 class="page-title">Login</h2><br>
               <form action="<?php echo FRONT_ROOT?>User/login" method="post">
                    <div class="floating-label-form">
                         <div class="floating-label">
                              <input type="email" maxlength="50" name="mail" placeholder="" class="floating-input" required>
                              <span class="highlight"></span><label for="">Email</label>
                         </div> <br>                      

                         <div class="floating-label">
                              <input type="password" maxlength="16" name="pass" placeholder=" " class="floating-input" required>
                              <span class="highlight"></span><label for="">Password</label>
                         </div><br>

                         <div class="floating-label">
                              <span>&nbsp;</span>
                              <button type="submit" name="btn" class="btn btn-primary ml-auto d-block">Confirm</button>
                         </div><br>
                    </div>

                    <!-- The JS SDK Login Button -->

                    <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
                    </fb:login-button>

                    <!---<div id="status">
                    </div>-->


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


<script>

  function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
    console.log('statusChangeCallback');
    console.log(response);                   // The current login status of the person.
    if (response.status === 'connected') {   // Logged into your webpage and Facebook.
      testAPI(); 
    } else {                                 // Not logged into your webpage or we are unable to tell.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this webpage.';
    }
  }


  function checkLoginState() {               // Called when a person is finished with the Login Button.
    FB.getLoginStatus(function(response) {   // See the onlogin handler
      statusChangeCallback(response);
    });
  }


  window.fbAsyncInit = function() {
    FB.init({
      appId      : '372444494104218',
      cookie     : true,                     // Enable cookies to allow the server to access the session.
      xfbml      : true,                     // Parse social plugins on this webpage.
      version    : 'v8.0'           // Use this Graph API version for this call.
    });

    FB.api(
  '/me',
  'GET',
  {"fields":"id,name,birthday,email"},
  function(response) {
     console.log('Good to see you, ' + response.name + '.');
  }
);

    FB.login(function(response) {
    if (response.authResponse) {
     console.log('Welcome!  Fetching your information.... ');
     FB.api('/me', function(response) {
       console.log('Good to see you, ' + response.email + '.');
     });
    } else {
     console.log('User cancelled login or did not fully authorize.');
    }
});
    

    FB.getLoginStatus(function(response) {   // Called after the JS SDK has been initialized.
      statusChangeCallback(response);        // Returns the login status.
    });
  };
 
  function testAPI() {                      // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.email);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.email + '!';
    });
  }

</script>


<!-- Load the JS SDK asynchronously -->
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>