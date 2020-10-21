<?php
namespace Models;

class Room{         /* sala */

    private $number;
    private $capacity;
    private $type;      /* 2d, 3d */
    private $idCinema;
    private $state;
    private $ticketPrice;

    function __construct(){}

    function getState(){return $this->state;}
    function getNumber(){return $this->number;}
    function getCapacity(){return $this->capacity;}
    function getType(){return $this->type;}
    function getIdCinema(){return $this->idCinema;}
    function getPrice(){return $this->ticketPrice;}
    function setNumber($number){$this->number=$number;}
    function setCapacity($capacity){$this->capacity=$capacity;}
    function setType($type){$this->type=$type;}
    function setIdCinema($idCinema){$this->idCinema=$idCinema;}
    function setState($state){$this->state=$state;}
    function setPrice($ticketPrice){$this->ticketPrice=$ticketPrice;}

}
?>