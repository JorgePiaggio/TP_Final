<?php
    namespace Controllers;

    use Models\Show as Show;
    use DAO\ShowDAO as ShowDAO;
    use DAO\RoomDAO as RoomDAO;
    use DAO\MovieDAO as MovieDAO;
    use DAO\CinemaDAO as CinemaDAO;
    use Config\Validate as Validate;
    use \DateTime;
    use \DateTimeZone;


    class ShowController{
        private $showDAO;
        private $movieDAO;
        private $roomDAO;
        private $cinemaDAO;
        private $msg;

    
    function __construct(){
        $this->cinemaDAO = new CinemaDAO();
        $this->showDAO = new ShowDAO();
        $this->movieDAO = new MovieDAO();
        $this->roomDAO = new RoomDAO();
        $this->msg = null;
    }



    /* mostrar cartelera completa */
    public function showBillboard(){
        $showList = $this->showDAO->getAllActive();
        $movieList=array();
        foreach($showList as $show){
            if(!in_array($show->getMovie(), $movieList)) {
                array_push($movieList,$show->getMovie());
            }
        }
        #var_dump($movieList);
        require_once(VIEWS_PATH."Shows/Show-billboard.php");
    }


    /* vista para agregar funciones */
    public function showAddView(){
        $cinemaList = $this->cinemaDAO->getAllActive();
        $cinema=null;
        if($cinemaList){
        $idCinema=$cinemaList[0]->getIdCinema();
        $roomList = $this->roomDAO->getCinemaRooms($idCinema);
        $movieList = $this->movieDAO->getAllStateOne();
        }
        require_once(VIEWS_PATH."Shows/Show-add.php");
    }


    /* agregar show */
    public function add($idRoom, $idMovie, $date, $time){
        
        if($this->checkAvailability($idMovie, $idRoom, $date)){

            date_default_timezone_set('America/Argentina/Buenos_Aires');
        
            $actualDate=date('Y-m-d H:i');
            $dateTime=date($date." ".$time);

            if(strtotime($actualDate)<strtotime($dateTime)){

                    $timeFormat=explode(":",$time);
                    $dateShow = new DateTime($date);
                    $dateShow->setTime($timeFormat[0], $timeFormat[1]);

            
                if($this->validateShow($idRoom,$idMovie,$dateTime)){
                    $show = new Show();
                    $show->setRoom($this->roomDAO->searchById($idRoom)); 
                    $show->setMovie($this->movieDAO->search($idMovie));
                    $show->setDateTime($dateShow);
                    $this->showDAO->add($show);
                    $this->msg="Added Correctly";
                }else{
                    $this->msg="There is already a Show for this time";
                }
            }else{
                $this->msg="Incorrect Date";
            }

            $this->showAddView();

        }else{
            $this->msg="The film is already in a Show, please select another";
            $this->showAddView();
        }
    }


    /*elegir cine para agregar show */
    public function selectCinema($idCinema){

        $cinema = $this->cinemaDAO->search($idCinema);
        $cinemaList=$this->cinemaDAO->getAllActive();
        $roomList = $this->roomDAO->getCinemaRooms($idCinema);
        $movieList = $this->movieDAO->getAllStateOne();
        require_once(VIEWS_PATH."Shows/Show-add.php");
    }


    /* chequea que haya una diferencia de 15 minutos entre funcion y funcion */
    private function validateShow($idRoom,$idMovie,$date){

        $showList=$this->showDAO->getShowbyTimebyRoom($idRoom,$date);
        //Runtime y horario de pelicula ingresada
        $movie=$this->movieDAO->search($idMovie);
        $runtimeInput=$movie->getRuntime()*60;
        $showInput=strtotime($date);
        
        if($showList){
        foreach($showList as $show){
            //horario y runtime de pelicula en la BDD
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
            
        return true;

    }
        
    /* chequea q la pelicula no este en una funcion en la fecha solicitada */
    private function checkAvailability($idMovie, $idRoom, $date){

        $s=$this->showDAO->getByMovieByDay($idMovie, $date); /* saber si hay funcion de esa peli ese dia */
        
        if($s != null){
            foreach($s as $show){
                if($show->getRoom()->getIdRoom() != $idRoom){  
                    return false;
                }else{
                    return true;    /* si la funcion es en la misma sala, se permite */
                }
            }
        }else{
            return true;
        }
    }
  


}
    
?>

