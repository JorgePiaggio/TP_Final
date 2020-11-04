<script src= "https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"> </script> 
<script src= "https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"> </script> 
<div class="bgded overlay gradient">   
    <h2 class="page-title">Purchase Result</h2>
    <main class="hoc container clear"> 

        <div class="hoc cardStyle up">
            <div id="html-content-holder">      

                    <table class="tablePurchase tt">
                        <thead class="bg-dark text-white">
                            <th>User</th>
                            <th>Movie</th>
                            <th>Date</th>
                            <th>Shift</th>
                            <th>Price</th>
                            <th>Seat</th>                            
                            <th>QR Code</th>
                        </thead>
                        <tbody>
                            <?php 



                                if($tickets){ 
                                foreach($tickets as $ticket){?>
                                <tr>
                                    <td><p><?php echo $ticket->getBill()->getUser()->getName()."  ".$ticket->getBill()->getUser()->getSurname();?></p></td>
                                    <td><p><?php echo $ticket->getShow()->getMovie()->getTitle(); ?></p></td>  
                                    <td><p><?php echo date('l d M - H:i', strtotime($ticket->getShow()->getDateTime()))." hs"; ?></p></td>  
                                    <td><p><?php echo $ticket->getShow()->getShift(); ?></p></td>  
                                    <td><p><?php echo "$ ".$ticket->getShow()->getRoom()->getPrice(); ?></p></td>  
                                    <td><p><?php echo "Row: ".$ticket->getSeat()->getRow()."  Column:".$ticket->getSeat()->getNumber(); ?></p></td> 
                                    <?php  array_push($seats,$ticket->getSeat()->getRow()."-".$ticket->getSeat()->getNumber()); ?> 
                                    <td><img src=" <?php echo IMG_PATH."tickets/".$ticket->getSeat()->getRow().$ticket->getSeat()->getNumber().$ticket->getShow()->getIdShow().".png"?>";></td>
                                </tr> 
                                <?php }
                            } ?>
                            
                        </tbody>
                    </table><br><br>

            </div>

           


                        <center> 
                            <div class="hoc cardStyle fit">
                        <h2 class="orange"><?php echo "Total Price (With discount): $ ".$ticket->getBill()->getTotalPrice(); ?></h2>
                        <h2 class="orange"><?php echo "User: ".$ticket->getBill()->getUser()->getName()."  ".$ticket->getBill()->getUser()->getSurname(); ?></h2> 
                        <h2 class="orange"><?php echo "Payment Code: ".$ticket->getBill()->getCreditCardPayment()->getCode(); ?></h2> 
                            </div>   
                        <center> 

          


                <div class="hoc"><br>
                    <?php if($this->msg != null){?> 
                            <center><h4 class="msg"><?php  echo $this->msg;} ?> </h4></center>
                </div> <br><br>


            <div class="hoc">
                <input id="btn-Preview-Image" type="button" class="btn inverse ml-auto d-block" value="Preview" />  
                        
                <a id="btn-Convert-Html2Image" href="#" type="button" class="btn btn-primary ml-auto d-block"> Download </a> 

                <br/> <br><br>
                                            
                <div id="previewImage"></div> 
            </div>      

            <form id="formu" action="<?php echo FRONT_ROOT?>Ticket/showSendEmail"  name="formu" class="center" method="post">

   
            <input type="hidden" id="nombre" name="nombre" type="text" value="<?php echo $ticket->getBill()->getUser()->getName()."  ".$ticket->getBill()->getUser()->getSurname(); ?>" />
  

            <input type="hidden" id="email" name="email"  type="email" value="<?php echo $ticket->getBill()->getUser()->getEmail();?>" />
            <input type="hidden" id="seats" name="seats"  type="text" value="<?php echo implode("/",$seats);?>" />
            <input type="hidden" id="movie" name="movie"  type="text" value="<?php echo $ticket->getShow()->getMovie()->getTitle();?>" />
            <input type="hidden" id="date" name="date"  type="text" value="<?php echo $ticket->getShow()->getDateTime();?>" />
            <input type="hidden" id="cinema" name="cinema"  type="text" value="<?php echo $ticket->getShow()->getRoom()->getCinema()->getName();?>" />
            <input type="hidden" id="croom" name="room"  type="text" value="<?php echo $ticket->getShow()->getRoom()->getName();?>" />
            <input type="hidden" id="cant" name="cant"  type="text" value="<?php echo count($tickets);?>" />
            <input type="hidden" id="show" name="show"  type="text" value="<?php echo $ticket->getShow()->getIdShow();?>" />
    
                            
            <button id="btn-email"  value="" class="btn btn-primary ml-auto d-block" type="submit">Send Email</button>
            </form>


        </div> 
    </main>
</div>






<script> 
      $(document).ready(function() { 
        
          // Global variable 
          var element = $("#html-content-holder");  
        
          // Global variable 
          var getCanvas;  

          $("#btn-Preview-Image").on('click', function() { 
              html2canvas(element, { 
                  onrendered: function(canvas) { 
                      $("#previewImage").append(canvas); 
                      getCanvas = canvas; 
                  } 
              }); 

          }); 
          
          $("#btn-Convert-Html2Image").on('click', function() { 
              var imgageData =  
                  getCanvas.toDataURL("image/png"); 
            
              // Now browser starts downloading  
              // it instead of just showing it 
              var newData = imgageData.replace( 
              /^data:image\/png/, "data:application/octet-stream"); 
            
              $("#btn-Convert-Html2Image").attr( 
              "download", "Ticket.png").attr( 
              "href", newData); 
          }); 
      }); 
  </script> 

