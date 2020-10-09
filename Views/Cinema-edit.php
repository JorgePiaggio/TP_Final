<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Edit cinema</h2>
               <table class="table bg-light">
                    <thead class="bg-dark text-white">
                         <th>Name</th>
                         <th>Street</th>
                         <th>Number</th>
                         <th>Phone</th>
                         <th>Email</th>
                         <th>Action</th>
                    </thead>
                    <tbody>
                    <form action="<?php echo FRONT_ROOT?>Cinema/Edit" method="post">
                         <tr> 
                            <td><input type="text" name="name" value="<?php echo $editCinema->getName(); ?>" > </td>     
                            <td><input type="text" name="street" value= "<?php echo $address[0] ?>">  </td>
                            <td><input type="number" name="number" value= "<?php echo $address[1] ?>">  </td>
                            <td><input type="number" name="phone" value= "<?php echo $editCinema->getPhone(); ?>"> </td>
                            <td><input type="email" name="email" value= "<?php echo $editCinema->getEmail(); ?>"> </td>
                            <td><button type="submit" name="id" class="btn" value="<?php echo $editCinema->getId(); ?>"> Save </button></td>
                         </tr>
                    </form>
                    </tbody>
               </table>
          </div>
     </section>
</main>

