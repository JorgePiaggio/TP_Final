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
use DAO\MovieDAO as MovieDAO;

use Config\Validate as Validate;
use \DateTime;

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
        private $movieDAO;
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
        $this->movieDAO = new MovieDAO();
        $this->msg=null;
        $this->data=null;
        date_default_timezone_set('America/Argentina/Buenos_Aires');
     
    }


    public function showPurchaseView($idShow=""){
        Validate::checkParameter($idShow);
        $this->validateNotAdmin();
        
        try{
            $show = $this->showDAO->search($idShow);
            $seats=$this->seatDAO->getbyShow($idShow);
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }

        require_once(VIEWS_PATH."Tickets/purchase-view.php");
    }


    public function showConfirm($seats="", $company="", $cardNumber="", $propietaryName="",$propietarySurname="", $monthExp="", $yearExp="", $idShow=""){
        Validate::checkParameter($idShow);
        $this->validateNotAdmin();
        $propietary=$propietaryName." ".$propietarySurname;
        if($seats){
            try{
            $show = $this->showDAO->search($idShow);
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }
          $total=0;
          $discount=$this->calculateDiscount(count($seats),$show->getDateTime(),$show->getRoom()->getPrice(), $total);
          require_once(VIEWS_PATH."Tickets/purchase-confirm.php");  
        }
        else{
            $this->msg="No seats selected";
            $this->showPurchaseView($idShow);
        }

    }


    public function showPurchaseResult($tickets="", $card=""){
        Validate::checkParameter($tickets);
        $this->validateNotAdmin();

        if($tickets){
            $this->msg="Purchase completed successfully, enjoy the show";
        }else{
            $this->msg="A problem has occurred with your purchase, please try again later";
        }
        $seats= array();
        require_once(VIEWS_PATH."Tickets/purchase-result.php");  

    }
    

    public function showSendEmail($name="", $email="", $seats="", $movieTitle="", $date="", $cinema="", $room="", $cantTicket="", $card="", $idShow=""){
        Validate::checkParameter($seats);
        $this->validateNotAdmin();

        $newSeats=explode("/",$seats);
        $seatList=array();
        foreach($newSeats as $seat){
            array_push($seatList,explode("-",$seat));
        }
        require_once(VIEWS_PATH."Tickets/purchase-email.php");
    }


    public function showStatistics($idCinema=""){
        Validate::checkParameter($idCinema);
        Validate::validateSession();

        $data = -1;
        $flag = 0;
        $shift = null;
        $date = null;
        $movie2 = null;
        try{
            $cinema = $this->cinemaDAO->search($idCinema);
            $movieList = $this->cinemaDAO->getBillboard($idCinema);
            $allMovies = $this->showDAO->getAllMoviesByCinema($idCinema);
            $showList=$this->showDAO->getAllbyCinema($idCinema);
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
        require_once(VIEWS_PATH."Cinemas/Cinema-statistics.php");
    }
    

    /*Según la estadística buscada llama a cada función del DAO */
    public function showData($flag="", $idCinema="", $date="", $shift="", $idMovie=""){
        Validate::checkParameter($flag);
        Validate::validateSession();
        try{
            $data = -1;
            $cinema = $this->cinemaDAO->search($idCinema); 
            $movieList = $this->cinemaDAO->getBillboard($idCinema);
            $allMovies = $this->showDAO->getAllMoviesByCinema($idCinema);
            $movie2 = $this->movieDAO->search($idMovie);
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
                case 7:
                    $data = $this->ticketDAO->ticketsByCinemaByShiftByDate($idCinema, $shift, $date);
                    require_once(VIEWS_PATH."Cinemas/Cinema-statistics.php");
                    break;    
                case 8:
                    $data = $this->ticketDAO->ticketsByCinemaByShiftByMonth($idCinema, $shift, $date);
                    require_once(VIEWS_PATH."Cinemas/Cinema-statistics.php");
                    break;   
                case 9:
                    $data = $this->ticketDAO->ticketsByCinemaByShiftByYear($idCinema, $shift, $date);
                    require_once(VIEWS_PATH."Cinemas/Cinema-statistics.php");
                    break;      
                case 10: 
                    $data = $this->ticketDAO->ticketsByCinemaByMovie($idCinema, $idMovie);
                    require_once(VIEWS_PATH."Cinemas/Cinema-statistics.php");
                    break;    
                case 11: 
                    $data = $this->ticketDAO->ticketsByCinemaByMovieByShift($idCinema, $shift, $idMovie);
                    require_once(VIEWS_PATH."Cinemas/Cinema-statistics.php");
                    break;   
            }
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
    }


    /* compra de tickets, crear boleta, pago, tickets y asientos */
    public function add($creditCardCompany="", $creditCardNumber="", $creditCardPropietary="", $monthExp="", $yearExp="", $total="", $seats="", $idShow=""){
        Validate::checkParameter($idShow);
        $this->validateNotAdmin();

        try{
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


            #$expiration=explode("/",$creditCardExpiration);
            $date = date($yearExp."-".$monthExp."-1 0:0:0");
            

            if($show){
                if($show->getRemainingTickets() >= count($seatNumber)){

                
                    /*crear tarjeta de credito */
                    $creditCard= new CreditCard();
                    $creditCard->setCompany($creditCardCompany);
                    $creditCard->setPropietary($creditCardPropietary);
                    $creditCard->setNumber($creditCardNumber);
                    $creditCard->setExpiration($date);
                
                    $card=$this->creditCardDAO->search($creditCardNumber,$creditCardCompany);  
                    if(!$card){     // agregarla si no existe
                        $resultCard=$this->creditCardDAO->add($creditCard);  
                    }

                    if( $card || $resultCard > 0 ){                                                                 // si se aprueba la tarjeta se continua el proceso, sino se cancela

                        /* crear transaccion */
                        $actualDate=date('Y-m-d H:i:s');
                        $creditCardPayment = new CreditCardPayment();
                        $creditCardPayment->setTotal($total);
                        $creditCardPayment->setDate($actualDate);
                        $creditCardPayment->setCreditCard($creditCard);
                        $resultPayment= $this->creditCardPaymentDAO->add($creditCardPayment);

                        if( $resultPayment > 0 ){                                                                   // si se aprueba el pago se continua el proceso

                            // se busca el pago en el DAO porque aun no tenia seteado un id
                            $payment= $this->creditCardPaymentDAO->search($creditCardNumber, $creditCardCompany, date('Y-m-d H:i:s'));
                            
                            /* crear boleta */
                            $bill = new Bill();
                            $bill->setUser($user);
                            $bill->setTickets(count($seatNumber));
                            $bill->setDate($actualDate);
                            $bill->setCreditCardPayment($payment);
                            $bill->setTotalPrice($total);
                            $bill->setDiscount(DISCOUNT);
                            $resultBill = $this->billDAO->add($bill);


                            $ticketList=array();

                            /* crear asientos y tickets */
                            for($indice=0; $indice< count($seatNumber); $indice++){
                                $seat= new Seat();
                                $seat->setRow($seatRow[$indice]+1);
                                $seat->setNumber($seatNumber[$indice]+1);

                                $this->seatDAO->add($seat, $idShow);
                                
                                $ticket = new Ticket();
                                $ticket->setBill($this->billDAO->searchByCodePayment($payment->getCode()));
                                $ticket->setShow($show);
                                $ticket->setSeat($this->seatDAO->search($idShow,$seat->getRow(),$seat->getNumber()));
                                $ticket->setPrice($show->getRoom()->getPrice());
                                $qrCode=APIQRCODE.$creditCardNumber.$seat->getRow().$seat->getNumber().$show->getIdShow();
                                $ticket->setQrCode($qrCode);
                                $this->ticketDAO->add($ticket);
                                array_push($ticketList,$ticket);

                                /* descarga el codigo qr que manda la api */
                                @$rawImage = file_get_contents($qrCode);

                                if($rawImage){
                                    file_put_contents(VIEWS_PATH.'layout/images/tickets/'.$seat->getRow().$seat->getNumber().$show->getIdShow().'.png',$rawImage);
                                }else{
                                    echo 'Error Occured';
                                }
                            }
                    
                            //actualizo las entradas 
                            $show->setRemainingTickets(($show->getRemainingTickets())-count($seatNumber));
                            $this->showDAO->update($show);

                            $this->showPurchaseResult($ticketList,$creditCardNumber);
                        }
                    }

                }else{
                    $this->msg="No available tickets for this show";
                    $this->showPurchaseView($idShow);
                }
            }
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
    }


    /* evalua por dia y cantidad de tickets si corresponde descuento o no */
    private function calculateDiscount($seatNumber="", $date="", $price="", &$total=""){
        Validate::checkParameter($seatNumber);
        $this->validateNotAdmin();

        $total = $price*$seatNumber;

        $day= date('l', strtotime($date));

        if(($day == "Tuesday" || $day == "Wednesday") && $seatNumber >= 2){

            $total = $price * $seatNumber * (1-DISCOUNT/100);
            return true;
        }else{

        return false;
        }
    }


     /* Valida que solo puedan ingresar usuarios registrados no administradores */
     static public function validateNotAdmin(){
        if(!$_SESSION || $_SESSION['role'] == 1){
            header("location:../Home/index");
        }
    }

}
    
?>