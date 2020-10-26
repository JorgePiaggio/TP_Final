<main class="py-5">
     <section id="perfil" class="mb-5">
          <div class="background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/justin-campbell-aP_hTfwXEkc-unsplash2.jpg');">
                  <h2 class="page-title">User - <?php echo $user->getRole()->getDescription() ?></h2>

                    <table class="tabla-perfil" style="width: 50%;">
                        <thead >
                            <th colspan="3"><h4 class="thead-orange"><?php echo $user->getName()." ".$user->getSurname();?></h4></th>
                        </thead>
                        <tbody>
                        <form action="<?php echo FRONT_ROOT?>User/changeRole" method="post">
                            <tr> 
                                <td colspan="3"></td> 
                            </tr>
                            <tr> 
                                <td style="width: 35%;">Role</td>    
                                <td colspan="2" style="width: 65%;"><?php echo $user->getRole()->getDescription()?></td>
                            </tr>
                            <tr> 
                                <td style="width: 35%;">Name</td>    
                                <td colspan="2" style="width: 65%;"><?php echo $user->getName();?></td>
                            </tr>     
                            <tr> 
                                <td style="width: 35%;">Surname</td>    
                                <td colspan="2" style="width: 65%;"><?php echo $user->getSurname();?></td>
                            </tr>   
                            <tr> 
                                <td style="width: 35%;">DNI</td>    
                                <td colspan="2" style="width: 65%;"><?php echo $user->getDni();?></td>
                            </tr>   
                            <tr> 
                                <td style="width: 35%;">Address</td>    
                                <td style="width: 33%;"><?php echo $user->getStreet();?></td>
                                <td style="width: 32%;"><?php echo $user->getNumber();?></td>
                            </tr>                       
                            <tr> 
                                <td style="width: 35%;">Email</td>
                                <td colspan="2" style="width: 65%;"><?php echo $user->getEmail();?></td>
                                <input type="hidden" name="email" value="<?php echo $user->getEmail();?>" >
                            </tr>          
                            <tr> 
                                <td colspan="3"></td> 
                            </tr>
                            <tr>    
                                <td class="grey center" colspan="3" ><button type="submit" name="submit" class="btn button-right" value="<?php $user->getEmail() ?>"> Change Role </button></td>
                            </tr>
                            
                            </tbody>
                        </form>
                    </table>
                    <div class="center"> <?php if($this->msg){ ?> <h4 class="msg"><?php echo $this->msg;} ?></h4></div> 
            </div>
        </div>
     </section>
</main>