<?php
    namespace DAO;

    use DAO\ICinemaDAO as ICinemaDAO;
    use Models\Cinema as Cinema;

    class CinemaDAO_JSON implements ICinemaDAO{
        private $cinemaList = array();


        public function add($cinema){
            if($this->checkValue($cinema->getName())){
            $this->retrieveData();
            $cinema->setIdCinema($this->lastId()+1);
            array_push($this->cinemaList, $cinema);
            $this->saveData();
            }
            
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
                if($this->cinemaList[($wanted->getIdCinema())-1]->getState() == true){
                    $this->cinemaList[($wanted->getIdCinema())-1]->setState(false);
                }
                else{
                    $this->cinemaList[($wanted->getIdCinema())-1]->setState(true);
                }
                $this->saveData();
            }
        }

        
        public function search($idCinema){
            $wanted = null;
            $this->retrieveData();
            foreach($this->cinemaList as $cinema){
                if($cinema->getIdCinema() == $idCinema){
                    $wanted = $cinema;
                }
            }
            return $wanted;
        }

        public function update($cinema){
                $this->retrieveData();
                $this->cinemaList[($cinema->getIdCinema())-1]=$cinema;
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
                $valuesArray["idCinema"] = $cinema->getIdCinema();
                $valuesArray["state"] = $cinema->getState();
                $valuesArray["name"] = $cinema->getName();
                $valuesArray["street"] = $cinema->getStreet();
                $valuesArray["number"] = $cinema->getNumber();
                $valuesArray["city"] = $cinema->getCity();
                $valuesArray["country"] = $cinema->getCountry();
                $valuesArray["phone"] = $cinema->getPhone();
                $valuesArray["email"] = $cinema->getEmail();
                $valuesArray["poster"] = $cinema->getPoster();
        
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
                    $cinema->setIdCinema($valuesArray["idCinema"]);
                    $cinema->setState($valuesArray["state"]);
                    $cinema->setName($valuesArray["name"]);
                    $cinema->setStreet($valuesArray["street"]);
                    $cinema->setNumber($valuesArray["number"]);
                    $cinema->setCity($valuesArray["city"]);
                    $cinema->setCountry($valuesArray["country"]);
                    $cinema->setPhone($valuesArray["phone"]);
                    $cinema->setEmail($valuesArray["email"]);
                    $cinema->setPoster($valuesArray["poster"]);
                    $cinema->setBillboard(null);
                    array_push($this->cinemaList, $cinema);
                }

            }
        }

        private function checkValue($value){
            if($value==""){
                return false;
            }

            return true;
        }



        //Métodos vacíos de la cartelera de un cine
        public function stateMovie($idCinema,$idMovie,$state){}
        public function searchMovie($idCinema,$idMovie){return false;}
        public function addMovie($idCinema,$idMovie){}
        public function getBillboard($idCinema){}
    }             

?>