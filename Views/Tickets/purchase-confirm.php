<div class="bgded overlay gradient"> 
    <h2 class="page-title">Purchase</h2>
    <main class="hoc container clear"> 

        <div class="hoc cardStyle up">

            <div class=""><br>

                <table class="tablePurchase ">
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
                            <td><?php echo date('l d M - H:i', strtotime($show->getDateTime()))." hs " ?></td>  
                            <td><?php echo $show->getShift(); ?></td>  
                            <td><?php echo $show->getRoom()->getPrice(); ?></td>  
                        
                            <?php }?>
                        </tr> 
                    </tbody>
                </table>

            </div>

            <div class="">

                <table class="tablePurchase">
                    <thead class="bg-dark text-white">
                        <th>Tickets</th>
                        <th>Company</th>
                        <th>Card Number</th>
                        <th>Propietary</th>
                        <th>Expiration Date</th>                        
                        <th>Subtotal</th>
                        <th>Discount</th>
                        <th>Total</th>

                    </thead>
                    <tbody>
                        <?php if($show){ ?>
                        <tr>    
                            <td><?php echo count($seats); ?> </td>   
                            <td><?php echo $company;?></td>  
                            <td><?php echo $cardNumber; ?></td>  
                            <td><?php echo $propietary; ?></td>  
                            <td><?php echo $monthExp."/".$yearExp; ?></td>  
                            <td><?php echo $show->getRoom()->getPrice()*count($seats); ?></td>  
                            <td><?php if($discount){echo DISCOUNT." %";}else{ echo "-";} ?></td>  
                            <td><?php echo $total; ?></td>  
                        
                            <?php }?>
                        </tr> 
                    </tbody>
                </table>

            </div><br><br><br>

            <div>

                <form action="<?php echo FRONT_ROOT?>Ticket/add" class="center" method="post"><?php $exp=$monthExp."/".$yearExp;?>
                    <div>
                        <input type="hidden" name="company" value="<?php echo $company;?>">
                        <input type="hidden" name="cardNumber" value="<?php echo $cardNumber;?>">
                        <input type="hidden" name="propietary" value="<?php echo $propietary;?>">
                        <input type="hidden" name="expiration" value="<?php echo $exp;?>">
                        <input type="hidden" name="total" value="<?php echo $total;?>">
                        <input type="hidden" name="seats" value="<?php echo implode("/",$seats);?>">
                    </div>


                    <div>
                        <a href="<?php echo FRONT_ROOT?>Home/index"><button type="submit" class="btn inverse ml-auto d-block cancel" name="cancel" id="cancel" value="">Cancel</button> </a>
                        <button type="submit" name="confirm" value="<?php echo $show->getIdShow()?>" class="btn btn-primary ml-auto d-block">Confirm</button>
                    </div>
                </form>

            </div><br><br>

        </div>

  </main>
</div>




