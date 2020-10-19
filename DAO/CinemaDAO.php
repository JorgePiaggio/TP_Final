<?php
    namespace DAO;

    use DAO\ICinemaDAO as ICinemaDAO;
    use Models\Cinema as Cinema;

    class CinemaDAO implements ICinemaDAO{
        private $cinemaList = array();


        public function add($cinema){
            $this->retrieveData();
            array_push($this->cinemaList, $cinema);
            $this->saveData();
        }

        public function getAll(){
            $this->retrieveData();
            return $this->cinemaList;
        }

        public function getAllActive(){
            $this->retrieveData();
            $newList=array();
            foreach($this->cinemaList as $cinema){
                if($cinema->getState() == true){
                    array_push($newList, $cinema);
                }
            }
            return $newList;
        }

        public function getAllInactive(){
            $this->retrieveData();
            $newList=array();
            foreach($this->cinemaList as $cinema){
                if($cinema->getState() != true){
                    array_push($newList, $cinema);
                }
            }
            return $newList;
        }

        public function changeState($idCinema){
            $wanted = $this->search($idCinema);
            if($wanted != null){
                $this->retrieveData();
                if($this->cinemaList[($wanted->getId())-1]->getState() == true){
                    $this->cinemaList[($wanted->getId())-1]->setState(false);
                }
                else{
                    $this->cinemaList[($wanted->getId())-1]->setState(true);
                }
                $this->saveData();
            }
        }

        /*
        public function restore($idCinema){
            $wanted = $this->search($idCinema);
            if($wanted != null){
                $this->retrieveData();
                $this->cinemaList[($wanted->getId())-1]->setState(true);
                $this->saveData();
            }
        }
        
        public function remove($idCinema){
            $this->retrieveData();
            $newList = array();
            foreach($this->cinemaList as $cinema){
                if($cinema->getId() != $idCinema){
                    array_push($newList, $cinema);
                }
            }
            $this->cinemaList = $newList;
		    $this->saveData();
        }
        */
        
        public function search($idCinema){
            $wanted = null;
            $this->retrieveData();
            foreach($this->cinemaList as $cinema){
                if($cinema->getId() == $idCinema){
                    $wanted = $cinema;
                }
            }
            return $wanted;
        }

        public function update($cinema){
                $this->retrieveData();
                $this->cinemaList[($cinema->getId())-1]=$cinema;
                $this->saveData();
        }

        public function lastId(){
            $ids = $this->getAll();
            $lastId = count($ids);

            return $lastId;
        }

        private function saveData(){
            $arrayToEncode = array();
            foreach($this->cinemaList as $cinema){
                $valuesArray["id"] = $cinema->getId();
                $valuesArray["state"] = $cinema->getState();
                $valuesArray["name"] = $cinema->getName();
                $valuesArray["address"] = $cinema->getAddress();
                $valuesArray["phone"] = $cinema->getPhone();
                $valuesArray["email"] = $cinema->getEmail();
                $valuesArray["ticketPrice"] = $cinema->getPrice();
                array_push($arrayToEncode, $valuesArray);
            }
            $jsonContent = json_encode($arrayToEncode , JSON_PRETTY_PRINT);
            file_put_contents('Data/cinemas.json', $jsonContent);
        }

        private function retrieveData(){
            $this->cinemaList = array();
            
            if(file_exists('Data/cinemas.json')){

                $jsonContent = file_get_contents('Data/cinemas.json');

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray){
                    $cinema = new Cinema();
                    $cinema->setId($valuesArray["id"]);
                    $cinema->setState($valuesArray["state"]);
                    $cinema->setName($valuesArray["name"]);
                    $cinema->setAddress($valuesArray["address"]);
                    $cinema->setPhone($valuesArray["phone"]);
                    $cinema->setEmail($valuesArray["email"]);
                    $cinema->setPrice($valuesArray["ticketPrice"]);
                    array_push($this->cinemaList, $cinema);
                }

            }
        }
    }             

?>