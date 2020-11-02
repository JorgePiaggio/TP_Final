<?php
    namespace DAO;
    
    use Models\CreditCardPayment as CreditCardPayment;
    use DAO\ICreditCardPaymentDAO as ICreditCardPaymentDAO; 
    use DAO\Connection as Connection;


    class CreditCardPaymentDAO implements ICreditCardPaymentDAO{
        private $connection;
        
        function __construct(){}


        public function add($creditCardPayment){
            $sql = "INSERT INTO creditCardPayments (datePayment, total, idCreditCard,idCreditCardCompany)
                            VALUES (:date, :total, :idCreditCard, :idCreditCardCompany)";
            
            $parameters['date']=$creditCardPayment->getDate();
            $parameters['total']=$creditCardPayment->getTotal();
            $parameters['idCreditCard']=$creditCardPayment->getCreditCard()->getNumber();
            $parameters['idCreditCardCompany']=$creditCardPayment->getCreditCard()->getCompany();
    
            try{
                $this->connection = Connection::getInstance();
                return $this->connection->executeNonQuery($sql, $parameters);
            }
            catch(\PDOException $ex){
                throw $ex;
            }
        }  

           
        public function search($number,$company,$date){
            try
            {
                $query = "SELECT * FROM creditCardPayments  WHERE idCreditCard=:number and idCreditCardCompany=:company and DATEDIFF(datePayment, :date) = 0";
                $parameters["number"]=$number;
                $parameters["company"]=$company;
                $parameters["date"]=$date;

                $this->connection = Connection::getInstance();

                $results = $this->connection->execute($query,$parameters);

               
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            if(!empty($results)){
                return $this->map($results[0]);
            }else{
                return null;
            }  
        }



        protected function map($value){
            
/* mapear tarjeta de credito */
         
                $payment= new CreditCardPayment();
                $payment->setCode($value['idCreditCardPayment']);
                $payment->setDate($value['datePayment']);
                $payment->setTotal($value['total']);

                return $payment;
            

        }









    }?>