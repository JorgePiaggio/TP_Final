<main class="py-5">
          <div class="background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/felix-mooneeram-evlkOfkQ5rE-unsplash.jpg');">
               <h2 class="page-title">Edit Room</h2>
               <div>
                    <table class="table bg-light down">
                         <thead class="bg-dark text-white">
                              <th>Name</th>
                              <th>Rows</th>
                              <th>Columns</th>
                              <th>Type</th>
                              <th>Price</th>
                             </thead>
                         <tbody>
                         <form action="<?php echo FRONT_ROOT?>Room/edit" method="post">
                              <tr>
                                   <input type="hidden"  name="idcinema" value= "<?php echo $editRoom->getCinema()->getIdCinema();  ?>" >
                                   <td><input type="text" maxlength="50" name="name" value= "<?php echo $editRoom->getName();  ?>" >  </td>
                                   <td><input type="number" max="20" min="1" name="rows" value= "<?php echo $editRoom->getRows(); ?>">  </td>
                                   <td><input type="number" max="20" min="1" name="columns" value= "<?php echo $editRoom->getColumns(); ?>">  </td>
                                   <td><select name="typeRoom" >
                                        <option value="2D">2D</option>
                                        <option value="3D">3D</option>
                                   </select> </td>
                                   <div class="floating-label">
                                        <td>
                                        <input type="number" max="1000000" name="price" value= "<?php echo $editRoom->getPrice(); ?>" placeholder=" " class="floating-input" required>
                                        </td>                                  
                                   </div>
                              </tr>
                         
                         </tbody>
                    </table>
                    <td colspan="7"><button type="submit" name="idsave" class="btn unique" value="<?php echo $editRoom->getIdRoom(); ?>"> Save </button></td>
                    </form>
               </div>    
          </div>
</main>