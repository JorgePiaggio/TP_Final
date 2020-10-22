<?php
namespace Models;
use Models\Ticket as Ticket;
use Models\Discount as Discount;

class Bill { 

    
    private $idBill;
    private $idUser;
    private $tickets;  //cantidad
    private $date;
    private $totalPrice;
    private $discount; //float
    
    function __construct(){}
    
    
    public function getIdBill(){return $this->idBill;}
    public function getTickets(){return $this->tickets;}
    public function getDate(){return $this->date;}
    public function getTotalPrice(){return $this->totalPrice;}
    public function getDiscount(){return $this->discount;}
    public function setIdBill($idBill){$this->idBill=$idBill;}
    public function setTickets($tickets){$this->tickets=$tickets;}
    public function setDate($date){$this->date=$date;}
    public function setDiscount($discount){$this->discount=$discount;}
    public function setTotalPrice($totalPrice){$this->totalPrice=$totalPrice;}
    public function setIdUser($idUser){$this->idUser=$idUser;}
    public function getIdUser(){return $this->idUser;}
    
}
?>