<?php
    namespace DAO;

    use DAO\IGenreDAO as IGenreDAO;
    use Models\Genre as Genre;
    use DAO\Connection as Connection;

    class GenreDAO implements IGenreDAO{
        private $connection;
        private $tableName = "genres";


        public function add($genre){
            $sql = "INSERT INTO ".$this->tableName." (id, name) VALUES (:id, :name)";
            $parameters['id']=$genre->getId();
            $parameters['name']=$genre->getName();

            try{
                $this->connection= Connection::getInstance();
                return $this->connection->executeNonQuery($sql,$parameters);
            }catch(\PDOException $ex){
                throw $ex;
            }
        }


        public function getAll(){

            $genreList= array();
            $query = "SELECT * FROM ".$this->tableName;
            $this->connection = Connection::getInstance();

            $result= $this->connection->execute($query);

            foreach($result as $row){
                $genre= $this->map($row);
                
                array_push($genreList,$genre);
            }

            return $genreList;
        }


          /* actualizar generos en BDD */
        public function updateList($genreList){
           try{
               $query= "UPDATE ".$this->tableName." set id=:id, name=:name WHERE id=:id";
               
               $this->connection = Connection::getInstance();
               
               foreach($genreList as $genre){
               $parameters['id']=$genre->getId();
               $parameters['name']=$genre->getName();

               $rowCant+=$this->connection->executeNonQuery($query,$parameters);
               }
               return $rowCant;

           }catch(\PDOException $ex){
               throw $ex;
           }
        }   

        
        public function search($idGenre){
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE id= :id";
                $parameters["id"]=$idGenre;

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


        protected function map($value){
            $value=is_array($value) ? $value: array();
            
            $result= array_map(function ($f){
                $genre= new Genre();
                $genre->SetId($f['id']);
                $genre->SetName($f['name']);

                return $genre;
            },$value);
 
            return count($result) > 1 ? $result: $result["0"];
        }

    }?>