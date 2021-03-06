<?php
    namespace DAO;

    use DAO\IGenreDAO as IGenreDAO;
    use Models\Genre as Genre;
    use DAO\Connection as Connection;

    class GenreDAO implements IGenreDAO{
        private $connection;
        private $tableName = "genres";


        public function add(Genre $genre){
            $exists= $this->search($genre->getId());
            
            if(!$exists){
                $sql = "INSERT INTO ".$this->tableName." (idGenre, name) VALUES (:id, :name)";
                $parameters['id']=$genre->getId();
                $parameters['name']=$genre->getName();

                try{
                    $this->connection= Connection::getInstance();
                    return $this->connection->executeNonQuery($sql,$parameters);
                }catch(\PDOException $ex){
                    throw $ex;
                }
            }
        }


        public function getAll(){
            try{
                $genreList= array();

                $query = "SELECT idGenre, name FROM genres";

                $this->connection = Connection::getInstance();

                $result= $this->connection->execute($query);

                //$genreList= $this->map($result);
                
                foreach($result as $g){
                    $genre= new Genre();
                    $genre->SetId($g['idGenre']);
                    $genre->SetName($g['name']);
                    array_push($genreList,$genre);
                }

            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            if(!empty($genreList)){
                return $genreList;
            }else{
                return null;
            }  
        }

        
        
        public function search($idGenre){
            try
            {
                $query = "SELECT * FROM genres AS g WHERE g.idGenre= :id";
                $parameters["id"]=$idGenre;

                $this->connection = Connection::getInstance();

                $results = $this->connection->execute($query,$parameters);

               
            foreach($results as $g){
                $genre= new Genre();
                $genre->SetId($g['idGenre']);
                $genre->SetName($g['name']);
            }
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            if(!empty($results)){
                return $genre;
            }else{
                return null;
            }  
        }


        protected function map($value){
            $value=is_array($value) ? $value: array();

            $result= array_map(function ($f){
                $genre= new Genre();
                $genre->SetId($f['idGenre']);
                $genre->SetName($f['name']);
                return $genre;
            },$value);
 
            return count($result) > 1 ? $result: $result["0"];
      
        }

}?>