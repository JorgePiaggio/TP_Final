<main class="list">
          <div class="container background-pic" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/1b2e-c_gaHvs4KgM-unsplash.jpg');">
         
               <h2 class="page-title up2">Active Shows</h2>
               <form action="<?php echo FRONT_ROOT?>Show/showListView" class="center span" method="post">
                                <div class="floating-label-form">
                                    
                                        <select name="selection cinema" class="selection" onchange="this.form.submit()">
                                        <center>
                                            <?php if(!$cinemaList){?>
                                                  <option value="">No Cinemas Found</option>
                                             <?php } else{ ?>
                                                       <option value="" name="cinemanull" selected disabled> Select cinema</option>
                                                       <?php if($cinema){?>
                                                            <option value="<?php echo $cinema->getIdCinema();?>" name="cinemasearch" selected disabled> <?php echo $cinema->getName(); ?></option>
                                                     <?php }?>
                                                  <?php foreach($cinemaList as $cinema){ ?>
                                                            <option value="<?php echo $cinema->getIdCinema(); ?>" name="cinema"><?php echo $cinema->getName(); ?></option>
                                              <?php }}?>
                                              </center>  
                                        </select> 

                                                     
                                </div>
                </form>
               <div class="hoc"><br>
                                  <?php if($this->msg != null){?> 
                                        <center><h4 class="msg"><?php  echo $this->msg;
                                    } ?> </h4></center>
                                </div> 
                    <div class="container2">
                  
                                   <?php if($showList){ ?>
                                        <table class="table bg-light">
                                        <thead class="bg-dark text-white">
                                             <th>Room</th>
                                             <th>Movie</th>
                                             <th>Date</th>
                                             <th>Shift</th>
                                             <th>Tickets</th>
                                             
                                             <th  colspan="2">Action</th>
                                        </thead>
                                        <tbody><?php
                                        foreach($showList as $show){ ?>
                                             <tr>    
                                        <td><center><?php echo $show->getRoom()->getName(); ?> </center></td>     
                                        <td><center><?php echo $show->getMovie()->getTitle(); ?> </center></td>
                                        <td><center><?php echo $show->getDateTime(); ?> </center></td>
                                        <td><center><?php echo $show->getShift(); ?></center> </td>
                                        <td><center><?php echo $show->getRemainingTickets(); ?> </center></td>
                                        <form action="<?php echo FRONT_ROOT?>Show/showEditView" method="post">
                                        <td><button type="submit" name="edit" class="btn" value="<?php echo $show->getIdShow()?>"> Edit </button></td>
                                        </form>
                                        <form action="<?php echo FRONT_ROOT?>Show/remove" method="post">
                                        <td><button type="submit" name="remove" class="btn" value="<?php echo $show->getIdShow()?>"> Remove </button></td>
                                        </form>
                                        <?php }}?>
                                   </tr> 
                              </tbody>
                         </table>
                    </div>

             </div>
</main>
