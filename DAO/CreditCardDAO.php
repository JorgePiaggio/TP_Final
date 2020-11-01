<?php
    namespace DAO;
    
    use Models\CreditCard as CreditCard;
    use DAO\ICreditCardDAO as ICreditCardDAO; 
    use DAO\Connection as Connection;


    class CreditCardDAO implements ICreditCardDAO{
        private $connection;
        
        function __construct(){}


        public function add($creditCard){
            $sql = "INSERT INTO creditCards (company, number, propietary, expiration)
                            VALUES (:company, :number, :propietary, :expiration)";
            
            $parameters['company']=$creditCard->getCompany();
            $parameters['number']=$creditCard->getNumber();
            $parameters['propietary']=$creditCard->getPropietary();
            $parameters['expiration']=$creditCard->getExpiration(); 
    
            try{
                $this->connection = Connection::getInstance();
                return $this->connection->executeNonQuery($sql, $parameters);
            }
            catch(\PDOException $ex){
                throw $ex;
            }
        }  





    }?>