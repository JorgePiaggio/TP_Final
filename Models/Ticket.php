<?php
namespace Models;

class Ticket{ 

    private $idTicket;
    private $idBill;
    private $idShow;
    private $price;
    private $qrCode; //???
   
    function __construct(){
    }
    
    function getIdTicket(){return $this->idTicket;}
    function getIdBill(){return $this->idBill;}
    function getIdShow(){return $this->idShow;}
    function getPrice(){return $this->price;}
    function getQrCode(){return $this->qrCode;}
    function setIdTicket($idTicket){$this->idTicket=$idTicket;}
    function setIdBill($idBill){$this->idBill=$idBill;}
    function setIdShow($idShow){$this->idShow=$idShow;}
    function setPrice($price){$this->price=$price;}
    function setQrCode($qrCode){$this->qrCode=$qrCode;}

}
?>