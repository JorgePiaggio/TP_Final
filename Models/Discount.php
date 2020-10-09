<?php
namespace Models;

class Discount{ 

    private $percentage;
    private $description;
    private $status;
  
    function __construct(){
    }
    
    function getPercentage(){return $this->percentage;}
    function getDescription(){return $this->description;}
    function getStatus(){return $this->status;}
    function setPercentage($percentage){$this->percentage=$percentage;}
    function setDescription($price){$this->price=$price;}
    function setStatus($status){$this->status=$status;}

}
?>