<?php
namespace Models;

class Room{         /* sala */

    private $number;
    private $capacity;
    private $type; /* 2d, 3d */

    function __construct(){}

    function getNumber(){return $this->number;}
    function getCapacity(){return $this->capacity;}
    function getType(){return $this->type;}
    function setNumber($number){$this->number=$number;}
    function setCapacity($capacity){$this->capacity=$capacity;}
    function setType($type){$this->type=$type;}

}
?>