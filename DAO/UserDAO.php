<?php
    namespace DAO;

    use DAO\IUserDAO as IUserDAO;
    use Models\User as User;
    use Models\Role as Role;
    use DAO\RoleDAO as RoleDAO;
    use DAO\Connection as Connection;

    class UserDAO implements IUserDAO{
        private $connection;
        private $tableName = "users";
        private $roleDAO;

        function __construct()
        {
            $this->roleDAO=new RoleDAO();
        }

        public function add($user){
            $sql = "INSERT INTO " .$this->tableName." (idRole, dni, name, surname, street, number, email, password)
                                      VALUES (:idRole, :dni, :name, :surname, :street, :number, :email, :password)";
            
           # $sql = "INSERT INTO ".$this->tableName." (state,name,street,number,phone,email) VALUES (:state,:name,:street,:number,:phone,:email)";

            $parameters['idRole']=$user->getRole()->getId();
            $parameters['dni']=$user->getDni();
            $parameters['name']=$user->getName();
            $parameters['surname']=$user->getSurname();
            $parameters['street']=$user->getStreet();
            $parameters['number']=$user->getNumber();
            $parameters['email']=$user->getEmail();
            $parameters['password']=$user->getPassword();


            try{
                $this->connection = Connection::getInstance();
                return $this->connection->executeNonQuery($sql, $parameters);
            }
            catch(\PDOException $ex){
                throw $ex;
            }
        }  

        public function getAll(){      
            try{
                $userList = array();
                $sql = "SELECT * FROM ".$this->tableName;
                $this->connection = Connection::getInstance();
                $resultSet = $this->connection->execute($sql);
                
                foreach ($resultSet as $row)
                {                
                    $user = new User();
                    $user->setRole($this->roleDAO->search($row["idRole"]));
                    $user->setDni($row["dni"]);
                    $user->setName($row["name"]);
                    $user->setSurname($row["surname"]);
                    $user->setStreet($row["street"]);
                    $user->setNumber($row["number"]);
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
                throw $ex;
            }
            if(!empty($resultSet)){
                return $this->map($resultSet);
            }
            else{
                return false;
            }
        }   


        public function update($user){
            try{
                $sql = "UPDATE users SET idRole=:idRole, dni=:dni,name=:name,surname=:surname,
                                street=:street,number=:number,password=:password WHERE idUser=:idUser";

                $parameters["idUser"]=$user->getIdUser();
                $parameters["idRole"]=$user->getRole()->getId();
                $parameters["dni"] = $user->getDni();
                $parameters["name"] = $user->getName();
                $parameters["surname"] = $user->getSurname();
                $parameters["street"]=$user->getStreet();
                $parameters["number"]=$user->getNumber();
                $parameters["password"] = $user->getPassword();

                $this->connection = Connection::getInstance();

                $rowCant = $this->connection->executeNonQuery($sql, $parameters);
                return $rowCant;
            }
            catch(\PDOException $ex){
                throw $ex;
            }

        }

        public function changeRole($userEmail){
            try{
                $sql = "SELECT * FROM users WHERE email= :email";
                $parameters["email"] = $userEmail;
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($sql, $parameters);
                if(!empty($result)){
                    $user = $this->map($result);
                    if($user->getRole()->getId() == 1){
                   
                        $sql = "UPDATE users set idRole = 0 WHERE email = :email";    
                    }
                    else{       
                        $sql = "UPDATE users set idRole = 1 WHERE email = :email";
                    }
                    $rowCant = $this->connection->executeNonQuery($sql, $parameters);
                }
                return $rowCant;
            }
            catch(\PDOException $ex){
                throw $ex;
            }
        }

        protected function map($value){
            $value = is_array($value) ? $value : [];
            
            $result = array_map(function ($p){
                $user = new User();
                $user->setIdUser($p["idUser"]);
                $user->setRole($this->roleDAO->search($p["idRole"]));
                $user->setDni($p["dni"]);
                $user->setName($p["name"]);
                $user->setSurname($p["surname"]);
                $user->setStreet($p["street"]);
                $user->setNumber($p["number"]);
                $user->setEmail($p["email"]);
                $user->setPassword($p["password"]);
                return $user;},$value);
 
            return count($result)>1 ? $result: $result["0"];
        }

    }             

?>