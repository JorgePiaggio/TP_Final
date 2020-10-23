<?php
namespace Models;

use Models\Room as Room;

class Cinema{ 

    private $idCinema;
    private $state;
    private $name;
    private $street;
    private $number;
    private $phone;
    private $email;
    
   
    function __construct(){
        $this->state = true;
        $this->rooms = array();
    }
    
    function getIdCinema(){return $this->idCinema;}
    function getName(){return $this->name;}
    function getStreet(){return $this->street;}
    function getNumber(){return $this->number;}
    function getPhone(){return $this->phone;}
    function getEmail(){return $this->email;}
    function getState(){return $this->state;}

    function setIdCinema($idCinema){$this->idCinema=$idCinema;}
    function setName($name){$this->name=$name;}
    function setStreet($street){$this->street=$street;}
    function setNumber($number){$this->number=$number;}
    function setPhone($phone){$this->phone=$phone;}
    function setEmail($email){$this->email=$email;}
    function setState($state){$this->state=$state;}

}
?>

