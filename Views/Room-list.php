<main class="list">
          <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/serena-wong-SdjA-_Xzuxg-unsplash.jpg');">
               <h2 class="page-title v2"> Cinema: <?php echo $cinemaSearch->getName()?> <br></h2>
               <h2 class="page-title"> Rooms<br></h2>
                    <div class="container2">
                         <table class="table bg-light small">
                              <thead class="bg-dark text-white" width="60%">
                                   <th>Name</th>
                                   <th>Capacity</th>
                                   <th>Type</th>
                                   <th>Price</th>
                                   <th>Action</th>
                              </thead>
                              <tbody>
                              <?php foreach($roomList as $room){ ?>
                                   <tr>       
                                        <td><?php echo $room->getName(); ?> </td>
                                        <td><?php echo $room->getCapacity(); ?> </td>
                                        <td><?php echo $room->getType(); ?> </td>
                                        <td><?php echo $room->getPrice(); ?> </td>
                                        <form action="<?php echo FRONT_ROOT?>Room/showRoomEdit" method="post">
                                        <input type="hidden" name="name" value="<?php $room->getName(); ?>">
                                        <td style="width: 10%;"><button type="submit" name="id" class="btn" value="<?php echo $room->getCinema()->getIdCinema();?>"> Edit </button></td>
                                        </form>
                                   </tr>
                              <?php } ?>
                              </tbody>
                         </table>
                    </div>
          </div>
</main>
