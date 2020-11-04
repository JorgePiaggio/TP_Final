<?php 

namespace Controllers;

use Models\Ticket as Ticket;
use Models\Bill as Bill;
use Models\CreditCard as CreditCard;
use Models\CreditCardPayment as CreditCardPayment;
use Models\User as User;
use Models\Show as Show;
use Models\Seat as Seat;
use Models\Cinema as Cinema;

use DAO\ShowDAO as ShowDAO;
use DAO\SeatDAO as SeatDAO;
use DAO\TicketDAO as TicketDAO;
use DAO\BillDAO as BillDAO;
use DAO\CreditCardDAO as CreditCardDAO;
use DAO\CreditCardPaymentDAO as CreditCardPaymentDAO;
use DAO\UserDAO as UserDAO;
use DAO\CinemaDAO as CinemaDAO;
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
        private $cinemaDAO;
        private $msg;
        private $data;
      

    function __construct(){
        $this->ticketDAO = new TicketDAO(); 
        $this->billDAO = new BillDAO();
        $this->userDAO = new UserDAO();
        $this->showDAO = new ShowDAO();
        $this->seatDAO = new SeatDAO();
        $this->creditCardDAO = new CreditCardDAO();
        $this->creditCardPaymentDAO = new CreditCardPaymentDAO();
        $this->cinemaDAO = new CinemaDAO();
        $this->msg=null;
        $this->data=null;
        date_default_timezone_set('America/Argentina/Buenos_Aires');
     
    }


    public function showPurchaseView($idShow){
        $show = $this->showDAO->search($idShow);
        $seats=$this->seatDAO->getbyShow($idShow);
        require_once(VIEWS_PATH."Tickets/purchase-view.php");
    }


    public function showConfirm($seats, $company, $cardNumber, $propietary, $monthExp, $yearExp, $idShow){
        
   
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

    public function showPurchaseResult($tickets){

        if($tickets){
            $this->msg="Purchase completed successfully, enjoy the show";
        }else{
            $this->msg="A problem has occurred with your purchase, please try again later";
        }
        $seats= array();
        require_once(VIEWS_PATH."Tickets/purchase-result.php");  

    }

    public function showStatistics($idCinema=""){
        $data = -1;
        $flag = 0;
        $date = null;
        $cinema = $this->cinemaDAO->search($idCinema);
        $movieList = $this->cinemaDAO->getBillboard($idCinema);
        $showList=$this->showDAO->getAllbyCinema($idCinema);
        require_once(VIEWS_PATH."Cinemas/Cinema-statistics.php");
    }

    public function showSendEmail($name,$email,$seats,$movieTitle,$date,$cinema,$room,$cantTicket,$idShow){
        $newSeats=explode("/",$seats);
        $seatList=array();
        foreach($newSeats as $seat){
            array_push($seatList,explode("-",$seat));
        }
        require_once(VIEWS_PATH."Tickets/purchase-email.php");
    }


    public function showData($flag, $idCinema, $date=""){
        $data = -1;
        $cinema = $this->cinemaDAO->search($idCinema); 
        $movieList = $this->cinemaDAO->getBillboard($idCinema);
        $showList=$this->showDAO->getAllbyCinema($idCinema);
        switch($flag){
            case 1:
                $data = $this->ticketDAO->cashByCinemaByDate($idCinema, $date);
                require_once(VIEWS_PATH."Cinemas/Cinema-statistics.php");
                break;
            case 2:
                $data = $this->ticketDAO->cashByCinemaByMonth($idCinema, $date);
                require_once(VIEWS_PATH."Cinemas/Cinema-statistics.php");
                break;
            case 3:
                $data = $this->ticketDAO->cashByCinemaByYear($idCinema, $date);
                require_once(VIEWS_PATH."Cinemas/Cinema-statistics.php");
                break;
            case 4:
                $data = $this->ticketDAO->ticketsByCinemaByDate($idCinema, $date);
                require_once(VIEWS_PATH."Cinemas/Cinema-statistics.php");
                break;
            case 5:
                $data = $this->ticketDAO->ticketsByCinemaByMonth($idCinema, $date);
                require_once(VIEWS_PATH."Cinemas/Cinema-statistics.php");
                break;
            case 6:
                $data = $this->ticketDAO->ticketsByCinemaByYear($idCinema, $date);
                require_once(VIEWS_PATH."Cinemas/Cinema-statistics.php");
                break;      
        }
    }

    public function add($creditCardCompany,$creditCardNumber, $creditCardPropietary, $creditCardExpiration,$total,$seats,$idShow){
        Validate::checkParameter($idShow);

        $show=$this->showDAO->search($idShow);
        $user=$this->userDAO->search($_SESSION["loggedUser"]);
        $seatsArray=explode("/",$seats);
        $seatNumber=array();
        $seatRow=array();
        foreach($seatsArray as $seat){
        $value=explode("-",$seat);
        array_push($seatNumber,$value[1]);
        array_push($seatRow,$value[0]);
        }

        //var_dump($seatNumber);

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
             
                $card=$this->creditCardDAO->search($creditCardNumber,$creditCardCompany);
                if(!$card){
                $this->creditCardDAO->add($creditCard);
                }
                /* crear transaccion */
                $actualDate=date('Y-m-d H:i:s');
                $creditCardPayment = new CreditCardPayment();
                $creditCardPayment->setTotal($total);
                $creditCardPayment->setDate($actualDate);
                $creditCardPayment->setCreditCard($creditCard);
                $this->creditCardPaymentDAO->add($creditCardPayment);
                $payment= $this->creditCardPaymentDAO->search($creditCardNumber, $creditCardCompany, date('Y-m-d H:i:s'));
                
                /* crear boleta */
                $bill = new Bill();
                $bill->setUser($user);
                $bill->setTickets(count($seatNumber));
                $bill->setDate($actualDate);
                $bill->setCreditCardPayment($payment);
                $bill->setTotalPrice($total);
                $bill->setDiscount(DISCOUNT);
                $this->billDAO->add($bill);

                $ticketList=array();

                /* crear asientos y tickets */
                for($indice=0; $indice< count($seatNumber); $indice++){
                    $seat= new Seat();
                    $seat->setRow($seatRow[$indice]+1);
                    $seat->setNumber($seatNumber[$indice]+1);

                    $this->seatDAO->add($seat, $idShow);
                    
                    $ticket = new Ticket();
                    
                   # var_dump($this->billDAO->searchByCodePayment($payment->getCode()));
                    $ticket->setBill($this->billDAO->searchByCodePayment($payment->getCode()));
                    
                    $ticket->setShow($show);
                    $ticket->setSeat($this->seatDAO->search($idShow,$seat->getRow(),$seat->getNumber()));
                    $ticket->setPrice($show->getRoom()->getPrice());
                    $qrCode=APIQRCODE.$creditCardNumber.$seat->getRow().$seat->getNumber().$show->getIdShow();
                    $ticket->setQrCode($qrCode);

                    $this->ticketDAO->add($ticket);
                    array_push($ticketList,$ticket);

                    $imageUrl = $qrCode.".png";
                    @$rawImage = file_get_contents($imageUrl);
                    if($rawImage)
                    {
                    file_put_contents(VIEWS_PATH.'layout/images/tickets/'.$seat->getRow().$seat->getNumber().$show->getIdShow().'.png',$rawImage);
                    }
                    else
                    {
                    echo 'Error Occured';
                    }

                }
                //actualizo las entradas 
                $show->setRemainingTickets(($show->getRemainingTickets())-count($seatNumber));
                $this->showDAO->update($show);

                $this->showPurchaseResult($ticketList);

            }else{
                $this->msg="No available tickets for this show";
                $this->showPurchaseView($idShow);
            
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