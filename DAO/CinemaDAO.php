<?php
    namespace DAO;

    use DAO\IDAO as IDAO;
    use Models\Cinema as Cinema;

    class CinemaDAO implements IDAO{
        private $cinemaList = array();


        public function Add($cinema){
            $this->RetrieveData();
            array_push($this->cinemaList, $cinema);
            $this->SaveData();
        }

        public function GetAll(){
            $this->RetrieveData();
            return $this->cinemaList;
        }

        public function GetAllActive(){
            $this->RetrieveData();
            $newList=array();
            foreach($this->cinemaList as $cinema){
                if($cinema->getState() == true){
                    array_push($newList, $cinema);
                }
            }
            return $newList;
        }

        public function ChangeState($idCinema){
            $wanted = $this->Search($idCinema);
            if($wanted != null){
                $this->RetrieveData();
                if($this->cinemaList[($wanted->getId())-1]->getState() == true){
                    $this->cinemaList[($wanted->getId())-1]->setState(false);
                }
                else{
                    $this->cinemaList[($wanted->getId())-1]->setState(true);
                }
                $this->SaveData();
            }
        }

        public function GetAllInactive(){
            $this->RetrieveData();
            $newList=array();
            foreach($this->cinemaList as $cinema){
                if($cinema->getState() != true){
                    array_push($newList, $cinema);
                }
            }
            return $newList;
        }

        /*
        public function Restore($idCinema){
            $wanted = $this->Search($idCinema);
            if($wanted != null){
                $this->RetrieveData();
                $this->cinemaList[($wanted->getId())-1]->setState(true);
                $this->SaveData();
            }
        }
        
        public function Remove($idCinema){
            $this->RetrieveData();
            $newList = array();
            foreach($this->cinemaList as $cinema){
                if($cinema->getId() != $idCinema){
                    array_push($newList, $cinema);
                }
            }
            $this->cinemaList = $newList;
		    $this->SaveData();
        }
        */
        public function Search($idCinema){
            $wanted = null;
            $this->RetrieveData();
            foreach($this->cinemaList as $cinema){
                if($cinema->getId() == $idCinema){
                    $wanted = $cinema;
                }
            }
            return $wanted;
        }

        public function Update($cinema){
                $this->RetrieveData();
                $this->cinemaList[($cinema->getId())-1]=$cinema;
                $this->SaveData();
        }

        public function lastId(){
            $ids = $this->getAll();
            $lastId = count($ids);

            return $lastId;
        }

        private function SaveData(){
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

        private function RetrieveData(){
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