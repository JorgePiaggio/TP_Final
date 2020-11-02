<div class="bgded overlay gradient"> 
    <h2 class="page-title">Purchase Result</h2>
    <main class="hoc container clear"> 

        <div class="hoc cardStyle">

            <div class="down">

                <table class="table bg-light">
                    <thead class="bg-dark text-white">
                        <th>QR</th>
                        <th>Movie</th>
                        <th>Date</th>
                        <th>Shift</th>
                        <th>Price</th>
                        <th>Seat</th>
                    </thead>
                    <tbody>
                        <?php if($tickets){ 
                            foreach($tickets as $ticket){?>
                            <tr>    
                            <td><img src="<?php echo $ticket->getQrcode(); ?>"></td>   
                            <td><?php echo $ticket->getShow()->getMovie()->getTitle(); ?></td>  
                            <td><?php echo $ticket->getShow()->getDateTime(); ?></td>  
                            <td><?php echo $ticket->getShow()->getShift(); ?></td>  
                            <td><?php echo $ticket->getShow()->getRoom()->getPrice(); ?></td>  
                            <td><?php echo "Row: ".$ticket->getSeat()->getRow()."  Column:".$ticket->getSeat()->getNumber(); ?></td>  
                            </tr> 
                            <?php }
                        }?>
                        
                    </tbody>
                </table><br><br>

                    <div class="cardStyle">
                    <center><h2 class="orange"><?php echo "Total Price (With discount): $ ".$ticket->getBill()->getTotalPrice(); ?></h2> </center>
                    <center><h2 class="orange"><?php echo "User: ".$ticket->getBill()->getUser()->getName()."  ".$ticket->getBill()->getUser()->getSurname(); ?></h2> </center>
                    </div>         
                                <div class="hoc"><br>
                                  <?php if($this->msg != null){?> 
                                        <center><h4 class="msg"><?php  echo $this->msg;
                                    } ?> </h4></center>
                                </div> <br><br>
            </div>
        </div>
    </main>
</div>
    