<?php
    namespace DAO;

    use DAO\IUserDAO as IUserDAO;
    use Models\User as User;

    class userDAO implements IuserDAO{
        private $userList = array();


        public function add($user){
            $this->retrieveData();
            $id=($this->lastId()+1);
            $user->setId($id);
            array_push($this->userList, $user);
            $this->saveData();
        }

        public function getAll(){
            $this->retrieveData();
            return $this->userList;
        }

        public function search($emailUser){
            $wanted = null;
            $this->retrieveData();
            foreach($this->userList as $user){
                if($user->getEmail() == $emailUser){
                    $wanted = $user;
                }
            }
            return $wanted;
        }

        public function update($user){
                $this->retrieveData();
                $this->userList[($user->getId())-1]=$user;
                $this->saveData();
        }
        
        public function lastId(){
            $ids = $this->getAll();
            $lastId = count($ids);

            return $lastId;
        }

        private function saveData(){
            $arrayToEncode = array();
            foreach($this->userList as $user){
                $valuesArray["id"] = $user->getId();
                $valuesArray["dni"] = $user->getDni();
                $valuesArray["name"] = $user->getName();
                $valuesArray["surname"] = $user->getSurname();
                $valuesArray["address"] = $user->getAddress();
                $valuesArray["phone"] = $user->getPhone();
                $valuesArray["email"] = $user->getEmail();
                $valuesArray["password"] = $user->getPassword();
                array_push($arrayToEncode, $valuesArray);
            }
            $jsonContent = json_encode($arrayToEncode , JSON_PRETTY_PRINT);
            file_put_contents('Data/users.json', $jsonContent);
        }

        private function retrieveData(){
            $this->userList = array();
            
            if(file_exists('Data/users.json')){

                $jsonContent = file_get_contents('Data/users.json');

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray){
                    $user = new user();
                    $user->setId($valuesArray["id"]);
                    $user->setDni($valuesArray["dni"]);
                    $user->setName($valuesArray["name"]);
                    $user->setSurName($valuesArray["surname"]);
                    $user->setAddress($valuesArray["address"]);
                    $user->setPhone($valuesArray["phone"]);
                    $user->setEmail($valuesArray["email"]);
                    $user->setPassword($valuesArray["password"]);
                    array_push($this->userList, $user);
                }

            }
        }
    }             

?>