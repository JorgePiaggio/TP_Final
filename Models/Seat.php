<?php

namespace Models;

class Seat{
    private $number;
    private $row;
    private $idRoom;
    private $state;

    public function __construct(){}


    public function setNumber($number){$this->number = $number;}
    public function seRow($row){$this->row = $row;}
    public function setIdRoom($state){$this->state = $state;}
    public function setState($state){$this->state = $state;}

    public function getNumber(){return $this->number;}
    public function getRow(){return $this->row;}
    public function getIdRoom(){return $this->state;}
    public function getState(){return $this->state;}

}

?>