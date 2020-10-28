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


    public function showAddView(){
        $cinemaList = $this->cinemaDAO->getAllActive();
        $roomList = $this->roomDAO->getAll();
        $movieList = $this->movieDAO->getAll();
        require_once(VIEWS_PATH."Shows/Show-add.php");
    }

    public function ShowSelectCinema(){
        require_once(VIEWS_PATH."Shows/Show-add.php");
    }

    public function add($idCinema, $idRoom, $idMovie, $date, $time){
        $timeFormat = explode(":", $time);
        
        $dateTime = new DateTime($date,new DateTimeZone('America/Argentina/Buenos_Aires'));
        $dateTime->setTime($timeFormat[0], $timeFormat[1]);
        
        $show = new Show();
        $show->setRoom($this->roomDAO->searchById($idRoom)); 
        $show->setMovie($this->movieDAO->search($idMovie));
        $show->setDateTime($dateTime);
        $this->showDAO->add($show);
    }

    public function selectCinema($idCinema){
        $cinemaList = $this->cinemaDAO->search($idCinema);
        $roomList = $this->roomDAO->getCinemaRooms($idCinema);
        $movieList = $this->cinemaDAO->getBillboard($idCinema);
        $this->ShowSelectCinema();
    }
        
}
    
?>

