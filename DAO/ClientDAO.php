<?php
    namespace DAO;

    use DAO\IDAO as IDAO;
    use Models\Client as Client;

    class ClientDAO implements IDAO{
        private $clientList = array();


        public function Add($client){
            $this->RetrieveData();
            $id=($this->lastId()+1);
            $client->setId($id);
            array_push($this->clientList, $client);
            $this->SaveData();
        }

        public function GetAll(){
            $this->RetrieveData();
            return $this->clientList;
        }

        public function Search($emailClient){
            $wanted = null;
            $this->RetrieveData();
            foreach($this->clientList as $client){
                if($client->getEmail() == $emailClient){
                    $wanted = $client;
                }
            }
            return $wanted;
        }

        public function Update($client){
                $this->RetrieveData();
                $this->clientList[$client->getId()-1]=$client;
                $this->SaveData();
        }

        
        public function lastId(){
            $ids = $this->getAll();
            $lastId = count($ids);

            return $lastId;
        }
        

        private function SaveData(){
            $arrayToEncode = array();
            foreach($this->clientList as $client){
                $valuesArray["id"] = $client->getId();
                $valuesArray["dni"] = $client->getDni();
                $valuesArray["name"] = $client->getName();
                $valuesArray["surname"] = $client->getSurname();
                $valuesArray["address"] = $client->getAddress();
                $valuesArray["phone"] = $client->getPhone();
                $valuesArray["email"] = $client->getEmail();
                $valuesArray["password"] = $client->getPassword();
                array_push($arrayToEncode, $valuesArray);
            }
            $jsonContent = json_encode($arrayToEncode , JSON_PRETTY_PRINT);
            file_put_contents('Data/clients.json', $jsonContent);
        }

        private function RetrieveData(){
            $this->clientList = array();
            
            if(file_exists('Data/clients.json')){

                $jsonContent = file_get_contents('Data/clients.json');

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray){
                    $client = new Client();
                    $client->setId($valuesArray["id"]);
                    $client->setDni($valuesArray["dni"]);
                    $client->setName($valuesArray["name"]);
                    $client->setSurName($valuesArray["surname"]);
                    $client->setAddress($valuesArray["address"]);
                    $client->setPhone($valuesArray["phone"]);
                    $client->setEmail($valuesArray["email"]);
                    $client->setPassword($valuesArray["password"]);
                    array_push($this->clientList, $client);
                }

            }
        }
    }             

?>