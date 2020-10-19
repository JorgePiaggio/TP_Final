<?php
namespace Models;

class Room{         /* sala */

    private $number;
    private $capacity;
    private $type;      /* 2d, 3d */
    private $idCinema;
    private $state;

    function __construct(){}

    function getState(){return $this->state;}
    function getNumber(){return $this->number;}
    function getCapacity(){return $this->capacity;}
    function getType(){return $this->type;}
    function getIdcinema(){return $this->idCinema;}
    function setNumber($number){$this->number=$number;}
    function setCapacity($capacity){$this->capacity=$capacity;}
    function setType($type){$this->type=$type;}
    function setIdcinema($idCinema){$this->idCinema=$idCinema;}
    function setState($state){$this->state=$state;}

}
?>