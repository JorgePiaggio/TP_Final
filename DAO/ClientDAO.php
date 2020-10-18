<?php
    namespace DAO;

    use DAO\IClientDAO as IClientDAO;
    use Models\Client as Client;

    class ClientDAO implements IClientDAO{
        private $clientList = array();


        public function add($client){
            $this->retrieveData();
            $id=($this->lastId()+1);
            $client->setId($id);
            array_push($this->clientList, $client);
            $this->saveData();
        }

        public function getAll(){
            $this->retrieveData();
            return $this->clientList;
        }

        public function search($emailClient){
            $wanted = null;
            $this->retrieveData();
            foreach($this->clientList as $client){
                if($client->getEmail() == $emailClient){
                    $wanted = $client;
                }
            }
            return $wanted;
        }

        public function update($client){
                $this->retrieveData();
                $this->clientList[($client->getId())-1]=$client;
                $this->saveData();
        }
        
        public function lastId(){
            $ids = $this->getAll();
            $lastId = count($ids);

            return $lastId;
        }

        private function saveData(){
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

        private function retrieveData(){
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