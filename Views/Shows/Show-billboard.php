<div class="container background-pic gradient">  
                       <!------------------------------------------------ CONTENT ------------------------------------------------>
  <h2 class="page-title up2">Billboard</h2>
    <main class="hoc container clear" > 

                        <!------------------------------------------------ GALLERY ------------------------------------------------>

              <?php $indice=0;
                  foreach($movieList as $movie){
                      if($indice % 3 == 0){?>
        
                        <!------------------------------------------------ PRIMER TERCIO ------------------------------------------->
        
                        <div class="one_third first">
                          <div class="cardStyle mrg_btm">
                            
                          
                            <div class="">
                              <img class="" src="<?php echo $movie->getPoster()?>" alt="<?php echo $movie->getTitle()?> movie poster">
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
                                <a href=""><p>Lorem ipsum...</p></a>
                                <a href=""><p>Lorem ipsum...</p></a>
                                <a href=""><p>Lorem ipsum...</p></a>
                              </div> 
                            </div>
                          </div>
                        </div>
        
                          <?php 
                      } else { ?>
        
                              <!------------------------------------------------ LOS OTROS DOS TERCIOS ---------------------------------->

                        <div class="one_third">
                          <div class="cardStyle mrg_btm">
            
                            <div class="">
                              <img class="" src="<?php echo $movie->getPoster()?>" alt="<?php echo $movie->getTitle()?> movie poster">
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
                                <a href=""><p>Lorem ipsum...</p></a>
                                <a href=""><p>Lorem ipsum...</p></a>
                                <a href=""><p>Lorem ipsum...</p></a>
                              </div> 
                            </div>
                            </div>
                          </div>
                        <?php 
                      } $indice++;
                    }  ?>
          </div>
                                  <!----------------------------------------------------------------------------------------------------------->
                 
    </div>
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









<style> 

.collapsible {
  background-color: orange;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width:100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
}

.collapsible .active, .collapsible:hover {
  background-color: orangered;
}

.collapsible:after {
  content: '\02795'; 
  font-size: 13px;
  color: white;
  float: right;
  margin-left: 5px;
}

.content1 .active:after {
  content: "\2796"; 
}

.content1 {
  padding: 0 18px;
  background-color: grey;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}

.content1 a{style: none; color: black;}
img {
  height:cover;
  width:cover;
}
 h4{display:inline;
margin-top:-30%;}

</style>



