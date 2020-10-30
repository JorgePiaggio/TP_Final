
<div class="bordo">
  <div class="container ctr"> 
                       <!------------------------------------------------ CONTENT ------------------------------------------------>
    <h2 class="page-title up2 www">Billboard</h2>
    <div class="bkg">
      <main class="container clear " >          
                <span></span> <!-- no borrar ! -->
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
        <div class=" padSides">
                        <!------------------------------------------------ GALLERY ------------------------------------------------>

              <?php $indice=0;
                  foreach($movieList as $movie){
                      if($indice % 4 == 0){?>
                      
                        <!------------------------------------------------ PRIMER CUARTO ------------------------------------------->
        
                        <div class="one_quarter first mrg_btm up">
                          <div class="cardStyle mrg_sides">

                          <button type="" class="notCollapsible"><?php echo $movie->getTitle()?></button>
                          
                            <div class="posterBillboard-hover-zoom posterBillboard-hover-zoom--slowmo">
                              <img class="posterBillboard" src="<?php echo $movie->getPoster()?>" alt="<?php echo $movie->getTitle()?> movie poster">
                            </div>
          
                           <!-- <div class="one_half">
                              <span>
                                  <h4><?php /*echo $movie->getTitle()?></h4>
                              </span>
                              <span>
                                  <h4><?php echo $movie->getReleaseDate() */?></h4>
                              </span>
                            </div>-->
          
                            <div>
                              <button type="button" class="collapsible">Show List</button>
                              <div class="content1">
                                <?php foreach($showList as $show){
                                        if($show->getMovie()->getTmdbId() == $movie->getTmdbId()){ ?>
                                          <a href="">
                                            <p class="p_orange">
                                              <?php if(strlen($show->getRoom()->getCinema()->getName()) > 13){
                                                    $str1 = substr($show->getRoom()->getCinema()->getName(), 0, 11) . '...';
                                                    echo $str1; ?></h6><?php }else{
                                                    echo $show->getRoom()->getCinema()->getName();}?>
                                            </p> <hr>
                                            <p class="p_white">
                                              <?php echo date('l d M - H:i', strtotime($show->getDateTime()))." hs";?>
                                            </p>
                                          </a><?php 
                                        }
                                      }?> 
                              </div> 
                            </div>

                          </div>
                        </div>
        
                          <?php 
                      } else { ?>
        
                              <!------------------------------------------------ LOS OTROS CUARTOS ---------------------------------->

                        <div class="one_quarter mrg_btm up">
                          <div class="cardStyle mrg_sides">
                            
                          <button type="" class="notCollapsible"><?php echo $movie->getTitle()?></button>

                            <div class="posterBillboard-hover-zoom posterBillboard-hover-zoom--slowmo">
                              <img class="posterBillboard" src="<?php echo $movie->getPoster()?>" alt="<?php echo $movie->getTitle()?> movie poster">
                            </div>
            
                             <!-- <div class="one_half">
                              <span>
                                  <h4><?php /*echo $movie->getTitle()?></h4>
                              </span>
                              <span>
                                  <h4><?php echo $movie->getReleaseDate() */?></h4>
                              </span>
                            </div>-->
            
                            <div>
                              <button type="button" class="collapsible">Show List</button>
                              <div class="content1">
                              <?php foreach($showList as $show){
                                        if($show->getMovie()->getTmdbId() == $movie->getTmdbId()){ ?>
                                          <a href="">
                                            <p class="p_orange">
                                              <?php if(strlen($show->getRoom()->getCinema()->getName()) > 13){
                                                    $str1 = substr($show->getRoom()->getCinema()->getName(), 0, 11) . '...';
                                                    echo $str1; ?></h6><?php }else{
                                                    echo $show->getRoom()->getCinema()->getName();}?>
                                            </p> <hr>
                                            <p class="p_white">
                                              <?php echo date('l d M - H:i', strtotime($show->getDateTime()))." hs";?>
                                            </p>
                                          </a><?php 
                                        }
                                      }?> 
                              </div> 
                            </div>
                            </div>
                          </div>
                        <?php 
                      } $indice++;
                    }  ?>
                                <div class="hoc" margin-left="40%"><br>
                                  <?php if($this->msg != null){?> 
                                        <h4 class="msg"><?php  echo $this->msg;
                                    } ?> </h4>
                                </div>      

                                  <!----------------------------------------------------------------------------------------------------------->
      </div>  </div>     
    </div></div>
  </main>
</div>


<script>
var coll = document.getElementsByClassName("collapsible");
var i;
for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    }
  });
}</script>
