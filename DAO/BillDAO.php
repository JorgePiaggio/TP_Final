<?php
    namespace DAO;

    use DAO\IBillDAO as IBillDAO;
    use Models\Bill as Bill;
    use Models\User as User;
    use Models\CreditCardPayment as CreditCardPayment;
   

    class BillDAO implements IBillDAO{
        private $connection;


        function __construct(){}

        
        /* Agrega una factura a la BD */
        public function add($bill){
            $query = "INSERT INTO bills (idBill, idUser, codePayment, tickets, date, totalPrice, discount)
                        VALUES (:idBill, :idUser, :codePayment, :tickets, :date, :totalPrice, :discount)";

            $parameters['idBill'] = $bill->getIdBill();
            $parameters['idUser'] = $bill->getUser()->getIdUser();
            $parameters['codePayment'] = $bill->getCreditCardPayment()->getCode();
            $parameters['tickets'] = $bill->getTickets();
            $parameters['date'] = $bill->getDate();
            $parameters['totalPrice'] = $bill->getTotalPrice();
            $parameters['discount'] = $bill->getDiscount();
    
            try
            {
                $this->connection = Connection::getInstance();
                return $this->connection->executeNonQuery($query, $parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
        }

        public function getAll(){
            try
            {
                $billList = array();

                $query = "SELECT * FROM bills as b INNER JOIN users as u on b.idUser=u.idUser";

                $this->connection = Connection::getInstance();

                $resultSet = $this->connection->execute($query);

                foreach($resultSet as $row){
                    array_push($billList,$this->mapBill($row));

                }
                
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            if($resultSet){
                return $billList;
            }else{
                return null;
            }
        }
        
        




        /* Retorna una factura buscada por id o null si no existe*/ /*
        public function search($idBill){
            try
            {   
                $query = "SELECT * FROM bills as b 
                            INNER JOIN users as u 
                            on b.idUser=u.idUser
                            INNER JOIN creditCardPayments as c 
                            on c.idCreditCardPayment = b.codePayment
                            WHERE idBill = :idBill";
                
                $parameters["idBill"] = $idBill;
                
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query, $parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            if(!empty($result)){
                return $this->mapBill($result[0]);
            }else{
                return null;
            } 
        } */

        /* Retorna una factura buscada por codigo de pago o null si no existe*/
        public function searchByCodePayment($codePayment){
            try
            {   
                $query = "SELECT * FROM bills as b 
                        INNER JOIN users as u 
                        on b.idUser=u.idUser 
                        INNER JOIN creditCardPayments as c 
                        on c.idCreditCardPayment = b.codePayment
                        WHERE codePayment = :codePayment";
                
                $parameters["codePayment"] = $codePayment;
                
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query, $parameters);
                
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            if(!empty($result)){
                return $this->mapBill($result[0]);
            }else{
                return null;
            }
        }


        
        /* Retorna el total de facturas vendidas en una fecha */ /*
        public function billsByDate($date){
            try
            {   
                $query = "SELECT count(idBill) FROM bills 
                            HAVING DATEDIFF(date, :date) = 0";
                
                $parameters["date"] = $date;
                
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query, $parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            return $result;        
        }        */


        /* Retorna el total de facturas vendidas en el mes actual */ /*
        public function billsByThisMonth(){
            try
            {   
                $query = "SELECT count(idBill) FROM bills 
                            HAVING DATEPART(month, date) = DATEPART(month, GETDATE()) AND DATEPART(year, date) =  DATEPART(year, GETDATE())";
                
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            return $result;
        }*/


        /* Retorna el total de facturas vendidas en un año */ /*
        public function billsByYear($year){
            try
            {   
                $query = "SELECT count(idBill) FROM bills
                            HAVING DATEPART(year, date) = :year";
                
                $parameters["year"] = $year;
                
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query, $parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            return $result;
        } */


        /* Retorna el total de facturas vendidas este año */ /*
        public function billsByThisYear(){
            try
            {   
                $query = "SELECT count(idBill) FROM bills
                            HAVING DATEPART(year, date) = DATEPART(year, GETDATE())";
                
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            return $result;
        } */

        

        protected function mapBill($value){
            $bill= new Bill();
            $bill->setIdBill($value["idBill"]);
            $bill->setUser($this->mapUser($value));
            $bill->setCreditCardPayment($this->mapPayment($value));
            $bill->setTickets($value["tickets"]);
            $bill->setDate($value["date"]);
            $bill->setTotalPrice($value["totalPrice"]);
            $bill->setDiscount($value["discount"]);
            
            return $bill;

        }

        protected function mapUser($p){
        
            
    
                $user = new User();
                $user->setIdUser($p["idUser"]);
                $user->setDni($p["dni"]);
                $user->setName($p["name"]);
                $user->setSurname($p["surname"]);
                $user->setStreet($p["street"]);
                $user->setNumber($p["number"]);
                $user->setEmail($p["email"]);
                $user->setPassword($p["password"]);
                return $user;
 
        }

        protected function mapPayment($value){
            
        $payment= new CreditCardPayment();
        $payment->setCode($value['idCreditCardPayment']);
        $payment->setDate($value['datePayment']);
        $payment->setTotal($value['total']);

        return $payment;
    
        }






    }
?>

