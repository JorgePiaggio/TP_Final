<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>

<?php if($show->getMovie()->getBackdropPath() != null) { ?>
<div class="bgded overlay gradient" style="background-image:url('https:\/\/image.tmdb.org\/t\/p\/w1280\/<?php echo $show->getMovie()->getBackdropPath() ?>');background-repeat:no-repeat;background-size:cover;"> 
    <?php }else { ?>
  <div class="bgded overlay gradient"> 
    <?php } ?>

    <h2 class="page-title">Purchase</h2>
    <main class="hoc container clear"> 

        
        <div class="hoc cardStyle">

            <div class="">

                <table class="table bg-light">
                    <thead class="bg-dark text-white">
                        <th>Room</th>
                        <th>Movie</th>
                        <th>Date</th>
                        <th>Shift</th>
                        <th>Price</th>
                    </thead>
                    <tbody>
                        <?php if($show){ ?>
                        <tr>    
                            <td><?php echo $show->getRoom()->getName(); ?> </td>   
                            <td><?php echo $show->getMovie()->getTitle(); ?></td>  
                            <td><?php echo $show->getDateTime(); ?></td>  
                            <td><?php echo $show->getShift(); ?></td>  
                            <td><?php echo $show->getRoom()->getPrice(); ?></td>  
                        
                            <?php }?>
                        </tr> 
                    </tbody>
                </table>

            </div>

            <form action="<?php echo FRONT_ROOT?>Ticket/showConfirm" id="form" class="center" method="post">        <!-- ELEGIR ASIENTO -->

            <div ><br> <br><h2 class="orange">Pick Your Seats</h2>
            
            <ul class="room cardStyle"><div class="screen"></div>
                <?php

                        for($cant = 0; $cant < $show->getRoom()->getRows(); $cant++){ 
                            for($cantidad = 0; $cantidad < $show->getRoom()->getColumns(); $cantidad++){
                                $flag = true;   //disponible

                                if($seats){
                                    foreach($seats as $seat){
                                        if($seat->getNumber() == $cantidad && $seat->getRow() == $cant){
                                            $flag=false;
                                         
                                        }
                                    }
                                }
                                if($flag){?>
                                <li class="seatTrue check">
                                    <input type="checkbox" class="seat"  name="seat[]" id="<?php echo $cant."-".$cantidad?>" value="<?php echo $cant."-".$cantidad?>"/>
                                    <label for="<?php echo $cant."-".$cantidad?>"></label>
                                </li>
                                <?php }else{ ?>
                                <li class="seatFalse check">
                                    <input type="checkbox" class="seat" id="<?php echo $cant."-".$cantidad?>" value="<?php echo $cant."-".$cantidad?>" disabled />
                                    <label for="<?php echo $cant."-".$cantidad?>"></label>
                                </li>
                                
                                <?php  
                                }
                            }?><br><?php
                        }?>
            </ul>
            </div><br><br>


            
                <div class="container up2"><h2 class="orange">Credit Card</h2>                                     <!-- DATOS TARJETA DE CREDITO -->
                        <div class="floating-label-form">
                            <div class="floating-label">
                                    <select name="company" class="selection" required>
                                            <?php ?>
                                            <option value="" selected disabled>Select Company</option>                                        
                                            <option value="Visa">Visa</option>
                                            <option value="Master">Master</option>
                                    </select><br>   <br>
                            
                            <div class="floating-label">
                                <input type="text" maxlength="16" minlength="16" name="cardNumber" value="" placeholder=" " class="floating-input" pattern="[0-9]+" required>
                                <span class="highlight"></span><label for="">Card Number</label>
                            </div> <br> 


                            <div class="floating-label">
                                <input type="text" maxlength="100" name="propietary" value="" placeholder=" " class="floating-input" required>
                                <span class="highlight"></span><label for="">Propietary</label>
                            </div> 
                            
                            <div>
                            <p> Expiration Date</p>  <br>

                            <span class="floating-label">
                                <input type="number" max="12" min="1" name="monthExp" value="" placeholder=""  class="floating-input" required>
                                <span class="highlight"></span><label for="">Month </label>
                                </span>

                            <span class="floating-label">
                                <input type="number" max="<?php echo (date("Y")+50); ?>" min="<?php echo date("Y"); ?>" name="yearExp" value="" placeholder=""  class="floating-input" required>
                                <span class="highlight"></span><label for="">Year</label>
                            </div> <br> 
                        </span>
                    

                                <div>
                                <button type="submit" name="confirm" id="checkBtn" value="<?php echo $show->getIdShow()?>" class="btn btn-primary ml-auto d-block">Confirm</button>
                                </div>
                        </div>
                        <br>    
                        <?php if($this->msg != null){ //Muestro un mensaje con el error en el registro
                            ?>  <h4 class="msg"><?php echo $this->msg;
                        } ?> </h4>               
                </div>
            </form>

        </div>

  </main>
</div>



<!-- VALIDAR AL MENOS UN CHECKBOX SELECCIONADO -->

<script type="text/javascript">
$(document).ready(function () {
    $('#checkBtn').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one checkbox.");
        return false;
      }

    });
});

</script>
