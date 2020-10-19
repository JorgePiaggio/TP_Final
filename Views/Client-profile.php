<main class="py-5">
     <section id="perfil" class="mb-5">
          <div class="background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/justin-campbell-aP_hTfwXEkc-unsplash2.jpg');">
                  <h2 class="page-title">Profile</h2>

                    <table class="tabla-perfil" style="width: 50%;">
                        <thead >
                            <th colspan="3"><h4 class="thead-orange"><?php echo $client->getName()." ".$client->getSurname();?></h4></th>
                        </thead>
                        <tbody>
                        <form action="<?php echo FRONT_ROOT?>Client/edit" method="post">
                            <tr> 
                                <td colspan="3"></td> 
                            </tr>
                            <tr> 
                                <td style="width: 35%;">Name</td>    
                                <td colspan="2" style="width: 65%;"><input type="text" name="name" value="<?php echo $client->getName();?>"></td>
                            </tr>     
                            <tr> 
                                <td style="width: 35%;">Surname</td>    
                                <td colspan="2" style="width: 65%;"><input type="text" name="surname" value="<?php echo $client->getSurname();?>"></td>
                            </tr>   
                            <tr> 
                                <td style="width: 35%;">DNI</td>    
                                <td colspan="2" style="width: 65%;"><input type="number" name="dni" value="<?php echo $client->getDni();?>"></td>
                            </tr>   
                            <tr> 
                                <td style="width: 35%;">Address</td>    
                                <td style="width: 33%;"><input type="text" name="street" value="<?php echo $street;?>"></td>
                                <td style="width: 32%;"><input type="number" name="number" value="<?php echo $number;?>"></td>
                            </tr>                        
                            <tr> 
                                <td style="width: 35%;">Phone</td>    
                                <td colspan="2" style="width: 65%;"><input type="number" name="phone" value="<?php echo $client->getPhone();?>"></td>
                            </tr>
                            <tr> 
                                <td style="width: 35%;">Email</td>
                                <td colspan="2" style="width: 65%;"><input type="email" name="email" value="<?php echo $client->getEmail();?>" disabled></td>
                                <input type="hidden" name="email" value="<?php echo $client->getEmail();?>" >
                            </tr>
                            <!---<tr>
                                <td style="width: 35%;">Credit Cards</td>
                                <?php # foreach($client->getCardList() as $card){?>    
                                <td colspan="2" style="width: 65%;"><input type="text" name="cards" value="<?php # echo $card->getNumber();?>"></td>
                            </tr> ACOMODAR --->
                                <?php # }?>
                            <tr> 
                                <td style="width: 35%;">Password</td>    
                                <td style="width: 32%;"><input type="password" name="pass" value= <?php echo $client->getPassword()?>></td>
                                <td style="width: 33%;"><input type="password" name="repass"value= <?php echo $client->getPassword()?>></td>
                            </tr>          
                            <tr> 
                                <td colspan="3"></td> 
                            </tr>
                            <tr>
                                <td class="message" colspan="2" ><?php if($this->msg != null){echo $this->msg;}?></td>     
                                <td class="grey" colspan="1" ><button type="submit" name="submit" class="btn button-right" value=""> Save </button></td>
                            </tr>
                            
                            </tbody>
                        </form>
                    </table>
            </div>
        </div>
     </section>
</main>
