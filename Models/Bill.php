<?php
namespace Models;
use Models\Ticket as Ticket;
use Models\Discount as Discount;

class Bill implements Discount, Ticket{ 

    private $idTicket;
    private $idBill;
    private $tickets;  //cantidad
    private $date;
    private $totalPrice;
    private $discount; //float
    
    function __construct(){
       #$this->discount= new Discount();
       #$this->discount->setStatus(false);
    }
    
    function getIdTicket(){return $this->idTicket;}
    function getIdBill(){return $this->idBill;}
    function getTickets(){return $this->tickets;}
    function getDate(){return $this->date;}
    function getTotalPrice(){return $this->totalPrice;}
    function getDiscount(){return $this->discount;}
    function setIdTicket($idTicket){$this->idTicket=$idTicket;}
    function setIdBill($idBill){$this->idBill=$idBill;}
    function setTickets($tickets){$this->tickets=$tickets;}
    function setDate($date){$this->date=$date;}
    function setDiscount($discount){$this->discount=$discount;}
    function setTotalPrice(){}
    
}
?>