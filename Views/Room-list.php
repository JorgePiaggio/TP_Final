<main class="list">
          <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/kilyan-sockalingum-nW1n9eNHOsc-unsplash.jpg');">
               <h2 class="page-title up2">Active Rooms</h2>
                    <div class="container2">
                         <table class="table bg-light small">
                              <thead class="bg-dark text-white" width="60%">
                                   <th>Number</th>
                                   <th>Capacity</th>
                                   <th>Type</th>
                                   <th  colspan="2">Action</th>
                              </thead>
                              <tbody>
                              <?php foreach($roomList as $room){ ?>
                                   <tr>       
                                        <td><?php echo $room->getNumber(); ?> </td>
                                        <td><?php echo $room->getCapacity(); ?> </td>
                                        <td><?php echo $room->getType(); ?> </td>
                                        <form action="<?php echo FRONT_ROOT?>Room/showRoomedit" method="post">
                                        <input type="hidden" name="idcinema" value="<?php echo $room->getIdcinema();?>">
                                        <td style="width: 10%;"><button type="submit" name="id" class="btn" value="<?php echo $room->getNumber();?>"> Edit </button></td>
                                        </form>
                                        <form action="<?php echo FRONT_ROOT?>Room/changeState" method="post">
                                        <input type="hidden" name="idcinema" value="<?php echo $room->getIdcinema();?>">
                                        <td style="width: 10%;"><button type="submit" name="id" class="btn" value="<?php echo $room->getNumber();?>"> Remove </button></td>
                                        </form>
                                   </tr>
                              <?php } ?>
                              </tbody>
                         </table>
                    </div>
                    <h2 class="page-title" >Inactive Rooms </h2>
                    <div class="container2">
                         <table class="table bg-light" width="60%">
                              <thead class="bg-dark text-white" >
                                   <th>Number</th>
                                   <th>Capacity</th>
                                   <th>Type</th>
                                   <th colspan="2">Action</th>
                              </thead>
                              <tbody>
                              <?php foreach($roomsInactives as $room){ ?>
                                   <tr>       
                                        <td><?php echo $room->getNumber(); ?> </td>
                                        <td><?php echo $room->getCapacity(); ?> </td>
                                        <td><?php echo $room->getType(); ?> </td>
                                        <form action="<?php echo FRONT_ROOT?>Room/showRoomedit" method="post">
                                        <input type="hidden" name="idcinema" value="<?php echo $room->getIdcinema();?>">
                                        <td style="width: 10%;"><button type="submit" name="id" class="btn" value="<?php echo $room->getNumber();?>"> Edit </button></td>
                                        </form>
                                        <form action="<?php echo FRONT_ROOT?>Room/changeState" method="post">
                                        <input type="hidden" name="idcinema" value="<?php echo $room->getIdcinema();?>">
                                        <td style="width: 10%;"><button type="submit" name="id" class="btn" value="<?php echo $room->getNumber();?>"> Restore </button></td>
                                        </form>
                                   </tr>
                              <?php } ?>
                              </tbody>
                         </table>
                    </div>
</main>
