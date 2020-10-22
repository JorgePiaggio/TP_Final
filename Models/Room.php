<?php
namespace Models;

class Room{         /* sala */

    private $idRoom;
    private $idCinema;
    private $number;
    private $capacity;
    private $type;      /* 2d, 3d */
    private $state;
    private $ticketPrice;

    function __construct(){}

    function getIdRoom(){return $this->idRoom;}
    function getState(){return $this->state;}
    function getNumber(){return $this->number;}
    function getCapacity(){return $this->capacity;}
    function getType(){return $this->type;}
    function getIdCinema(){return $this->idCinema;}
    function getPrice(){return $this->ticketPrice;}
    function setIdRoom($idRoom){$this->idRoom=$idRoom;}
    function setNumber($number){$this->number=$number;}
    function setCapacity($capacity){$this->capacity=$capacity;}
    function setType($type){$this->type=$type;}
    function setIdCinema($idCinema){$this->idCinema=$idCinema;}
    function setState($state){$this->state=$state;}
    function setPrice($ticketPrice){$this->ticketPrice=$ticketPrice;}

}
?>