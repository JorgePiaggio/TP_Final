<?php
namespace Models;

use Models\Bill as Bill;
use Models\Show as Show;
use Models\Seat as Seat;

class Ticket{ 
    private $idTicket;
    private $bill;
    private $show;
    private $seat;
    private $price;
    private $qrCode; //???
   
    function __construct(){
        $this->bill = new Bill();
        $this->show = new Show();
        $this->seat = new Seat();
    }
    
    function getIdTicket(){return $this->idTicket;}
    function getBill(){return $this->bill;}
    function getShow(){return $this->show;}
    function getPrice(){return $this->price;}
    function getQrCode(){return $this->qrCode;}
    function setIdTicket($idTicket){$this->idTicket=$idTicket;}
    function setBill($bill){$this->bill=$bill;}
    function setShow($show){$this->show=$show;}
    function setPrice($price){$this->price=$price;}
    function setQrCode($qrCode){$this->qrCode=$qrCode;}

}
?>