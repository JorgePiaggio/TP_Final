<?php 
namespace Models;

class User{

    private $id;
    private $dni;
    private $name;
    private $surname;
    private $address;
    private $phone;
    private $email;
    private $password;
    #private $billList; //??
    #private $cardList; //??


    public function __construct()
    {
        $this->billList = array();
        $this->cardList = array();
    }

    public function setId($id){$this->id=$id;}
    public function getId(){return $this->id;}
    public function setDni($dni){$this->dni=$dni;}
    public function getDni(){return $this->dni;}
    public function setName($name){$this->name=$name;}
    public function getName(){return $this->name;}
    public function setSurname($surname){$this->surname=$surname;}
    public function getSurname(){return $this->surname;}
    public function setAddress($address){$this->address=$address;}
    public function getAddress(){return $this->address;}
    public function setPhone($phone){$this->phone=$phone;}
    public function getPhone(){return $this->phone;}
    public function setEmail($email){$this->email=$email;}
    public function getEmail(){return $this->email;}
    public function setPassword($password){$this->password=$password;}
    public function getPassword(){return $this->password;}
    #public function setBillList($billList){$this->billList=$billList;}
    #public function getBillList(){return $this->billList;}
    #public function setCardList($cardList){$this->cardList=$cardList;}
    #public function getCardList(){return $this->cardList;}
    
    #public function addBill($bill){array_push($this->billList,$bill);}
    #public function addCard($card){array_push($this->cardList,$card);}
    



}



?>