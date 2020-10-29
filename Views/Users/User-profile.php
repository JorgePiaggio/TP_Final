<main class="py-5">
     <section id="perfil" class="mb-5">
          <div class="background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/agnieszka-kowalczyk-c0VRNWVEjOA-unsplash.jpg');">
                  <h2 class="page-title">Profile</h2>

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
                            <!---<tr>
                                <td style="width: 35%;">Credit Cards</td>
                                <?php # foreach($user->getCardList() as $card){?>    
                                <td colspan="2" style="width: 65%;"><input type="text" name="cards" value="<?php # echo $card->getNumber();?>"></td>
                            </tr> ACOMODAR --->
                                <?php # }?>
                            <tr> 
                                <td style="width: 35%;">Password</td>    
                                <td style="width: 32%;"><input type="password" name="pass" value= <?php echo $user->getPassword()?>></td>
                                <td style="width: 33%;"><input type="password" name="repass"value= <?php echo $user->getPassword()?>></td>
                            </tr>          
                            <tr> 
                                <td colspan="3"></td> 
                            </tr>
                            <tr> 
                                <td class="grey center" colspan="3" ><button type="submit" name="submit" class="btn button-right" value=""> Save </button></td>
                            </tr>
                            
                            
                            </tbody>
                        </form>
                    </table>
                    <?php if($this->msg != null){?>
                    <div class="center">
                    <h4 class="msg"><?php echo $this->msg;}?></h4></div>
            </div>
        </div>
     </section>
</main>
