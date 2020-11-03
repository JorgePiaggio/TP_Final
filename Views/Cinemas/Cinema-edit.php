<main class="py-5">
          <div class="background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/felix-mooneeram-evlkOfkQ5rE-unsplash.jpg');">
               <h2 class="page-title">Edit Cinema</h2>
               <div>
                    <table class="table bg-light down">
                         <thead class="bg-dark text-white">
                              <th width="7%">Name</th>
                              <th width="7%">Street</th>
                              <th width="5%">Number</th>
                              <th width="7%">City</th>
                              <th width="7%">Country</th>
                              <th width="7%">Phone</th>
                              <th width="10%">Email</th>
                              <th width="10%">Poster</th>
                         </thead>

                         <tbody>
                         <form action="<?php echo FRONT_ROOT?>Cinema/edit" method="post">
                              <tr> 
                              <td><input type="text" size='' style='width:100%' maxlength="50" name="name" value="<?php echo $editCinema->getName(); ?>" > </td>     
                              <td><input type="text" size='' style='width:100%' maxlength="50" name="street" value= "<?php echo $editCinema->getStreet() ?>">  </td>
                              <td><input type="number" size='' style='width:100%' max="100000" name="number" value= "<?php echo $editCinema->getNumber() ?>">  </td>
                              <td><input type="text" size='' style='width:100%' maxlength="50" name="city" value= "<?php echo $editCinema->getCity() ?>">  </td>
                              <td><input type="text" size='' style='width:100%' maxlength="50" name="country" value= "<?php echo $editCinema->getCountry() ?>">  </td>
                              <td><input type="number" size='' style='width:100%' maxlength="12"name="phone" value= "<?php echo $editCinema->getPhone(); ?>"> </td>
                              <td><input type="email" size='' style='width:100%' maxlength="50" name="email" value= "<?php echo $editCinema->getEmail(); ?>"> </td>
                              <td><input type="text" size='' style='width:100%' maxlength="1000" name="img" value= "<?php echo $editCinema->getPoster(); ?>"> </td>
                              </tr>

                              <tr>
                              <td colspan="8"><button type="submit" name="idCinema" class="btn unique" value="<?php echo $editCinema->getIdCinema(); ?>"> Save </button></td>
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

