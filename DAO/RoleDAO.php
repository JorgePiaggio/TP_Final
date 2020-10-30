<?php
    namespace DAO;

    use DAO\IRoleDAO as IRoleDAO;
    use Models\Role as Role;
    use DAO\Connection as Connection;

    class RoleDAO implements IRoleDAO{
        private $connection;
        private $tableName="roles";


        public function add($role){
            $sql = "INSERT INTO ".$this->tableName." (idRole,description) VALUES (:idRole,:description)";

            $parameters['idRole']=$role->getId();
            $parameters['description']=$role->getDescription();
            

            try{

            $this->connection=Connection::getInstance();

            return $this->connection->executeNonQuery($sql,$parameters);

            }catch(\PDOException $ex){
                throw $ex;
            }

            
        }

        public function getAll(){
            try
            {
                $roleList = array();

                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::getInstance();

                $resultSet = $this->connection->execute($query);
                
                foreach ($resultSet as $row)
                {                
                    $role = new Role();
                    $role->setId($row["idRole"]);
                    $role->setDescription($row["description"]);

                    array_push($roleList, $role);
                }

                return $roleList;
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
        }
        

        
        public function search($idRole){
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE idRole= :idRole";
                $parameters["idRole"]=$idRole;
                $this->connection = Connection::getInstance();

                $results = $this->connection->execute($query,$parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            if(!empty($results)){
                return $this->map($results);
            }else{
                return null;
            }
        }

        public function update($role){
            try
            {
                $query = "UPDATE ".$this->tableName." set description=:description WHERE idRole=:idRole";

                $this->connection = Connection::getInstance();
                $parameters["idRole"]=$role->getId();
                $parameters["description"]=$role->getDescription();
     

                $rowCant=$this->connection->executeNonQuery($query,$parameters);
                return $rowCant;
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
        }

    
       protected function map($value){
           $value=is_array($value) ? $value: array();
           
           $result= array_map(function ($p){
                $role=new Role();
                $role->setId($p["idRole"]);
                $role->setDescription($p["description"]);
              

               return $role;
           },$value);

           return count($result)>1 ? $result: $result["0"];
       }

    }             

?>