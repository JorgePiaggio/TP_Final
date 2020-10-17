<?php
    namespace DAO;

    use DAO\IGenreDAO as IGenreDAO;
    use Models\Genre as Genre;

    class GenreDAO implements IGenreDAO{
        private $genreList = array();


        public function Add($genre){
            $this->RetrieveData();
            array_push($this->genreList, $genre);
            $this->SaveData();
        }

        public function GetAll(){
            $this->RetrieveData();
            return $this->genreList;
        }

          /* agregar generos al DAO */
        public function UpdateList($genreList){
            $this->RetrieveData();
            foreach($genreList as $genre){
                $exists=$this->search($genre->getId());
                if(!$exists){
                    $this->Add($genre);
                }
            }
        }   

        public function search($idGenre){
            $this->RetrieveData();
            foreach($this->genreList as $genre){
                if($genre->getId() == $idGenre){
                    return true;
                }
            }
            return false;
        }

        private function SaveData(){
            $arrayToEncode = array();
            foreach($this->genreList as $genre){
                $valuesArray["id"] = $genre->getId();
                $valuesArray["name"] = $genre->getName();
                array_push($arrayToEncode, $valuesArray);
            }
            $jsonContent = json_encode($arrayToEncode , JSON_PRETTY_PRINT);
            file_put_contents('Data/genres.json', $jsonContent);
        }

        private function RetrieveData(){
            $this->genreList = array();
            
            if(file_exists('Data/genres.json')){

                $jsonContent = file_get_contents('Data/genres.json');

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray){
                    $genre = new Genre();
                    $genre->setId($valuesArray["id"]);
                    $genre->setName($valuesArray["name"]);
                    array_push($this->genreList, $genre);
                }

            }
        }

    }
    ?>