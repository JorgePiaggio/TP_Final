<?php
    namespace DAO;
    
    use DAO\ITicketDAO as ITicketDAO;
    use Models\Show as Show;
    use Models\Bill as Bill;
    use Models\Seat as Seat;
    use Models\Room as Room;
    use Models\Cinema as Cinema;
    use Models\Movie as Movie;
    use Models\Ticket as Ticket;
    use Models\User as User;
    use DAO\Connection as Connection;
  


    class TicketDAO implements ITicketDAO{
        private $connection;
        

        function __construct(){}


        public function add($ticket){
            $sql = "INSERT INTO tickets (idBill, idShow, seat, priceTicket, qrCode)
                            VALUES (:idBill, :idShow, :seat, :price, :qrCode)";
            
            $parameters['idBill']=$ticket->getBill()->getIdBill();
            $parameters['idShow']=$ticket->getShow()->getIdShow();
            $parameters['seat']=$ticket->getSeat()->getIdSeat();
            $parameters['price']=$ticket->getPrice(); 
            $parameters['qrCode']=$ticket->getQrCode(); 
    
            try{
                $this->connection = Connection::getInstance();
                return $this->connection->executeNonQuery($sql, $parameters);
            }
            catch(\PDOException $ex){
                throw $ex;
            }
        }  


        public function getAll(){

            try
            {
                $ticketList = array();
    
                $query = "SELECT * FROM tickets t
                INNER JOIN bills b ON t.idBill=b.idBill
                INNER JOIN users u ON u.idUser=b.idUser
                INNER JOIN seats se ON t.seat=se.idSeat
                INNER JOIN shows s  ON t.idShow=s.idShow
                INNER JOIN movies m ON s.idMovie = m.idMovie 
                INNER JOIN rooms r ON s.idRoom = r.idRoom 
                INNER JOIN cinemas c ON r.idCinema = c.idCinema";
    
                $this->connection = Connection::getInstance();
    
                $result = $this->connection->execute($query);
              
                if($result){
                    foreach($result as $value){
                        $mapping = $this->mapTicket($value);  
                        array_push($ticketList, $mapping);
                    }
                    return $ticketList;
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

        public function getbyShow($idShow){

            try
            {
                $ticketList = array();
    
                $query = "SELECT * FROM tickets t
                INNER JOIN bills b ON t.idBill=b.idBill
                INNER JOIN users u ON u.idUser=b.idUser
                INNER JOIN seats se ON t.seat=se.idSeat
                INNER JOIN shows s  ON t.idShow=s.idShow
                INNER JOIN movies m ON s.idMovie = m.idMovie 
                INNER JOIN rooms r ON s.idRoom = r.idRoom 
                INNER JOIN cinemas c ON r.idCinema = c.idCinema
                WHERE t.idShow=:idShow";

                $this->connection = Connection::getInstance();
                $parameters["idShow"]=$idShow;
    
                $result = $this->connection->execute($query,$parameters);
              
                if($result){
                    foreach($result as $value){
                        $mapping = $this->mapTicket($value);  
                        array_push($ticketList, $mapping);
                    }
                    return $ticketList;
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

        public function search($idTicket){
            try
            {
                $query = "SELECT * FROM tickets WHERE idTicket= :idTicket";
                $parameters["idTicket"] = $idTicket;
    
                $this->connection = Connection::getInstance();
    
                $result = $this->connection->execute($query, $parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
    
            if(!empty($result)){
                return $this->mapTicket($result[0]);
            }else{
                return null;
            }
        }

        public function remove($idTicket){
            try{
            $query="DELETE FROM tickets WHERE idTicket=:idTicket";
            $this->connection = Connection::getInstance();
            $parameters['idTicket']=$idTicket;
            $rowCant=$this->connection->executeNonQuery($query,$parameters);
            return $rowCant;
            }   
            catch(\PDOException $ex)
            {
            throw $ex;
            } 
        }


        
        public function update($ticket){
            try
            {   
                $query = "UPDATE tickets set idBill=:idBill , seat=:seat, idShow=:idShow , priceTicket=:priceTicket , qrCode=:qrCode WHERE idTicket=:idTicket";

                $this->connection = Connection::getInstance();
                $parameters['idShow']=$ticket->getShow()->getIdShow();

                $parameters['seat']=$ticket->getSeat();
                $parameters['idBill']=$ticket->getBill()->getIdBill();
                $parameters['priceTicket']=$ticket->getPrice();
                $parameters['qrCode']=$ticket->getQrCode();
                $parameters['idTicket']=$ticket->getIdTicket();

                

                $rowCant=$this->connection->executeNonQuery($query,$parameters);
                return $rowCant;
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
        }


        /* Retorna el total de tickets vendidos para una fecha en un cine */
        public function ticketsByCinemaByDate($idCinema, $dateTime){
            try
            {   
                $query = "SELECT sum(b.tickets) FROM bills AS b
                            JOIN tickets AS t
                            ON b.idBill = t.idBill
                            JOIN shows AS s
                            ON t.idShow = s.idShow
                            JOIN rooms AS r
                            ON t.idRoom = r.idRoom 
                            HAVING DATEDIFF(s.dateTime, :dateTime) = 0 AND r.idCinema = :idCinema";
                
                $parameters["idCinema"] = $idCinema;
                $parameters["dateTime"] = $dateTime;
                
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query, $parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            return $result;        
        }    
        
        
        /* Retorna el total de tickets vendidos para el mes actual en un cine*/
        public function ticketsByCinemaByThisMonth($idCinema){
            try
            {   
                $query = "SELECT sum(b.tickets) FROM bills AS b
                            JOIN tickets AS t
                            ON b.idBill = t.idBill
                            JOIN shows AS s
                            ON t.idShow = s.idShow
                            JOIN rooms AS r
                            ON t.idRoom = r.idRoom
                            HAVING DATEPART(month, s.dateTime) = DATEPART(month, GETDATE()) AND DATEPART(year, s.dateTime) =  DATEPART(year, GETDATE()) AND r.idCinema = :idCinema";
                
                $parameters["idCinema"] = $idCinema;

                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query, $parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            return $result;
        }


        /* Retorna el total de tickets vendidos para un año en un cine*/
        public function ticketsByCinemaByYear($idCinema, $year){
            try
            {   
                $query = "SELECT sum(b.tickets) FROM bills AS b
                            JOIN tickets AS t
                            ON b.idBill = t.idBill
                            JOIN shows AS s
                            ON t.idShow = s.idShow
                            JOIN rooms AS r
                            ON t.idRoom = r.idRoom
                            HAVING DATEPART(year, s.dateTime) = :year AND r.idCinema = :idCinema";
                
                $parameters["idCinema"] = $idCinema;
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


        /* Retorna el total de tickets vendidos para este año en un cine */
        public function ticketsByCinemayThisYear($idCinema){
            try
            {   
                $query = "SELECT sum(b.tickets) FROM bills AS b
                            JOIN tickets AS t
                            ON b.idBill = t.idBil.
                            JOIN shows AS s
                            ON t.idShow = s.idShow
                            JOIN rooms AS r
                            ON t.idRoom = r.idRoom
                            HAVING DATEPART(year, s.dateTime) = DATEPART(year, GETDATE()) AND r.idCinema = :idCinema";
                
                $parameters["idCinema"] = $idCinema;

                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query, $parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            return $result;        
        }


        /* Retorna el total de tickets vendidos para una función */
        public function ticketsByshow($idShow){
            try
            {   
                $query = "SELECT sum(b.tickets) FROM bills AS b
                            JOIN tickets AS t
                            ON b.idBill = t.idBil.
                            WHERE t.idShow = :idShow";

                $parameters["idShow"] = $idShow;
                
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query, $parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            return $result;        
        }


        
        /* Retorna el total de tickets vendidos para una película en un cine */
        public function ticketsByCinemaByMovie($idCinema, $idMovie){
            try
            {   
                $query = "SELECT sum(b.tickets) FROM bills AS b
                            JOIN tickets AS t
                            ON b.idBill = t.idBil.
                            JOIN shows AS s
                            ON t.idShow = s.idShow
                            JOIN rooms AS r
                            ON t.idRoom = r.idRoom
                            WHERE s.idMovie = :idMovie AND r.idCinema = :idCinema";

                $parameters["idCinema"] = $idCinema;
                $parameters["idMovie"] = $idMovie;
                
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query, $parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            return $result;        
        }


            
        /* Retorna el total de tickets vendidos para un pelicula para un turno en un cine */
        public function ticketsByCinemaByMovieByShift($idCinema, $idMovie, $shift){
            try
            {   
                $query = "SELECT sum(b.tickets) FROM bills AS b
                            JOIN tickets AS t
                            ON b.idBill = t.idBill
                            JOIN shows AS s
                            ON t.idShow = s.idShow
                            JOIN rooms AS r
                            ON t.idRoom = r.idRoom
                            WHERE s.idMovie = :idMovie  AND r.idCinema = :idCinema AND s.shift = :shift";

                $parameters["idCinema"] = $idCinema;
                $parameters["idMovie"] = $idMovie;
                $parameters["shift"] = $shift;
                
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query, $parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            return $result;        
        }


        
        /* Retorna el total de dinero recaudado en una fecha en un cine*/
        public function cashByCinemaByDate($idCinema, $date){
            try
            {   
                $query = "SELECT sum(ccp.total) FROM bills AS b
                            JOIN tickets AS t
                            ON b.idBill = t.idBill
                            JOIN creditcardpayments AS ccp
                            ON b.codePayment = ccp.idCreditCardPayment
                            JOIN shows AS s
                            ON t.idShow = s.idShow
                            JOIN rooms AS r
                            ON s.idRoom = r.idRoom
                            WHERE DATEDIFF(s.dateTime, :date) = 0 AND r.idCinema = :idCinema";
                
                $parameters["idCinema"] = $idCinema;
                $parameters["date"] = $date;
                
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query, $parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            if($result[0][0]){
                return $result[0][0];                
            }
            else{
                return 0;
            }


                    
        }        


        /* Retorna el total de dinero recaudado en el mes actual en un cine*/
        public function cashByCinemaByMonth($idCinema, $month){
            try
            {   
                $query = "SELECT sum(ccp.total) FROM bills AS b
                            JOIN tickets AS t
                            ON b.idBill = t.idBill
                            JOIN creditcardpayments AS ccp
                            ON b.codePayment = ccp.idCreditCardPayment
                            JOIN shows AS s
                            ON t.idShow = s.idShow
                            JOIN rooms AS r
                            ON s.idRoom = r.idRoom 
                            WHERE MONTH(s.dateTime) = :month AND YEAR(s.dateTime) =  YEAR(NOW()) AND r.idCinema = :idCinema";

                $parameters["idCinema"] = $idCinema;
                $parameters["month"] = $month;

                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query, $parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            if($result[0][0]){
                return $result[0][0];                
            }
            else{
                return 0;
            }
        }


        /* Retorna el total de dinero recaudado en un año en un cine*/
        public function cashByCinemaByYear($idCinema, $year){
            try
            {   
                $query = "SELECT sum(ccp.total) FROM bills AS b
                            JOIN tickets AS t
                            ON b.idBill = t.idBill
                            JOIN creditcardpayments AS ccp
                            ON b.codePayment = ccp.idCreditCardPayment
                            JOIN shows AS s
                            ON t.idShow = s.idShow
                            JOIN rooms AS r
                            ON s.idRoom = r.idRoom 
                            WHERE YEAR(s.dateTime) = :year AND r.idCinema = :idCinema";

                $parameters["idCinema"] = $idCinema;
                $parameters["year"] = $year;
                
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query, $parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            if($result[0][0]){
                return $result[0][0];   
            }
            else{
                return 0;
            }
        }


        /* Retorna el total de dinero recaudado este año en un cine*/
        public function cashByCinemaByThisYear($idCinema){
            try
            {   
                $query = "SELECT sum(totalPrice) FROM bills
                            JOIN tickets AS t
                            ON b.idBill = t.idBill
                            JOIN shows AS s
                            ON t.idShow = s.idShow
                            JOIN rooms AS r
                            ON t.idRoom = r.idRoom 
                            HAVING DATEPART(year, date) = DATEPART(year, GETDATE()) AND r.idCinema = :idCinema";
                
                $parameters["idCinema"] = $idCinema;

                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($query, $parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            return $result;
        }


        protected function mapTicket($value){
            $ticket=new Ticket();
            $ticket->setIdTicket($value["idTicket"]);
            $ticket->setBill($this->mapBill($value));
            $ticket->setSeat($this->mapSeat($value));
            $ticket->setShow($this->mapShow($value));
            $ticket->setPrice($value["priceTicket"]);

            return $ticket;

        }


        protected function mapShow($value){
        
            $show=new Show();
            $show->setIdShow($value["idShow"]);
            $show->setRoom($this->mapRoom($value));
            $show->setMovie($this->mapMovie($value));
            $show->setDateTime($value["dateTime"]);
            $show->setShift($value["shift"]);
            $show->setRemainingTickets($value["remainingTickets"]);
            
            return $show;
        
        }

        protected function mapRoom($value){
            
                $room=new Room();
                $room->setIdRoom($value["idRoom"]);
                $room->setType($value["type"]);
                $room->setCapacity($value["capacity"]);
                $room->setColumns($value["roomcolumns"]);
                $room->setRows($value["roomrows"]);
                $room->setPrice($value["price"]);
                $room->setName($value["name_room"]);
                $room->setCinema($this->mapCinema($value));

                return $room;

            
        }

        protected function mapCinema($value){
            
            $cinema=new Cinema();
            $cinema->setIdCinema($value["idCinema"]);
            $cinema->setState($value["state"]);
            $cinema->setName($value["name"]);
            $cinema->setStreet($value["street"]);
            $cinema->setNumber($value["number"]);
            $cinema->setEmail($value["email"]);
            $cinema->setPhone($value["phone"]);
            $cinema->setPoster($value["poster"]);   

            return $cinema;
        }

        protected function mapMovie($p){
        
            $movie=new Movie();
            $movie->setTmdbId($p["idMovie"]);
            $movie->setTitle($p["title"]);
            $movie->setOriginalTitle($p["originalTitle"]);
            $movie->setVoteAverage($p["voteAverage"]);
            $movie->setDescription($p["overview"]);
            $movie->setReleaseDate($p["releaseDate"]);
            $movie->setPopularity($p["popularity"]);
            $movie->setVideoPath($p["videoPath"]);
            $movie->setAdult($p["adult"]);
            $movie->setPoster($p["posterPath"]);
            $movie->setBackdropPath($p["backDropPath"]);
            $movie->setOriginalLanguage($p["originalLanguage"]);
            $movie->setRuntime($p["runtime"]);
            $movie->setHomepage($p["homepage"]);
            $movie->setDirector($p["director"]);
            $movie->setReview($p["review"]);
            $movie->setState($p["state"]);

            return $movie;
        }

        protected function mapSeat($value){
            $seat=new Seat();
            $seat->setIdSeat($value["idSeat"]);
            $seat->setRow($value["rowSeat"]);
            $seat->setNumber($value["numberSeat"]);
            $seat->setState($value["stateSeat"]);

            return $seat;
        }

        protected function mapBill($value){
            $bill= new Bill();
            $bill->setIdBill($value["idBill"]);
            $bill->setUser($this->mapUser($value));
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

            

    }