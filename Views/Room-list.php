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
                                   <?php if($roomList!=null){ ?>
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
                                   </tr>
                              <?php } }?>
                              </tbody>
                         </table>
                    </div>
          </div>
</main>
