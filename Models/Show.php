<?php
namespace Models;

use Models\Room as Room;
use Models\Movie as Movie;

class Show{          /* funcion de cine */
    private $idShow;
    private $room;
    private $movie;
    private $dateTime;
    private $shift;             /* turno -mañana,tarde,noche- */
    private $remainingTickets; 

    function __construct(){
        $this->room = new Room();
        $this->movie = new Movie();
    }

    function getIdShow(){return $this->idShow;}
    function getRoom(){return $this->room;}
    function getMovie(){return $this->movie;}
    function getDateTime(){return $this->dateTime;}
    function getShift(){return $this->shift;}
    function getRemainingTickets(){return $this->remainingTickets;}

    function setIdShow($idShow){$this->idShow=$idShow;}
    function setRoom($room){$this->room=$room;}
    function setRoom($movie){$this->movie=$movie;}
    function setDateTime($dateTime){$this->dateTime=$dateTime;}
    function setShift($shift){$this->shift=$shift;}
    function setRemainingTickets($remainingTickets){$this->remainingTickets=$remainingTickets;}

}
?>