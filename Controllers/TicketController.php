<?php 

namespace Controllers;

use Models\Ticket as Ticket;
use Models\Bill as Bill;
use Models\CreditCard as CreditCard;
use Models\CreditCardPayment as CreditCardPayment;
use Models\User as User;
use Models\Show as Show;
use Models\Seat as Seat;

use DAO\ShowDAO as ShowDAO;
use DAO\SeatDAO as SeatDAO;
use DAO\TicketDAO as TicketDAO;
use DAO\BillDAO as BillDAO;
use DAO\CreditCardDAO as CreditCardDAO;
use DAO\CreditCardPaymentDAO as CreditCardPaymentDAO;
use DAO\UserDAO as UserDAO;
use Config\Validate as Validate;

define("DISCOUNT", 25);
define ("APIQRCODE", 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=');

    class TicketController{
        private $ticketDAO;
        private $billDAO;
        private $userDAO;
        private $showDAO;
        private $seatDAO;
        private $creditCardDAO;
        private $creditCardPaymentDAO;
        private $msg;
        private $seats;

    function __construct(){
        $this->ticketDAO = new TicketDAO();
        $this->billDAO = new BillDAO();
        $this->userDAO = new UserDAO();
        $this->showDAO = new ShowDAO();
        $this->seatDAO = new SeatDAO();
        $this->creditCardDAO = new CreditCardDAO();
        $this->creditCardPaymentDAO = new CreditCardPaymentDAO();
        $this->msg=null;
        $this->seats=array();
    }


    public function showPurchaseView($idShow){
        $show = $this->showDAO->search($idShow);
        $seats=$this->seatDAO->getbyShow($idShow);
        require_once(VIEWS_PATH."Tickets/purchase-view.php");
    }


    public function showConfirm($seats, $company, $cardNumber, $propietary, $monthExp, $yearExp, $idShow){
        
        $this->seats=$seats;
        

        if($seats){
          $show = $this->showDAO->search($idShow);
          $total=0;
          $discount=$this->calculateDiscount(count($seats),$show->getDateTime(),$show->getRoom()->getPrice(), $total);

          require_once(VIEWS_PATH."Tickets/purchase-confirm.php");  
        }
        else{
            $this->msg="No seats selected";
            $this->showPurchaseView($idShow);
        }

    }

    public function add($creditCardCompany,$creditCardNumber, $creditCardPropietary, $creditCardExpiration, $idShow){
        //Validate::checkParameter($idShow);

        $show=$this->showDAO->search($idShow);
        $user=$this->userDAO->search($_SESSION["loggedUser"]);
        $seatNumber=array();
        $seatRow=array();
        foreach($this->seats as $seat){
        $value=explode("-",$seat);
        array_push($seatNumber,$value[1]);
        array_push($seatRow,$value[0]);
        }

        $expiration=explode("/",$creditCardExpiration);
        $date = date("Y-m-d", mktime($expiration[1],$expiration[0],1));
        if($show){
            if($show->getRemainingTickets() >= count($seatNumber)){

            
                /*creat tarjeta de credito */
                $creditCard= new CreditCard();
                $creditCard->setCompany($creditCardCompany);
                $creditCard->setPropietary($creditCardPropietary);
                $creditCard->setNumber($creditCardNumber);
                $creditCard->setExpiration($date);
             

                $this->creditCardDAO->add($creditCard);

                /* crear transaccion */
                $actualDate=date('Y-m-d H:i:s');
                $creditCardPayment = new CreditCardPayment();
                $creditCardPayment->setTotal(count($seatNumber) * $show->getRoom()->getPrice());
                $creditCardPayment->setDate($actualDate);
                $creditCardPayment->setCreditCard($creditCard);
                $this->creditCardPaymentDAO->add($creditCardPayment);
                $payment= $this->creditCardPaymentDAO->search($creditCardNumber, $creditCardCompany, date('Y-m-d'));

                /* crear boleta */
                $bill = new Bill();
                $bill->setUser($user);
                $bill->setCreditCardPayment($creditCardPayment);
                $bill->setTickets(count($seatNumber));
                $bill->setDate($actualDate);
                $bill->setCreditCardPayment($payment);
                $this->calculateDiscount(count($seatNumber), $show->getDateTime(), $show->getRoom()->getPrice(),$totalBill);
                $bill->setTotalPrice($totalBill);
                $bill->setDiscount(DISCOUNT);
                $this->billDAO->add($bill);

                /* crear asientos y tickets */
                for($indice=0; $indice< count($seatNumber); $indice++){
                    $seat= new Seat();
                    $seat->setRow($seatRow[$indice]);
                    $seat->setNumber($seatNumber[$indice]);
                    $this->seatDAO->add($seat, $idShow);

                    $ticket = new Ticket();
                    $ticket->setBill($bill);
                    $ticket->setShow($show);
                    $ticket->setSeat($seat);
                    $ticket->setPrice($show->getRoom()->getPrice());
                    $qrCode=APIQRCODE.$creditCardNumber.$actualDate;
                    $ticket->setQrCode($qrCode);

                    var_dump($ticket);
                   

                    $this->ticketDAO->add($ticket);
                }

            }else{
                $this->msg="Not available tickets for this show";
                }
            

        }

        //poner vista

    }


    private function calculateDiscount($seatNumber, $date, $price,&$total){
        $total = $price*$seatNumber;

        $day= date('l', strtotime($date));

        if(($day == "Tuesday" || $day == "Wednesday") && $seatNumber >= 2){

            $total = $price * $seatNumber * (1-DISCOUNT/100);
            return true;
        }else{

        return false;
        }
    }
}

?>