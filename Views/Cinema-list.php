<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Active Cinemas</h2>

               <table class="table bg-light">
                    <thead class="bg-dark text-white">
                         <th>Name</th>
                         <th>Address</th>
                         <th>Phone</th>
                         <th>Email</th>
                         <th  colspan="2">Action</th>
                    </thead>
                    <tbody>
                    <?php foreach($cinemaList as $cinema){ ?>
                         <tr>    
                              <td><?php echo $cinema->getName(); ?> </td>     
                              <td><?php echo $cinema->getAddress(); ?> </td>
                              <td><?php echo $cinema->getPhone(); ?> </td>
                              <td><?php echo $cinema->getEmail(); ?> </td>
                              <form action="<?php echo FRONT_ROOT?>Cinema/SearchEdit" method="post">
                              <td><button type="submit" name="id" class="btn" value="<?php echo $cinema->getId()?>"> Edit </button></td>
                              </form>
                              <form action="<?php echo FRONT_ROOT?>Cinema/ChangeState" method="post">
                              <td><button type="submit" name="id" class="btn" value="<?php echo $cinema->getId()?>"> Remove </button></td>
                              </form>
                         </tr>
                    <?php } ?>
                    </tbody>
               </table>
          </div>

          <div class="container">
               <h2 class="mb-4" >Inactive Cinemas </h2>

               <table class="table bg-light">
                    <thead class="bg-dark text-white">
                         <th>Name</th>
                         <th>Addres</th>
                         <th>Phone</th>
                         <th>Email</th>
                         <th  colspan="2">Action</th>
                    </thead>
                    <tbody>
                    <?php foreach($cinemaListInactive as $cinema){ ?>
                         <tr>    
                              <td><?php echo $cinema->getName(); ?> </td>     
                              <td><?php echo $cinema->getAddress(); ?> </td>
                              <td><?php echo $cinema->getPhone(); ?> </td>
                              <td><?php echo $cinema->getEmail(); ?> </td>
                              <form action="<?php echo FRONT_ROOT?>Cinema/SearchEdit" method="post">
                              <td><button type="submit" name="id" class="btn" value="<?php echo $cinema->getId()?>"> Edit </button></td>
                              </form>
                              <form action="<?php echo FRONT_ROOT?>Cinema/ChangeState" method="post">
                              <td><button type="submit" name="id" class="btn" value="<?php echo $cinema->getId()?>"> Restore </button></td>
                              </form>
                         </tr>
                    <?php } ?>
                    </tbody>
               </table>
          </div>
     </section>
</main>


