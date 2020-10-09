<?php
namespace Models;

class Show{     /* funcion de cine */

    private $date;
    private $shift; /* turno -mañana,tarde,noche- */
    private $remainingTickets; 

    function __construct(){}

    function getDate(){return $this->date;}
    function getShift(){return $this->shift;}
    function getRemainingTickets(){return $this->remainingTickets;}
    function setDate($date){$this->date=$date;}
    function setShift($shift){$this->shift=$shift;}
    function setRemainingTickets($remainingTickets){$this->remainingTickets=$remainingTickets;}

}
?>