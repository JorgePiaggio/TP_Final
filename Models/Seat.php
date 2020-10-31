<?php

namespace Models;

class Seat{

    private $idSeat;
    private $number;
    private $row;
    private $state;

    public function __construct(){
        $this->state=true;
    }

    public function setIdSeat($idSeat){$this->idSeat=$idSeat;}
    public function setNumber($number){$this->number = $number;}
    public function setRow($row){$this->row = $row;}
    public function setState($state){$this->state = $state;}
    public function getIdSeat(){return $this->idSeat;}
    public function getNumber(){return $this->number;}
    public function getRow(){return $this->row;}
    public function getState(){return $this->state;}

}

?>