<?php
namespace Models;

class Show{          /* funcion de cine */
    private $idShow;
    private $idCinema;
    private $idRoom;
    private $idMovie;
    private $date;
    private $shift;             /* turno -mañana,tarde,noche- */
    private $remainingTickets; 

    function __construct(){}

    function getIdShow(){return $this->idShow;}
    function getIdCinema(){return $this->idCinema;}
    function getIdRoom(){return $this->idRoom;}
    function getDate(){return $this->date;}
    function getShift(){return $this->shift;}
    function getRemainingTickets(){return $this->remainingTickets;}

    function setIdShow($idShow){$this->idShow=$idShow;}
    function setIdCinema($idCinema){$this->idCinema=$idCinema;}
    function setIdRoom($idRoom){$this->idRoom=$idRoom;}
    function setDate($date){$this->date=$date;}
    function setShift($shift){$this->shift=$shift;}
    function setRemainingTickets($remainingTickets){$this->remainingTickets=$remainingTickets;}

}
?>