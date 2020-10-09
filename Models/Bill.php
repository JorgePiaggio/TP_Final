<?php
namespace Models;
use Models\Ticket as Ticket;
use Models\Discount as Discount;

class Bill implements Discount, Ticket{ 

    private $id;
    private $tickets;
    private $date;
    private $totalPrice;
    private $discount;
    
    function __construct(){
       $this->tickets= array();
       $this->discount= new Discount();
       $this->discount->setStatus(false);
    }
    
    function getId(){return $this->id;}
    function getTickets(){return $this->tickets;}
    function getDate(){return $this->date;}
    function getTotalPrice(){return $this->totalPrice;}
    function getDiscount(){return $this->discount;}
    function setId($id){$this->id=$id;}
    function setTickets($tickets){$this->tickets=$tickets;}
    function setDate($date){$this->date=$date;}
    function setDiscount($discount){$this->discount=$discount;}
    function setTotalPrice(){}
    
}
?>