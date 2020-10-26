<?php
namespace Models;

use Models\Movie as Movie;
class Cinema{ 

    private $idCinema;
    private $state;
    private $name;
    private $street;
    private $number;
    private $phone;
    private $email;
    private $billboard;
    
   
    function __construct(){
        $this->state = true;
        $this->billboard=array();
    }
    
    function getIdCinema(){return $this->idCinema;}
    function getName(){return $this->name;}
    function getStreet(){return $this->street;}
    function getNumber(){return $this->number;}
    function getPhone(){return $this->phone;}
    function getEmail(){return $this->email;}
    function getState(){return $this->state;}
    function getBillboard(){return $this->billboard;}

    function setIdCinema($idCinema){$this->idCinema=$idCinema;}
    function setName($name){$this->name=$name;}
    function setStreet($street){$this->street=$street;}
    function setNumber($number){$this->number=$number;}
    function setPhone($phone){$this->phone=$phone;}
    function setEmail($email){$this->email=$email;}
    function setState($state){$this->state=$state;}
    function setBillboard($billboard){$this->billboard=$billboard;}

    function addMovie(Movie $movie){if($movie){array_push($this->billboard,$movie);}} 

}
?>

