<?php
    namespace DAO;
    
    use Models\CreditCardPayment as CreditCardPayment;
    use DAO\ICreditCardPaymentDAO as ICreditCardPaymentDAO; 
    use DAO\Connection as Connection;


    class CreditCardPaymentDAO implements ICreditCardPaymentDAO{
        private $connection;
        
        function __construct(){}


        public function add($creditCardPayment){
            $sql = "INSERT INTO creditCards (date, total, idCreditCard)
                            VALUES (:date, :total, :idCreditCard)";
            
            $parameters['date']=$creditCardPayment->getDate();
            $parameters['total']=$creditCardPayment->getTotal();
            $parameters['idCreditCard']=$creditCardPayment->getCreditCard()->getIdCreditCard();
    
            try{
                $this->connection = Connection::getInstance();
                return $this->connection->executeNonQuery($sql, $parameters);
            }
            catch(\PDOException $ex){
                throw $ex;
            }
        }  





    }?>