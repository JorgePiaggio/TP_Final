<?php
    namespace Controllers;

    use Models\Show as Show;
    use Models\Genre as Genre;
    use DAO\ShowDAO as ShowDAO;
    use DAO\RoomDAO as RoomDAO;
    use DAO\MovieDAO as MovieDAO;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\GenreDAO as GenreDAO;
    use Config\Validate as Validate;
    use \DateTime;
    use \DateTimeZone;
    use \Exception as Exception;


    class ShowController{
        private $showDAO;
        private $movieDAO;
        private $roomDAO;
        private $cinemaDAO;
        private $genreDAO;
        private $msg;

    
    function __construct(){
        $this->cinemaDAO = new CinemaDAO();
        $this->showDAO = new ShowDAO();
        $this->movieDAO = new MovieDAO();
        $this->roomDAO = new RoomDAO();
        $this->genreDAO = new GenreDAO();
        $this->msg = null;
        date_default_timezone_set('America/Argentina/Buenos_Aires');
    }



    /* mostrar cartelera de todos los cines completa o filtrada por fecha y/o género*/
    public function showBillboard($showList="", $flag="", $actualGenre=""){
        try{
            $allGenre = $this->getAllGenre();                                     //Construyo el genero ficticio all
            $genreList = $this->genreDAO->getAll();                               //Pido todos los generos para el select
            
            if(!$showList && $flag != 1){
                $showList = $this->showDAO->getAllActive();                       //Si todavía no hay filtro muestro todos los shows activos
            }   
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
        $movieList=array();                                                        //Recorro los shows y agrego las movies una sola vez a una lista 
        if($showList){ 
            foreach($showList as $show){
                if(!in_array($show->getMovie(), $movieList)) {
                    array_push($movieList,$show->getMovie());
                }
            }       
        }
        else{
            $this->msg = "No shows on schedule";
        }
                
        require_once(VIEWS_PATH."Shows/Show-billboard.php");
    }


    /* vista para agregar funciones */
    public function showAddView(){
        Validate::validateSession();
        
        try{
            $cinemaList = $this->cinemaDAO->getAllActive();
            $cinema=null;
            if($cinemaList){
                $idCinema=$cinemaList[0]->getIdCinema();
                $roomList = $this->roomDAO->getCinemaRooms($idCinema);
                $movieList = $this->movieDAO->getAllStateOne();
            }
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
        require_once(VIEWS_PATH."Shows/Show-add.php");
    }


    public function showEditView($idShow=""){
        Validate::checkParameter($idShow);
        Validate::validateSession();
        
        try{
            $editShow=$this->showDAO->search($idShow);
            $roomList=$this->roomDAO->getCinemaRooms($editShow->getRoom()->getCinema()->getIdCinema());
            $movieList=$this->movieDAO->getAllStateOne();
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
        require_once(VIEWS_PATH."Shows/Show-edit.php");
    }


    /* agregar show */
    public function add($idRoom="", $idMovie="", $date="", $time=""){
        Validate::checkParameter($idRoom);
        Validate::validateSession();

        if($this->checkAvailability($idMovie, $idRoom, $date,-1)){//para agregar pongo un idshow no existente

            date_default_timezone_set('America/Argentina/Buenos_Aires');
        
            $actualDate=date('Y-m-d H:i:s');
            $dateTime=date($date." ".$time.":00");

            if(strtotime($actualDate)<strtotime($dateTime)){

            
                if($this->validateShow($idRoom,$idMovie,$dateTime,-1)){ //le envio un idshow negativo ya que estoy agregando y no editando
                    $show = new Show();


                    try{
                        $show->setRoom($this->roomDAO->searchById($idRoom)); 
                        $show->setMovie($this->movieDAO->search($idMovie));
                        $show->setDateTime($dateTime);
                        $result = $this->showDAO->add($show);
                    }catch(\Exception $e){
                        echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
                    }


                    if($result > 0){
                        $this->msg = "Show Added Succesfully";
                    }else{
                        $this->msg = "Internal error. Please try again later";
                    }
                }else{
                    $this->msg="There is already a Show for this time";
                }
            }else{
                $this->msg="Incorrect Date";
            }

         

        }else{
            $this->msg="The movie is already in a Show. Please select another movie or pick another date";
        }

        $this->showAddView();
    }


    public function edit($idRoom="", $idMovie="", $date="", $time="", $tickets="", $idShow=""){//para editar idshow 
        Validate::checkParameter($idRoom);
        Validate::validateSession();

        if($this->checkAvailability($idMovie, $idRoom, $date,$idShow)){

            date_default_timezone_set('America/Argentina/Buenos_Aires');
        
            $actualDate=date('Y-m-d H:i:s');
            $dateTime=date($date." ".$time.":00");

            if(strtotime($actualDate)<strtotime($dateTime)){

            
                if($this->validateShow($idRoom,$idMovie,$dateTime,$idShow)){

                    $room=$this->roomDAO->searchById($idRoom);
                   
                    $previusShow=$this->showDAO->search($idShow);
                    $previusRoom=$previusShow->getRoom();
                    $sold=0;

                    if($previusRoom->getCapacity()==$tickets){//si no se vendio entrada 
                        $sold=0;
                    }else{ // si se vendieron entradas
                    $sold= $previusRoom->getCapacity() - $previusShow->getRemainingTickets();
                    }


                    if($previusShow->getMovie()->getTmdbId()!=$idMovie && $sold>0){
                        $this->msg="This show has sold tickets, the movie must be the same";

                    }else{
                        if($previusShow->getDateTime()!=$dateTime && $sold>0){ 
                            $this->msg="This show has sold tickets, the time must be the same";
                            
                        }else{
                            try{

                            if($room->getCapacity()>=$sold){ // ajusto el nuevo valor de tickets , reviso si las entradas vendidas no sobrepasan la capacidad de la nueva sala
                                $tickets=$room->getCapacity()-$sold;
                                $show = new Show();
                                $show->setIdShow($idShow);
                                $show->setRoom($room); 
                                $show->setMovie($this->movieDAO->search($idMovie));
                                $show->setDateTime($dateTime);
                                $show->setRemainingTickets($tickets);
                                $result = $this->showDAO->update($show);
                       
                                if($result > 0){
                                    $this->msg="Edited Correctly";
                                }else{
                                    $this->msg = "Internal error. Please try again later";
                                }
                                }else{
                                    $this->msg="The capacity of the new room is not big enough for the tickets sold";
                                }
                            
                        }catch(\Exception $e){
                            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
                        }



                        }

                    }         
                }else{
                    $this->msg="There is already a Show for this time";
                }
            }else{
                $this->msg="Incorrect Date";
            }
        }else{
            $this->msg="The movie is already in a Show. Please select another movie or pick another date";            
        }
        $this->showEditView($idShow);

    }


    /* elimina show si no tiene entradas vendidas */
    public function remove($idShow=""){
        Validate::checkParameter($idShow);
        Validate::validateSession();

        try{
            $editShow=$this->showDAO->search($idShow);
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }

        if($editShow->getRoom()->getCapacity()==$editShow->getRemainingTickets()){
            $result= $this->showDAO->delete($idShow);
            
            if($result > 0){
                $this->msg="Show Removed Correctly";
            }else{
                $this->msg = "Internal error. Please try again later";
            }

        }else{
            $this->msg="Error: T
            his show has sold tickets";            

        }

        $this->showListView($editShow->getRoom()->getCinema()->getIdCinema());
    }


    /*elegir cine para agregar show */
    public function selectCinema($idCinema=""){
        Validate::checkParameter($idCinema);
        Validate::validateSession();

        try{
            $cinema = $this->cinemaDAO->search($idCinema);
            $cinemaList=$this->cinemaDAO->getAllActive();
            $roomList = $this->roomDAO->getCinemaRooms($idCinema);
            $movieList = $this->movieDAO->getAllStateOne();
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
        require_once(VIEWS_PATH."Shows/Show-add.php");
    }


    public function filterShow($date="", $idGenre=""){
        $showList = array();
        if($_POST){
            if($idGenre == -1){ 
                $actualGenre = $this->getAllGenre();                              //Si eligió all construyo el genero ficticio all
            }
            else{
                try{
                    $actualGenre = $this->genreDAO->search($idGenre);                 //Busco el genero elegido    
                }catch(\Exception $e){
                    echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
                }
            }

            if(!empty($date) && $actualGenre->getId() == -1){                     //Si el filtro es por fecha y todos los generos
                $showList = $this->filterByDate($date);              
            }else if(empty($date) && $actualGenre->getId() != -1){                //Si el filtro es solo por genero                
                $showList = $this->filterByGenre($actualGenre);                                                   
            }else if(!empty($date) && $actualGenre->getId() != -1){               //Si el filtro es por fecha y un genero
                $showList = $this->filterByDateByGenre($date, $actualGenre);                 
            }else{
                try{
                    $showList = $this->showDAO->getAllActive();                       //Si no hay filtro pero se mandó igual el form
                }catch(\Exception $e){
                    echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
                }
            }
        }

        $this->showBillboard($showList, 1, $actualGenre);
    }


    /* Filtra shows por fecha */
    public function filterByDate($date=""){
        Validate::checkParameter($date);

        try{
            $showList = $this->showDAO->getByDate($date);
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
        return $showList;
    }


    /* Filtra shows activos por genero */
    public function filterByGenre($genre=""){  
        Validate::checkParameter($genre);  

        $showList = array();
        try{
            $showsActives = $this->showDAO->getAllActive();                    //Busco shows activos
            foreach($showsActives as $show){                              
                if(in_array($genre, $show->getMovie()->getGenres())){          //Si el genero está en una movie de un show
                    array_push($showList, $show);                              //Lo agrego a la lista de shows final
                }
            } 
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
        return $showList;
    }


      /* Filtra shows por fecha y genero */
    public function filterByDateByGenre($date="", $genre=""){    
        Validate::checkParameter($date); 
        $showList = array();
        try{
            $showsByDate = $this->showDAO->getByDate($date);                  //Busco shows por fecha
            if($showsByDate) 
                foreach($showsByDate as $show){                              
                    if(in_array($genre, $show->getMovie()->getGenres())){     //Si el genero está en una movie de un show
                        array_push($showList, $show);                         //Lo agrego a la lista de shows final
                    }
                } 
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
        return $showList;
    }


    /* lista de shows para admin */
    public function showListView($idCinema=""){
        Validate::validateSession();

        try{
            $cinema=null;
            if($idCinema!=""){
                $cinema = $this->cinemaDAO->search($idCinema);
            }
            $cinemaList=$this->cinemaDAO->getAllActive();
            $showList=null;
            if($cinema){
                $showList=$this->showDAO->getAllByCinema($idCinema);
            }
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
        require_once(VIEWS_PATH."Shows/Show-list.php");

    }


    /* chequea que haya una diferencia de 15 minutos entre funcion y funcion */
    private function validateShow($idRoom="", $idMovie="", $date="", $idShow=""){ // le envio idShow para que no tenga en cuenta el tiempo previo en la misma funcion que estoy editando
        Validate::checkParameter($idShow);
        Validate::validateSession();

        try{
            $showList=$this->showDAO->getShowbyTimebyRoom($idRoom,$date);
            //Runtime y horario de pelicula ingresada
            $movie=$this->movieDAO->search($idMovie);
            $runtimeInput=$movie->getRuntime()*60;
            $showInput=strtotime($date);
            
            if($showList){
            foreach($showList as $show){
                //horario y runtime de pelicula en la BDD
                if($show->getIdShow()!= $idShow){
                    $showTime=strtotime($show->getDateTime());
                    $runtime=$show->getMovie()->getRuntime()*60;
                    if($showTime>$showInput){
                        if($showInput+$runtimeInput > $showTime-900){
                            return false;
                        }
                    }else{
                            if($showTime+$runtime >$showInput-900 ){
                                return false;
                            }
                        }
                    }
                }
            }
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
        return true;

    }
        
    
    /* chequea q la pelicula no este en una funcion en la fecha solicitada */
    private function checkAvailability($idMovie="", $idRoom="", $date="", $idShow=""){
        Validate::checkParameter($idMovie);
        Validate::validateSession();

        try{
            $s=$this->showDAO->getByMovieByDay($idMovie, $date); /* saber si hay funcion de esa peli ese dia */
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }

        
        if($s != null){
            foreach($s as $show){
                if($show->getRoom()->getIdRoom() != $idRoom && $idShow!=$show->getIdShow()){  
                    return false;
                }else{
                    return true;    /* si la funcion es en la misma sala, se permite */
                }
            }
        }else{
            return true;
        }
    }
    

     /*Genero ficticio para traer todas las películas con todos los géneros */
     private function getAllGenre(){
        $all= new Genre();
        $all->setName("All");
        $all->setId(-1);
        return $all;
    }

    


}
    
?>

