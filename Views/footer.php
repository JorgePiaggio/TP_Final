    <!-- ########################################### LINKS ##################################################### -->
    <div class="wrapper quicklinks">
  <nav class="hoc clear"> 
    <ul class="nospace center">
      <li><a href="<?php echo FRONT_ROOT?>Home/index"><i class="fa fa-lg fa-home"></i></a></li>
      <li><a href="<?php echo FRONT_ROOT?>Movie/showAllMovies">Movies</a></li>
      <li><a href="#">Cinemas</a></li>
      <li><a href="#footer">About</a></li>
      <li><a href="#">FAQ</a></li>
      <li><a href="#">Blog</a></li>
    </ul>
  </nav>
</div>
    <!-- ########################################### ABOUT US ##################################################### -->
<div class="wrapper row4">
<footer id="footer" class="hoc clear"> 
    <div class="one_third first">
      <h6 class="heading">About us</h6>
      <p>We are the #1 website for cinemas.<br><br>Add your cinema.<br><br> Work with us.<br><br></p>
      <ul class="faico clear">
        <li><a class="faicon-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
        <li><a class="faicon-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
        <li><a class="faicon-dribble" href="#"><i class="fa fa-dribbble"></i></a></li>
        <li><a class="faicon-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
        <li><a class="faicon-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
        <li><a class="faicon-vk" href="#"><i class="fa fa-vk"></i></a></li>
      </ul>
    </div>
     <!-- ########################################### CONTACT ##################################################### -->
    <div class="one_third">
      <h6 class="heading">Contact</h6>
      <ul class="nospace linklist contact">
        <li><i class="fa fa-map-marker"></i>
          <address>Calle Falsa 123, Mar del Plata, Argentina.</address>
        </li>
        <li><i class="fa fa-phone"></i> +54 (223) 456 7890</li>
        <li><i class="fa fa-fax"></i> +54 (223) 456 7890</li>
        <li><i class="fa fa-envelope-o"></i> info@moviepass.com</li>
      </ul>
    </div>
     <!-- ########################################### SEND REVIEW FORM ##################################################### -->
    <div class="one_third">
      <h6 class="heading review">Send your review</h6>
      <form action="<?php echo FRONT_ROOT?>" method="post">       <!-- ### completar ### -->
          <div class="floating-label-form">
                <div class="floating-label">
                    <input type="email" name="mail" placeholder="" class="floating-input reviewMail" required>
                    <span class="highlight"></span><label for="">Your Email</label>
                </div><br>                      

                <div class="floating-label">
                <textarea name="message" cols="19" rows="5" placeholder="" class="floating-input reviewTextarea" required></textarea>
                    <span class="highlight"></span><label for="">Your Message</label>
                </div><br>

                <div class="floating-label">
                    <button type="submit" name="sendReview" class="btn btn-primary send">Send</button>
                </div>
          </div>             
        </form>
    </div>
    </div>
    <!-- ########################################### COPYRIGHT ##################################################### -->
  <div class="wrapper row6"><hr class="orangeHr">
    <div id="copyright" class="hoc clear"> 
      <p class="center">Copyright &copy; 2020 - All Rights Reserved - <a href="#">localhost.com - </a>Template by <a target="_blank" href="https://www.os-templates.com/" title="Free Website Templates">OS Templates</a></p>
    </div>
  </div>
</footer>

    <!-- ############################################ JAVASCRIPTS #################################################### -->
<script src="<?php echo SCRIPT_PATH ?>jquery.min.js"></script> 
<script src="<?php echo SCRIPT_PATH ?>jquery.backtotop.js"></script>
<script src="<?php echo SCRIPT_PATH ?>jquery.mobilemenu.js"></script>
<script src="<?php echo SCRIPT_PATH ?>jquery.flexslider-min.js"></script>
</body>
</html>
