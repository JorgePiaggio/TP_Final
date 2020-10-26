<main class="py-5">
          <div class="background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/felix-mooneeram-evlkOfkQ5rE-unsplash.jpg');">
               <h2 class="page-title">Edit Cinema</h2>
               <div>
                    <table class="table bg-light down">
                         <thead class="bg-dark text-white">
                              <th>Name</th>
                              <th>Street</th>
                              <th>Number</th>
                              <th>Phone</th>
                              <th>Email</th>
                              

                         </thead>
                         <tbody>
                         <form action="<?php echo FRONT_ROOT?>Cinema/edit" method="post">
                              <tr> 
                              <td><input type="text" name="name" value="<?php echo $editCinema->getName(); ?>" > </td>     
                              <td><input type="text" name="street" value= "<?php echo $editCinema->getStreet() ?>">  </td>
                              <td><input type="number" name="number" value= "<?php echo $editCinema->getNumber() ?>">  </td>
                              <td><input type="number" name="phone" value= "<?php echo $editCinema->getPhone(); ?>"> </td>
                              <td><input type="email" name="email" value= "<?php echo $editCinema->getEmail(); ?>"> </td>
                              </tr>

                              <tr>
                              <td colspan="7"><button type="submit" name="idCinema" class="btn unique" value="<?php echo $editCinema->getIdCinema(); ?>"> Save </button></td>
                              </tr>
                         </form>
                         </tbody>
                    </table>
                    <div class="center"><h4 class="msg"><?php if($this->msg != null){ //Si el cine ya existe muestra el mensaje
                                   echo $this->msg;
                              } ?></h4></div>
               </div>    
          </div>
</main>

