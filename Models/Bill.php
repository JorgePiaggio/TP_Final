<?php
namespace Models;

use Models\User as User;
use Models\CreditCardPayment as CreditCardPayment; 

class Bill { 
    
    private $idBill;
    private $user;
    private $creditCardPayment;
    private $tickets;  //cantidad
    private $date;
    private $totalPrice;
    private $discount; //float
    
    function __construct(){
        $this->user = new User();
        $this->creditCardPayment = new CreditCardPayment();
    }
    

    public function getIdBill(){return $this->idBill;}
    public function getUser(){return $this->user;}
    public function getCreditCardPayment(){return $this->creditCardPayment;}
    public function getTickets(){return $this->tickets;}
    public function getDate(){return $this->date;}
    public function getTotalPrice(){return $this->totalPrice;}
    public function getDiscount(){return $this->discount;}
    public function setIdBill($idBill){$this->idBill=$idBill;}
    public function setUser($user){$this->user=$user;}
    public function setCreditCardPayment($creditCardPayment){$this->creditCardPayment=$creditCardPayment;}
    public function setTickets($tickets){$this->tickets=$tickets;}
    public function setDate($date){$this->date=$date;}
    public function setDiscount($discount){$this->discount=$discount;}
    public function setTotalPrice($totalPrice){$this->totalPrice=$totalPrice;}
    
}
?>