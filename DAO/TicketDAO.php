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
        

        public function add($ticket){
            $sql = "INSERT INTO tickets (idBill, idShow, seat, priceTicket, qrCode)
                            VALUES (:idBill, :idShow, :seat, :price, :qrCode)";
            
            $parameters['idBill']=$ticket->getBill()->getIdBill();
            $parameters['idShow']=$ticket->getShow()->getIdShow();
            $parameters['seat']=$ticket->getSeat();
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