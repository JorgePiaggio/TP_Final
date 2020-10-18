<main class="list">
          <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/kilyan-sockalingum-nW1n9eNHOsc-unsplash.jpg');">
               <h2 class="page-title up2">Active Cinemas</h2>
                    <div class="container2">
                         <table class="table bg-light">
                              <thead class="bg-dark text-white">
                                   <th>Name</th>
                                   <th>Address</th>
                                   <th>Phone</th>
                                   <th>Email</th>
                                   <th>Price</th>
                                   <th  colspan="2">Action</th>
                              </thead>
                              <tbody>
                              <?php foreach($cinemaList as $cinema){ ?>
                                   <tr>    
                                        <td><?php echo $cinema->getName(); ?> </td>     
                                        <td><?php echo $cinema->getAddress(); ?> </td>
                                        <td><?php echo $cinema->getPhone(); ?> </td>
                                        <td><?php echo $cinema->getEmail(); ?> </td>
                                        <td><?php echo $cinema->getPrice(); ?> </td>
                                        <form action="<?php echo FRONT_ROOT?>Cinema/searchEdit" method="post">
                                        <td><button type="submit" name="id" class="btn" value="<?php echo $cinema->getId()?>"> Edit </button></td>
                                        </form>
                                        <form action="<?php echo FRONT_ROOT?>Cinema/changeState" method="post">
                                        <td><button type="submit" name="id" class="btn" value="<?php echo $cinema->getId()?>"> Remove </button></td>
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
                                   <th>Addres</th>
                                   <th>Phone</th>
                                   <th>Email</th>
                                   <th>Price</th>
                                   <th  colspan="2">Action</th>
                              </thead>
                              <tbody>
                              <?php foreach($cinemaListInactive as $cinema){ ?>
                                   <tr>    
                                        <td><?php echo $cinema->getName(); ?> </td>     
                                        <td><?php echo $cinema->getAddress(); ?> </td>
                                        <td><?php echo $cinema->getPhone(); ?> </td>
                                        <td><?php echo $cinema->getEmail(); ?> </td>
                                        <td><?php echo $cinema->getPrice(); ?> </td>
                                        <form action="<?php echo FRONT_ROOT?>Cinema/searchEdit" method="post">
                                        <td><button type="submit" name="id" class="btn" value="<?php echo $cinema->getId()?>"> Edit </button></td>
                                        </form>
                                        <form action="<?php echo FRONT_ROOT?>Cinema/changeState" method="post">
                                        <td><button type="submit" name="id" class="btn" value="<?php echo $cinema->getId()?>"> Restore </button></td>
                                        </form>
                                   </tr>
                              <?php } ?>
                              
                              </tbody>
                         </table>
                    </div>
          </div>
</main>


