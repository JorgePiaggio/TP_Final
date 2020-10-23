<?php
    namespace DAO;

    use DAO\IUserDAO as IUserDAO;
    use Models\User as User;

    class UserDAO implements IUserDAO{
        private $connection;
        private $tableName = "users";


        public function add(){
            $sql = "INSERT INTO $this->tableName (idRole, dni, name, surname, street, number, phone, email, password)
                                VALUES (:idRole, :dni, :name, :surname, :street, :number, :phone, :email, :password");

            $parameters['idRole']=$user->getIdRole();
            $parameters['dni']=$user->getDni();
            $parameters['name']=$user->getName();
            $parameters['surname']=$user->getSurname();
            $parameters['street']=$user->getStreet();
            $parameters['number']=$user->getNumber();
            $parameters['phone']=$user->getPhone();
            $parameters['email']=$user->getEmail();
            $parameters['password']=$user->getPassword();

            try{
                $this->connection = Connection::getInstance();
                return $this->connection::executeNonQuery($sql, $parameters);
            }
            catch(\PDOException $ex){
                throw $ex;
            }
            

        public function getAll(){      
            try{
                $userList = array();
                $sql = "SELECT * FROM ".$this->tableName;
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->execute($sql);
                
                foreach ($resultSet as $row)
                {                
                    $user = new User();
                    $user->setIdRole($row["idRole"]);
                    $user->setDni($row["dni"]);
                    $user->setName($row["name"]);
                    $user->setSurname($row["surname"]);
                    $user->setStreet($row["street"]);
                    $user->setNumber($row["number"]);
                    $user->setPhone($row["phone"]);
                    $user->setEmail($row["email"]);
                    $user->setPassword($row["password"]);

                    array_push($userList, $user);
                }
                return $userList;
            }
            catch(\PDOException $ex){
                throw $ex;
            }
        }         


        public function search($emailUser){
            $sql = "SELECT * FROM $this->tableName WHERE email = :email";

            $parameters['email'] = $emailUser;

            try{
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql, $parameters);
            }
            catch(\PDOException $ex){
                throw $ex;{
            }

            if(!empty($resultSet)){
                return $this->map($resultSet);
            }
            else{
                return false;
            }
        }   

        public function update($user){
            $sql = "INSERT INTO ("
        }







        public function add($user){
            $this->retrieveData();
            $id=($this->lastId()+1);
            $user->setIdUser($id);
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
                $this->userList[($user->getIdUser())-1]=$user;
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
                $valuesArray["street"] = $user->getStreet();
                $valuesArray["number"] = $user->getNumber();
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
                    $user->setIdUser($valuesArray["id"]);
                    $user->setDni($valuesArray["dni"]);
                    $user->setName($valuesArray["name"]);
                    $user->setSurName($valuesArray["surname"]);
                    $user->setStreet($valuesArray["street"]);
                    $user->setNumber($valuesArray["number"]);
                    $user->setPhone($valuesArray["phone"]);
                    $user->setEmail($valuesArray["email"]);
                    $user->setPassword($valuesArray["password"]);
                    array_push($this->userList, $user);
                }

            }
        }
    }             

?>