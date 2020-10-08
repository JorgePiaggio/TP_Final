<?php
    namespace DAO;

    use DAO\ICinemaDAO as ICinemaDAO;
    use Models\Cinema as Cinema;

    class CinemaDAO implements ICinemaDAO{
        private $cinemaList = array();


        public function Add(Cinema $cinema){
            $this->RetrieveData();
            array_push($this->cinemaList, $cinema);
            $this->SaveData();
        }

        public function GetAll(){
            $this->RetrieveData();
            return $this->cinemaList;
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

        public function Update(Cinema $cinema){
                $rta = false;
                $wanted = $this->Search($cinema->getId());
                if($wanted != null){ 
                    $this->Remove($wanted->getId());                    
                    $this->Add($cinema);
                    $rta = true;
                }
                return $rta; //Retorna falso si no existe el cine y true si lo modificó correctamente 
        }

        private function SaveData(){
            $arrayToEncode = array();
            foreach($this->cinemaList as $cinema){
                $valuesArray["id"] = $cinema->getId();
                $valuesArray["name"] = $cinema->getName();
                $valuesArray["adress"] = $cinema->getAddress();
                $valuesArray["phone"] = $cinema->getPhone();
                $valuesArray["email"] = $cinema->getEmail();
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
                    $cinema->setName($valuesArray["name"]);
                    $cinema->setAddress($valuesArray["adress"]);
                    $cinema->setPhone($valuesArray["phone"]);
                    $cinema->setEmail($valuesArray["email"]);
                    array_push($this->cinemaList, $cinema);
                }

            }
        }
    }             

?>