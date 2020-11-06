<?php

namespace Models;

class Seat{

    private $idSeat;
    private $number;
    private $row;
    

    public function __construct(){
        
    }

    public function setIdSeat($idSeat){$this->idSeat=$idSeat;}
    public function setNumber($number){$this->number = $number;}
    public function setRow($row){$this->row = $row;}
    public function getIdSeat(){return $this->idSeat;}
    public function getNumber(){return $this->number;}
    public function getRow(){return $this->row;}
   

}

?>