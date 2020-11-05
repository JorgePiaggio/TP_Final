<?php
namespace Models;

use Models\Seat as Seat;
use Models\Cinema as Cinema;

class Room{         /* sala */

    private $idRoom;
    private $name;
    private $capacity;
    private $type;      /* 2d, 3d */
    private $ticketPrice;
    private $rows;
    private $columns;
    private $cinema;
    private $state;


    function __construct(){
        $this->cinema = new Cinema();
        $this->state=true;
    
    }

    function getIdRoom(){return $this->idRoom;}
    function getName(){return $this->name;}
    function getCapacity(){return $this->capacity;}
    function getType(){return $this->type;}
    function getPrice(){return $this->ticketPrice;}
    function getCinema(){return $this->cinema;}
    function getRows(){return $this->rows;}
    function getColumns(){return $this->columns;}
    function getState(){return $this->state;}

    function setIdRoom($idRoom){$this->idRoom=$idRoom;}
    function setName($name){$this->name=$name;}
    function setCapacity($capacity){$this->capacity=$capacity;}
    function setType($type){$this->type=$type;}
    function setPrice($ticketPrice){$this->ticketPrice=$ticketPrice;}
    function setCinema($cinema){$this->cinema=$cinema;}
    function setRows($rows){$this->rows=$rows;}
    function setColumns($columns){$this->columns=$columns;}
    function setState($state){$this->state=$state;}


}
?>