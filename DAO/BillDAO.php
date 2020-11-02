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


        /* Retorna una factura buscada por id o null si no existe*/
        public function search($idBill){
            try
            {   
                $query = "SELECT * FROM bills
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
        }



        /* Retorna el total de facturas vendidas en una fecha */
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
        }        


        /* Retorna el total de facturas vendidas en el mes actual */
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
        }


        /* Retorna el total de facturas vendidas en un año */
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
        }


        /* Retorna el total de facturas vendidas este año */
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
        }

        
        /* Retorna el total de dinero recaudado en una fecha */
        public function cashByDate($date){
            try
            {   
                $query = "SELECT sum(totalPrice) FROM bills 
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
        }        


        /* Retorna el total de dinero recaudado en el mes actual */
        public function cashByMonth(){
            try
            {   
                $query = "SELECT sum(totalPrice) FROM bills 
                            HAVING DATEPART(month, date) = DATEPART(month, GETDATE()) AND DATEPART(year, date) =  DATEPART(year, GETDATE())";
                
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            return $result;
        }


        /* Retorna el total de dinero recaudado en un año */
        public function cashByYear($year){
            try
            {   
                $query = "SELECT sum(totalPrice) FROM bills
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
        }


        /* Retorna el total de dinero recaudado este año */
        public function cashByThisYear(){
            try
            {   
                $query = "SELECT sum(totalPrice) FROM bills
                            HAVING DATEPART(year, date) = DATEPART(year, GETDATE())";
                
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            return $result;
        }


        protected function mapBill($value){
            $bill = new Bill();
            $bill->setIdBill($value["idBill"]);
            $bill->setTickets($value["tickets"]);
            $bill->setDate($value["date"]);
            $bill->setTotalPrice($value["totalPrice"]);
            $bill->setDiscount($value["discount"]);
            
            return $bill;
        }


    }
?>

