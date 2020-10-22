<main class="list">
          <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/kilyan-sockalingum-nW1n9eNHOsc-unsplash.jpg');">
               <h2 class="page-title up2">Active Cinemas</h2>
                    <div class="container2">
                         <table class="table bg-light">
                              <thead class="bg-dark text-white">
                                   <th>Name</th>
                                   <th>Street</th>
                                   <th>Number</th>
                                   <th>Phone</th>
                                   <th>Email</th>
                                   
                                   <th  colspan="2">Action</th>
                              </thead>
                              <tbody>
                              <?php foreach($cinemaList as $cinema){ ?>
                                   <tr>    
                                        <td><?php echo $cinema->getName(); ?> </td>     
                                        <td><?php echo $cinema->getStreet(); ?> </td>
                                        <td><?php echo $cinema->getNumber(); ?> </td>
                                        <td><?php echo $cinema->getPhone(); ?> </td>
                                        <td><?php echo $cinema->getEmail(); ?> </td>
                                        <form action="<?php echo FRONT_ROOT?>Cinema/searchEdit" method="post">
                                        <td><button type="submit" name="idCinema" class="btn" value="<?php echo $cinema->getIdCinema()?>"> Edit </button></td>
                                        </form>
                                        <form action="<?php echo FRONT_ROOT?>Cinema/changeState" method="post">
                                        <td><button type="submit" name="idCinema" class="btn" value="<?php echo $cinema->getIdCinema()?>"> Remove </button></td>
                                        </form>
                                   </tr>
                              <?php } ?>
                              </tbody>
                         </table>
                    </div>
                    <h2 class="page-title" >Inactive Cinemas </h2>
                    <div class="container2">
                         <table class="table bg-light">
                              <thead class="bg-dark text-white">
                                   <th>Name</th>
                                   <th>Street</th>
                                   <th>Number</th>
                                   <th>Phone</th>
                                   <th>Email</th>
                                   
                                   <th  colspan="2">Action</th>
                              </thead>
                              <tbody>
                              <?php foreach($cinemaListInactive as $cinema){ ?>
                                   <tr>    
                                        <td><?php echo $cinema->getName(); ?> </td>     
                                        <td><?php echo $cinema->getStreet(); ?> </td>
                                        <td><?php echo $cinema->getNumber(); ?> </td>
                                        <td><?php echo $cinema->getPhone(); ?> </td>
                                        <td><?php echo $cinema->getEmail(); ?> </td>
                                        <form action="<?php echo FRONT_ROOT?>Cinema/searchEdit" method="post">
                                        <td><button type="submit" name="id" class="btn" value="<?php echo $cinema->getIdCinema()?>"> Edit </button></td>
                                        </form>
                                        <form action="<?php echo FRONT_ROOT?>Cinema/changeState" method="post">
                                        <td><button type="submit" name="id" class="btn" value="<?php echo $cinema->getIdCinema()?>"> Restore </button></td>
                                        </form>
                                   </tr>
                              <?php }?>
                              </tbody>
                         </table>
                    </div>
          </div>
</main>


