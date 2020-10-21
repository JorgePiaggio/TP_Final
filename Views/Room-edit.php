<main class="py-5">
          <div class="background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/felix-mooneeram-evlkOfkQ5rE-unsplash.jpg');">
               <h2 class="page-title">Edit Room</h2>
               <div>
                    <table class="table bg-light down">
                         <thead class="bg-dark text-white">
                              <th>Number</th>
                              <th>Capacity</th>
                              <th>type</th>
                              <th>State</th>
                              <th>Price</th>
                             </thead>
                         <tbody>
                         <form action="<?php echo FRONT_ROOT?>Room/edit" method="post">
                         <input type="hidden" name="idcinema" value="<?php echo $editRoom->getIdcinema(); ?>" >
                              <tr>
                              <td><input type="number" name="number" value= "<?php echo $editRoom->getNumber();  ?>" disabled>  </td>
                              <td><input type="number" name="capacity" value= "<?php echo $editRoom->getCapacity(); ?>">  </td>
                              <td><select name="typeRoom" >
                                      <option value="2D">2D</option>
                                      <option value="3D">3D</option>
                                  </select> </td>
                              <td>  <select name="stateRoom" >
                                      <option value="1">Active</option>
                                      <option value="0">Inactive</option>
                                  </select></td>

                                  <div class="floating-label">
                                   <td><input type="number" name="price" value= "<?php echo $editRoom->getPrice(); ?>" placeholder=" " class="floating-input" required>
                              </td>                                  
                              </div>
    
                              </tr>
                         
                         </tbody>
                    </table>
                    <td colspan="7"><button type="submit" name="idsave" class="btn unique" value="<?php echo $editRoom->getNumber(); ?>"> Save </button></td>
                    </form>
               </div>    
          </div>
</main>