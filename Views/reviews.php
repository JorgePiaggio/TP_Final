
<div class="container center background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/sonder-quest-pRh9RiynHGE-unsplash.jpg');;background-repeat:no-repeat;background-size:cover;">
     <h2 class="page-title up2">User Reviews</h2>  
     <main class="hoc container clear" > 
          <div class="content" > 
               <ul class="nospace center up">
                    <?php foreach ($messageList as $message){ ?>
                         <form action="#" method="post">
                              <div class="cardStyle mrg_btm">
                                   <li style="none">
                                        <div class="one_half first">
                                             <h4 class="orange"><?php echo "Message"?></h4>
                                             <p><?php echo $message[1]?></p><br><br>
                                        </div>
                                        <div class="one_quarter">
                                             <h4 class="orange"><?php echo "User"?></h4>
                                             <p><?php echo $message[2];?></p><br><br>
                                        </div>
                                        <div class="one_quarter">
                                             <div class="one_quarter">
                                                  <button type="submit" class="btn" name="delete" value="<?php echo $message[0]?>">Delete</button>
                                             </div>
                                        </div>
                                   </li>
                              </div>
                         </form><?php
                    }?>   
               </ul>
          </div>
     </main>
</div>


