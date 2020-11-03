<div class="wrapper bgded overlay" style="background-image:url('<?php echo IMG_PATH?>/backgrounds/tickets.jpg');">
    <h2 class="page-title">Stadistics</h2>
    <div class="cardStyle">
        <main class="hoc container clear"> 
            
            <div class="cardStyle">
                <h2 class="orange center">Statistics Cash</h2>
            </div>

            <div class="cardStyle mrg_top">
                <p> Choose date to search</p>  <br>
                <div class="floating-label">
                    <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                        <input type="date" name="date" value=""  min="<?php echo date('Y-m-d');?>" class="floating-input" required>
                        <span class="highlight"></span><label for="">Date </label>
                        <button type="submit" name="search" class="btn btn-primary ml-auto d-block">Search</button>
                    </form>
                    

                </div> 
            </div>

            <div class="cardStyle mrg_top">
                <p> Choose month this year to search</p>  <br>
                <span class="floating-label">
                    <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                        <input type="number" max="<?php echo date('m') ?>" min="1" name="monthExp" value="" placeholder=""  class="floating-input" required>
                        <span class="highlight"></span><label for="">Month </label>
                        <button type="submit" name="search" class="btn btn-primary ml-auto d-block">Search</button>
                    </form>
                </span>
            </div>

            <div class="cardStyle mrg_top">
                <p> Choose year to search</p>  <br>
                <span class="floating-label">
                    <form action="<?php echo FRONT_ROOT?>Ticket/showData" class="center" method="post">
                        <input type="number" max="<?php echo date('Y') ?>" min="2020" name="monthExp" value="" placeholder=""  class="floating-input" required>
                        <span class="highlight"></span><label for="">Year </label>
                        <button type="submit" name="search" class="btn btn-primary ml-auto d-block">Search</button>
                    </form>
                </span>
            </div>
            
        </main>
    </div>
</div>