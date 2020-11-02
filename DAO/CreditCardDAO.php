<?php
    namespace DAO;
    
    use Models\CreditCard as CreditCard;
    use DAO\ICreditCardDAO as ICreditCardDAO; 
    use DAO\Connection as Connection;


    class CreditCardDAO implements ICreditCardDAO{
        private $connection;
        
        function __construct(){}


        public function add($creditCard){
            $sql = "INSERT INTO creditcards (company, numberCard, propietary, expiration)
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
        
        
        public function search($numberCard,$company){

            try
            {
                $query = "SELECT * FROM creditcards WHERE numberCard= :numberCard AND company=:company";
                $parameters["numberCard"] =$numberCard ;
                $parameters["company"] =$company ;
    
                $this->connection = Connection::getInstance();
    
                $result = $this->connection->execute($query, $parameters);
                
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
    
            if(!empty($result)){
                return $this->mapCard($result[0]);
            }else{
                return null;
            }


        }

        public function getAll(){
            try
            {
                $cardList = array();
    
                $query = "SELECT * FROM creditcards";
    
                $this->connection = Connection::getInstance();
    
                $result = $this->connection->execute($query);
              
                if($result){
                    foreach($result as $value){
                        $mapping = $this->mapCard($value);  
                        array_push($cardList, $mapping);
                    }
                    return $cardList;
                }
                else{
                    return null;
                }
                
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }  
        }



        protected function mapCard($value){
        $card=new CreditCard();
        $card->setNumber($value["numberCard"]);
        $card->setCompany($value["company"]);
        $card->setPropietary($value["propietary"]);
        $card->setExpiration($value["expiration"]);

        return $card;




        }





    }?>