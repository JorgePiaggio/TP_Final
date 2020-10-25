<?php namespace DAO;

use DAO\IUsersReviewsDAO as IUsersReviewsDAO;

class UsersReviewsDAO implements IUsersReviewsDAO{

    private $messageList = array();

    public function getAll(){
        $this->retrieveData();
        return $this->messageList;
    }

    public function add($newMessage){
        
        $this->retrieveData();
        
        array_push($this->messageList, $newMessage);

        $this->saveData();
    }

    function getLastId(){
        $this->retrieveData();
        return count($this->messageList);
    }


    function remove($idMessage){
        $this->retrieveData();
        $newList= array();
        foreach($this->messageList as $message){
            if($message[0] != $idMessage){
                array_push($newList,$message);
                
            }
        }
        $this->messageList=$newList;
        $this->saveData();
    }

    //Json Persistence
    private function saveData()
    {
        $arrayToEncode = array();

        foreach($this->messageList as $message)
        {
            array_push($arrayToEncode, $message);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        
        file_put_contents(ROOT.'Data/usersReviews.json', $jsonContent);
    }

    private function retrieveData()
    {
        $this->messageList = array();

        if(file_exists(ROOT.'Data/usersReviews.json'))
        {
            $jsonContent = file_get_contents(ROOT.'Data/usersReviews.json');

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach($arrayToDecode as $valuesArray)
            {
                $message = $valuesArray;
                array_push($this->messageList, $message);
            }
        }
    }
}

?>
