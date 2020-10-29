<div class="container background-pic css-selector ">  
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
                              <button type="" class="notCollapsible"><?php echo $movie->getGenres()[0]->getName()?></button>
                              <button type="button" class="collapsible">Show List</button>
                              <div class="content1">
                                <?php foreach($showList as $show){
                                        if($show->getMovie()->getTmdbId() == $movie->getTmdbId()){ ?>
                                          <a href="">
                                            <p class="p_orange">
                                              <?php echo $show->getRoom()->getCinema()->getName()?>
                                            </p> <hr>
                                            <p class="p_white">
                                              <?php echo $show->getDateTime();                        ?>
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
        
                              <!------------------------------------------------ LOS OTROS DOS TERCIOS ---------------------------------->

                        <div class="one_third">
                          <div class="cardStyle mrg_btm">

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
                              <button type="" class="notCollapsible"><?php echo $movie->getGenres()[0]->getName()?></button>
                              <button type="button" class="collapsible">Show List</button>
                              <div class="content1">
                              <?php foreach($showList as $show){
                                        if($show->getMovie()->getTmdbId() == $movie->getTmdbId()){ ?>
                                          <a href="">
                                            <p class="p_orange">
                                              <?php echo $show->getRoom()->getCinema()->getName()?>
                                            </p> <hr>
                                            <p class="p_white">
                                              <?php echo $show->getDateTime();                        ?>
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
.notCollapsible {
  background-color: black;
  color: #FF5723;
  cursor: normal;
  padding: 18px;
  width:100%;
  border: none;
  text-align: center;
  outline: none;
  font-size: 15px;
  font-weight: bold;
}

.collapsible {
  background-color: #FF5723;
  color: black;
  cursor: pointer;
  padding: 18px;
  width:100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
}
.collapsible .active, .collapsible:hover {
  background-color: #dc481a;
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
  background-color: black;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}

.content1 a{
  style: none; 
  color: black;
}

.posterBillboard {
  height:cover;
  width:cover;
  border-top-left-radius: 5%;
  border-top-right-radius: 5%;

}

.p_orange{
  color: #FF5723;
  background:none;
  font-weight: bold;
  font-size: 20px;
  text-align:center;
}

.p_white{
  color:grey;
  background:black;
  text-align:center;
  }

.posterBillboard-hover-zoom {
  overflow: hidden;
}


.posterBillboard-hover-zoom--slowmo .posterBillboard {
  transform-origin: 50% 65%;
  transition: transform 3s, filter 3s ease-in-out;
  filter: brightness(150%);
}

.posterBillboard-hover-zoom--slowmo:hover .posterBillboard {
  filter: brightness(100%);
  transform: scale(1.5);

}


.css-selector {
    background: linear-gradient(115deg, #500e04, #a12806, #270a0a);
    background-size: 600% 600%;

    -webkit-animation: AnimationName 50s ease infinite;
    -moz-animation: AnimationName 50s ease infinite;
    -o-animation: AnimationName 50s ease infinite;
    animation: AnimationName 50s ease infinite;
}

@-webkit-keyframes AnimationName {
    0%{background-position:0% 23%}
    50%{background-position:100% 78%}
    100%{background-position:0% 23%}
}
@-moz-keyframes AnimationName {
    0%{background-position:0% 23%}
    50%{background-position:100% 78%}
    100%{background-position:0% 23%}
}
@-o-keyframes AnimationName {
    0%{background-position:0% 23%}
    50%{background-position:100% 78%}
    100%{background-position:0% 23%}
}
@keyframes AnimationName {
    0%{background-position:0% 23%}
    50%{background-position:100% 78%}
    100%{background-position:0% 23%}
}
</style>



