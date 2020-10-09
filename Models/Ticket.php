<?php
namespace Models;

class Ticket{ 

    private $id;
    private $price;
    private $qrCode;
  
    function __construct(){
    }
    
    function getId(){return $this->id;}
    function getPrice(){return $this->price;}
    function getQrCode(){return $this->qrCode;}
    function setId($id){$this->id=$id;}
    function setPrice($price){$this->price=$price;}
    function setQrCode($qrCode){$this->qrCode=$qrCode;}

}
?>