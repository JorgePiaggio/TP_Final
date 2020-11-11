<div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/serena-wong-SdjA-_Xzuxg-unsplash.jpg');">
     <main class="list">
               <h2 class="page-title up2"> Cinema <?php echo $cinemaSearch->getName()?> <br></h2><br><br>
               <?php if($this->msg){ ?> <!-- Si ya existe una sala con ese nombre en el mismo cine muestro el mensaje -->
                                        <center> <h4 class="msg"> <?php echo $this->msg;?></h4></center> <br><br>
                              <?php }?>
               <h2 class="page-title v2 up"> Active Rooms<br></h2>
               <div class="hoc">
                    <div class="container2">
                         <table class="table bg-light small">
                              <thead class="bg-dark text-white" width="60%">
                              <?php if($roomList){ ?>
                                   <th>Name</th>
                                   <th>Capacity</th>
                                   <th>Type</th>
                                   <th>Price</th>
                                   <th colspan="2">Action</th>
                              </thead>
                              <tbody>
                                   
                              <?php for($i=0; $i<count($roomList); $i++){ ?>
                                   <tr>       
                                        <td><?php echo $roomList[$i]->getName(); ?> </td>
                                        <td><?php echo $roomList[$i]->getCapacity(); ?> </td>
                                        <td><?php echo $roomList[$i]->getType(); ?> </td>
                                        <td><?php echo $roomList[$i]->getPrice(); ?> </td>
                                        <form action="<?php echo FRONT_ROOT?>Room/showRoomEdit" method="post">
                                             <input type="hidden" name="name" value="<?php echo $roomList[$i]->getName(); ?>">
                                        <td style="width: 10%;"><button type="submit" name="id" class="btn" value="<?php echo $roomList[$i]->getCinema()->getIdCinema();?>"> Edit </button></td>
                                        </form>
                                        <form action="<?php echo FRONT_ROOT?>Room/changeState" method="post">
                                        <input type="hidden" name="name1" value="<?php echo $roomList[$i]->getName(); ?>">
                                        <td style="width: 10%;"><button type="submit" name="idCinema1" class="btn" value="<?php echo  $roomList[$i]->getCinema()->getIdCinema();?>"> Remove </button></td>
                                        </form>
                                   </tr>
                              <?php } }
                                   else {?>
                                        <center><h4 class="msg">No active rooms</h4></center>
                               <?php }?>
                              </tbody>
                         </table><br><br>
                    </div>
                                 
               </div>
     </main>
<main class="list">
               <h2 class="page-title v2"> Inactive Rooms<br></h2>
               <div class="hoc">
                    <div class="container2">
                        
                                   <?php if($roomListInactive!=null){ ?>
                                        <table class="table bg-light small">
                                                  <thead class="bg-dark text-white" width="60%">
                                                       <th>Name</th>
                                                       <th>Capacity</th>
                                                       <th>Type</th>
                                                       <th>Price</th>
                                                       <th colspan="2">Action</th>
                                                  </thead>
                                             <tbody>
                              <?php for($i=0; $i<count($roomListInactive); $i++){ ?>
                                                  <tr>       
                                                       <td><?php echo $roomListInactive[$i]->getName(); ?> </td>
                                                       <td><?php echo $roomListInactive[$i]->getCapacity(); ?> </td>
                                                       <td><?php echo $roomListInactive[$i]->getType(); ?> </td>
                                                       <td><?php echo $roomListInactive[$i]->getPrice(); ?> </td>
                                                       <form action="<?php echo FRONT_ROOT?>Room/showRoomEdit" method="post">
                                                            <input type="hidden" name="name" value="<?php echo $roomListInactive[$i]->getName(); ?>">
                                                       <td style="width: 10%;"><button type="submit" name="id" class="btn" value="<?php echo $roomListInactive[$i]->getCinema()->getIdCinema();?>"> Edit </button></td>
                                                       </form>
                                                       <form action="<?php echo FRONT_ROOT?>Room/changeState" method="post">
                                                       <input type="hidden" name="name" value="<?php echo $roomListInactive[$i]->getName(); ?>">
                                                       <td style="width: 10%;"><button type="submit" name="idCinema" class="btn" value="<?php echo  $roomListInactive[$i]->getCinema()->getIdCinema();?>"> Restore </button></td>
                                                       </form>
                                                  </tr>
                              <?php } }
                                   else {?>
                                        <center><h4 class="msg">No inactive rooms</h4></center>
                               <?php }?>
                              </tbody>
                         </table>
                    </div>
                                  
               </div>
     </main>

     </div>
