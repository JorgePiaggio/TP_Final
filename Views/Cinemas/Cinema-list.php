<main class="list">
          <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/kilyan-sockalingum-nW1n9eNHOsc-unsplash.jpg');">
               <h2 class="page-title up2">Active Cinemas</h2>
               <div class="hoc"><br>
                                  <?php if($this->msg != null){?> 
                                        <center><h4 class="msg"><?php  echo $this->msg;
                                    } ?> </h4></center>
                                </div> 
                    <div class="container2">
                         <table class="table bg-light">
                              <thead class="bg-dark text-white">
                                   <?php if($cinemaList){ ?>
                                   <th width="15%">Name</th>
                                   <th>Street</th>
                                   <th>Number</th>
                                   <th>City</th>
                                   <th>Country</th>
                                   <th>Phone</th>
                                   <th>Email</th>
                                   
                                   <th  colspan="3">Action</th>
                              </thead>
                              <tbody>
                                   
                              <?php     if(!is_array($cinemaList)){?>
                                             <tr>    
                                        <td><?php echo $cinemaList->getName(); ?> </td>     
                                        <td><?php echo $cinemaList->getStreet(); ?> </td>
                                        <td><?php echo $cinemaList->getNumber(); ?> </td>
                                        <td><?php echo $cinemaList->getCity(); ?> </td>
                                        <td><?php echo $cinemaList->getCountry(); ?> </td>
                                        <td><?php echo $cinemaList->getPhone(); ?> </td>
                                        <td><?php echo $cinemaList->getEmail(); ?> </td>
                                        <form action="<?php echo FRONT_ROOT?>Cinema/searchEdit" method="post">
                                        <td><button type="submit" name="idCinema" class="btn" value="<?php echo $cinemaList->getIdCinema()?>"> Edit </button></td>
                                        </form>
                                        <form action="<?php echo FRONT_ROOT?>Cinema/changeState" method="post">
                                        <td><button type="submit" name="idCinema" class="btn" value="<?php echo $cinemaList->getIdCinema()?>"> Remove </button></td>
                                        </form>
                                        <form action="<?php echo FRONT_ROOT?>Ticket/showStatistics" method="post">
                                        <td><button type="submit" name="idCinema" class="btn" value="<?php echo $cinemaList->getIdCinema()?>"> Statistics </button></td>
                                        </form>
                                   </tr> 
                                       <?php }else{ ?>
                              <?php foreach($cinemaList as $cinema){ ?>
                                   <tr>    
                                        <td><?php echo $cinema->getName(); ?> </td>     
                                        <td><?php echo $cinema->getStreet(); ?> </td>
                                        <td><?php echo $cinema->getNumber(); ?> </td>
                                        <td><?php echo $cinema->getCity(); ?> </td>
                                        <td><?php echo $cinema->getCountry(); ?> </td>
                                        <td><?php echo $cinema->getPhone(); ?> </td>
                                        <td><?php echo $cinema->getEmail(); ?> </td>

                                        <form action="<?php echo FRONT_ROOT?>Cinema/searchEdit" method="post">
                                        <td><button type="submit" name="idCinema" class="btn" value="<?php echo $cinema->getIdCinema()?>"> Edit </button></td>
                                        </form>
                                        <form action="<?php echo FRONT_ROOT?>Cinema/changeState" method="post">
                                        <td><button type="submit" name="idCinema" class="btn" value="<?php echo $cinema->getIdCinema()?>"> Remove </button></td>
                                        </form>
                                        <form action="<?php echo FRONT_ROOT?>Ticket/showStatistics" method="post">
                                        <td><button type="submit" name="idCinema" class="btn" value="<?php echo $cinema->getIdCinema()?>"> Statistics </button></td>
                                        </form>
                                   </tr>
                              <?php }}} 
                              else{ ?>
                                   <center><h4 class="msg">No active cinemas</h4></center>
                         <?php  } ?>
                              </tbody>
                         </table>
                    </div>
                    <h2 class="page-title" >Inactive Cinemas </h2>
                    <div class="container2">
                        
                              <?php if($cinemaListInactive){ ?>

                                   <table class="table bg-light">
                                        <thead class="bg-dark text-white">
                                             <th width="15%">Name</th>
                                             <th>Street</th>
                                             <th>Number</th>
                                             <th>City</th>
                                             <th>Country</th>
                                             <th>Phone</th>
                                             <th>Email</th>
                                             
                                             <th  colspan="3">Action</th>
                                        </thead>
                                   <tbody>

                                       <?php if(!is_array($cinemaListInactive)){?>
                                   <tr>    
                                        <td><?php echo $cinemaListInactive->getName(); ?> </td>     
                                        <td><?php echo $cinemaListInactive->getStreet(); ?> </td>
                                        <td><?php echo $cinemaListInactive->getNumber(); ?> </td>
                                        <td><?php echo $cinemaListInactive->getCity(); ?> </td>
                                        <td><?php echo $cinemaListInactive->getCountry(); ?> </td>
                                        <td><?php echo $cinemaListInactive->getPhone(); ?> </td>
                                        <td><?php echo $cinemaListInactive->getEmail(); ?> </td>

                                        <form action="<?php echo FRONT_ROOT?>Cinema/searchEdit" method="post">
                                        <td><button type="submit" name="id" class="btn" value="<?php echo $cinemaListInactive->getIdCinema()?>"> Edit </button></td>
                                        </form>
                                        <form action="<?php echo FRONT_ROOT?>Cinema/changeState" method="post">
                                        <td><button type="submit" name="id" class="btn" value="<?php echo $cinemaListInactive->getIdCinema()?>"> Restore </button></td>
                                        </form>
                                        <form action="<?php echo FRONT_ROOT?>Ticket/showStatistics" method="post">
                                        <td><button type="submit" name="idCinema" class="btn" value="<?php echo $cinemaListInactive->getIdCinema()?>"> Statistics </button></td>
                                        </form>
                                   </tr>
                              <?php }else{ ?>          
                              <?php foreach($cinemaListInactive as $cinema){ ?>
                                   <tr>    
                                        <td><?php echo $cinema->getName(); ?> </td>     
                                        <td><?php echo $cinema->getStreet(); ?> </td>
                                        <td><?php echo $cinema->getNumber(); ?> </td>
                                        <td><?php echo $cinema->getCity(); ?> </td>
                                        <td><?php echo $cinema->getCountry(); ?> </td>
                                        <td><?php echo $cinema->getPhone(); ?> </td>
                                        <td><?php echo $cinema->getEmail(); ?> </td>
                                        
                                        <form action="<?php echo FRONT_ROOT?>Cinema/searchEdit" method="post">
                                        <td><button type="submit" name="id" class="btn" value="<?php echo $cinema->getIdCinema()?>"> Edit </button></td>
                                        </form>
                                        <form action="<?php echo FRONT_ROOT?>Cinema/changeState" method="post">
                                        <td><button type="submit" name="id" class="btn" value="<?php echo $cinema->getIdCinema()?>"> Restore </button></td>
                                        </form>
                                        <form action="<?php echo FRONT_ROOT?>Ticket/showStatistics" method="post">
                                        <td><button type="submit" name="idCinema" class="btn" value="<?php echo $cinema->getIdCinema()?>"> Statistics </button></td>
                                        </form>
                                   </tr>
                              <?php }}}
                                else{ ?>
                                   <center><h4 class="msg">No inactive cinemas</h4></center>
                         <?php  } ?>
                              </tbody>
                         </table>
                    </div>
          </div>
</main>


