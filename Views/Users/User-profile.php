<div class="background-pic profile" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/agnieszka-kowalczyk-c0VRNWVEjOA-unsplash.jpg');">
    <main class="py-5">
        <h2 class="page-title">Profile</h2>
                    <div>

                    <!---------------------------------------------- USER PROFILE --------------------------------------------------------->

                        <table class="tabla-perfil" style="width: 50%;">
                            <thead >
                                <th colspan="3"><h4 class="thead-orange"><?php echo $user->getName()." ".$user->getSurname();?></h4></th>
                            </thead>
                            <tbody>
                                <form action="<?php echo FRONT_ROOT?>User/edit" method="post">
                                    <tr> 
                                        <td colspan="3"></td> 
                                    </tr>
                                    <tr> 
                                        <td style="width: 35%;">Name</td>    
                                        <td colspan="2" style="width: 65%;"><input type="text" name="name" value="<?php echo $user->getName();?>"></td>
                                    </tr>     
                                    <tr> 
                                        <td style="width: 35%;">Surname</td>    
                                        <td colspan="2" style="width: 65%;"><input type="text" name="surname" value="<?php echo $user->getSurname();?>"></td>
                                    </tr>   
                                    <tr> 
                                        <td style="width: 35%;">DNI</td>    
                                        <td colspan="2" style="width: 65%;"><input type="number" name="dni" value="<?php echo $user->getDni();?>"></td>
                                    </tr>   
                                    <tr> 
                                        <td style="width: 35%;">Address</td>    
                                        <td style="width: 33%;"><input type="text" name="street" value="<?php echo $user->getStreet();?>"></td>
                                        <td style="width: 32%;"><input type="number" name="number" value="<?php echo $user->getNumber();?>"></td>
                                    </tr>                       
                                    <tr> 
                                        <td style="width: 35%;">Email</td>
                                        <td colspan="2" style="width: 65%;"><input type="email" name="email" value="<?php echo $user->getEmail();?>" disabled></td>
                                        <input type="hidden" name="email" value="<?php echo $user->getEmail();?>" >
                                    </tr>
                                    <tr> 
                                        <td style="width: 35%;">Password</td>    
                                        <td style="width: 32%;"><input type="password" name="pass" value= <?php echo $user->getPassword()?>></td>
                                        <td style="width: 33%;"><input type="password" name="repass"value= <?php echo $user->getPassword()?>></td>
                                    </tr>     
                                    <tr> 
                                        <td colspan="3"></td>    
                                    </tr>  
                                    <tr>
                                        <td class="grey center" colspan="3" ><button type="submit" name="submit" class="btn button-right" value="">Save </button></td>
                                    </tr>
                                    
                                </form>
                            </tbody>
                        </table>
     
                        <?php if($this->msg != null){?>
                            <div class="center">
                                <h4 class="msg"><?php echo $this->msg;}?></h4>
                            </div>

                    <!---------------------------------------------- PURCHASE HISTORY --------------------------------------------------------->

                            <?php if($ticketHistory){ 
                                $totalCash=0;
                                $totalTickets=0;
                            ?>

                        <table class="tabla-perfil" style="width: 50%;">
                            <thead >
                                <th colspan="5"><h4 class="thead-orange">PURCHASE HISTORY</h4></th>
                            </thead>
                            <tbody>
                                <tr> 
                                    <td class="grey center">Date</td>
                                    <td class="grey center">Movie</td>
                                    <td class="grey center">Cinema</td>
                                    <td class="grey center">Tickets</td>
                                    <td class="grey center">Total</td>
                                </tr>
                                <?php foreach ($ticketHistory as $ticket){?>
                                <tr> 
                                    <td class="center"><?php echo $ticket->getShow()->getDateTime(); ?></td>    
                                    <td class="center"><?php echo $ticket->getShow()->getMovie()->getTitle(); ?></td>    
                                    <td class="center"><?php echo $ticket->getShow()->getRoom()->getCinema()->getName(); ?></td>
                                    <td class="center"><?php echo $ticket->getBill()->getTickets(); ?></td>
                                    <td class="center"><?php echo "$ ".$ticket->getBill()->getTotalPrice(); ?></td>
                                </tr>     
                                    <?php $totalCash+=$ticket->getBill()->getTotalPrice(); 
                                          $totalTickets+=$ticket->getBill()->getTickets(); 
                                
                                } ?>
                                <tr> 
                                    <td colspan="5"></td> 
                                </tr>
                                <tr> 
                                    <th colspan="3"><h4 class="thead mrg_top center">TOTAL</h4></th>
                                    <td class="grey center"><p><?php echo $totalTickets;?></p></td>
                                    <td class="grey center"><p><?php echo "$ ".$totalCash;?></p></td>
                                </tr>
                            </tbody>
                                </table> <?php } ?>
                    </div>
    </main><br><br>
</div>
