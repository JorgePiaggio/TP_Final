<?php

    namespace Models;

    use Models\CreditCard as CreditCard;

    class CreditCardPayment(){
        private $code;
        private $date;
        private $total;
        private $creditCard;

        function __construct(){
            $this->creditCard = new CreditCard();
        }


        public function setCode($code){$this->code=$code;}
        public function setDate($date){$this->date=$date;}
        public function setTotal($total){$this->total=$total;}
        public function setCreditCard($creditCard){$this->creditCard=$creditCard;}

        public function getCode(){return $this->code;}
        public function getDate(){return $this->date;}
        public function getTotal(){return $this->total;}
        public function getCreditCard(){return $this->creditCard;}


    }

?>