<?php
namespace Models;

class Show{          /* funcion de cine */
    private $idShow;
    private $idCinema;
    private $idRoom;
    private $idMovie;
    private $dateTime;
    private $shift;             /* turno -mañana,tarde,noche- */
    private $remainingTickets; 

    function __construct(){}

    function getIdShow(){return $this->idShow;}
    function getIdCinema(){return $this->idCinema;}
    function getIdRoom(){return $this->idRoom;}
    function getDateTime(){return $this->dateTime;}
    function getShift(){return $this->shift;}
    function getRemainingTickets(){return $this->remainingTickets;}

    function setIdShow($idShow){$this->idShow=$idShow;}
    function setIdCinema($idCinema){$this->idCinema=$idCinema;}
    function setIdRoom($idRoom){$this->idRoom=$idRoom;}
    function setDateTime($dateTime){$this->dateTime=$dateTime;}
    function setShift($shift){$this->shift=$shift;}
    function setRemainingTickets($remainingTickets){$this->remainingTickets=$remainingTickets;}

}
?>