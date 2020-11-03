<div class="wrapper bgded overlay" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/tickets.jpg');">
    <h2 class="page-title"><?php echo $cinema->getName() . " - Stadistics" ?></h2>
    <div class="cardStyle">
        <main class="hoc container clear"> 
            
            <div class="cardStyle">
                <h2 class="orange center">Statistics Cash <i class="fa fa-search" style="font-size: 1.73em"></i></h2>
            </div>

            <div class="cardStyle mrg_top">
                
                <div class="one_third">
                    <p> Choose date to search</p>  <br>
                    <div class="floating-label">
                        <form action="<?php echo FRONT_ROOT?>Ticket/showData/" class="center" method="post">
                            <input type="hidden" id="flag" name="flag" value="1">
                            <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                            <input type="date" name="date" value="" class="floating-input" required>
                            <span class="highlight"></span><label for="">Date </label>
                            <div> <br>
                                <button type="submit" name="search" class="btn btn-primary ml-auto d-block">Search</button>
                            </div>
                        </form>
                    </div> 
                    <div>
                            <?php if($data != -1 && $flag == 1){ ?>
                                <h4 class="msg"><?php  echo "Collection $date: $ $data";
                            } ?> </h4>
                    </div>
                </div>         

                <div class="one_third">
                    <p> Choose month this year to search</p>  <br>
                    
                        <span class="floating-label">
                            <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                                <input type="hidden" id="flag" name="flag" value="2">
                                <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                                <input type="number" max="<?php echo date('m') ?>" min="1" name="month" value="" class="floating-input" required>
                                <span class="highlight"></span><label for="">Month </label>
                                <div> <br>
                                    <button type="submit" name="search2" class="btn btn-primary ml-auto d-block">Search</button>
                                </div>
                            </form>
                        </span>
                        <div>
                                <?php if($data != -1 && $flag == 2){ ?>
                                    <h4 class="msg"><?php  echo "Collection month $date: $ $data";
                                } ?> </h4>
                        </div>
                </div>
            

                <div class="one_quarter right">
                    <p> Choose year to search</p>  <br>
                    
                        <span class="floating-label">
                            <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                                <input type="hidden" id="flag" name="flag" value="3">
                                <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                                <input type="number" max="<?php echo date('Y') ?>" min="2020" name="year" value="" class="floating-input" required>
                                <span class="highlight"></span><label for="">Year </label> 
                                <div><br>
                                    <button type="submit" name="search3" class="btn btn-primary ml-auto d-block">Search</button>
                                </div>
                            </form>
                        </span>
                        <div class="right">
                                <?php if($data != -1 && $flag == 3){ ?>
                                    <h4 class="msg"><?php  echo "Collection year $date: $ $data";
                                } ?> </h4>
                        </div>
                </div>
            </div>
        </main>













        <main class="hoc container clear"> 
            <div class="cardStyle">
                <h2 class="orange center">Statistics Tickets <i class="fa fa-ticket" style="font-size: 1.73em"></i>
            </div>

            <div class="cardStyle mrg_top">
                <div class="one_third">
                    <p> Choose date to search</p>  <br>
                    <div class="floating-label">
                        <form action="<?php echo FRONT_ROOT?>Ticket/showData/" class="center" method="post">
                            <input type="hidden" id="flag" name="flag" value="4">
                            <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                            <input type="date" name="date" value="" class="floating-input" required>
                            <span class="highlight"></span><label for="">Date </label>
                            <div> <br>
                                <button type="submit" name="search4" class="btn btn-primary ml-auto d-block">Search</button>
                            </div>
                        </form>
                    </div> 
                    <div>
                            <?php if($data != -1 && $flag == 4){ ?>
                                <h4 class="msg"><?php  echo "Tickets Sold $date: $data";
                            } ?> </h4>
                    </div>
                </div>
            
           

                <div class="one_third">
                    <p> Choose month this year to search</p>  <br>
                    
                        <span class="floating-label">
                            <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                                <input type="hidden" id="flag" name="flag" value="5">
                                <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                                <input type="number" max="<?php echo date('m') ?>" min="1" name="month" value="" class="floating-input" required>
                                <span class="highlight"></span><label for="">Month </label>
                                <div> <br>
                                    <button type="submit" name="search5" class="btn btn-primary ml-auto d-block">Search</button>
                                </div>
                            </form>
                        </span>
                        <div>
                                <?php if($data != -1 && $flag == 5){ ?>
                                    <h4 class="msg"><?php  echo "Tickets Sold $date: $data";
                                } ?> </h4>
                        </div>
                </div>
            

                <div class="one_quarter right">
                    <p> Choose year to search</p>  <br>
                    
                        <span class="floating-label">
                            <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                                <input type="hidden" id="flag" name="flag" value="6">
                                <input type="hidden" id="idCinema" name="idCinema" value="<?php echo $cinema->getIdCinema(); ?>">
                                <input type="number" max="<?php echo date('Y') ?>" min="2020" name="year" value="" class="floating-input" required>
                                <span class="highlight"></span><label for="">Year </label> 
                                <div><br>
                                    <button type="submit" name="search6" class="btn btn-primary ml-auto d-block">Search</button>
                                </div>
                            </form>
                        </span>
                        <div class="right">
                                <?php if($data != -1 && $flag == 6){ ?>
                                    <h4 class="msg"><?php  echo "Tickets Sold $date: $data";
                                } ?> </h4>
                        </div>
                </div>
            </div>
        </main>

       
    </div>
</div>