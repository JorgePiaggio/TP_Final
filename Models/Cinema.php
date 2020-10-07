<?php
namespace Models;

class Cinema{

    private $id;
    private $name;
    private $address;
    private $phone;
    private $email;

    function __construct(){}
    
    function getId(){return $this->id;}
    function getName(){return $this->name;}
    function getAddress(){return $this->address;}
    function getPhone(){return $this->phone;}
    function getEmail(){return $this->email;}
    function setId($id){$this->id=$id;}
    function setName($name){$this->name=$name;}
    function setAddress($address){$this->address=$address;}
    function setPhone($phone){$this->phone=$phone;}
    function setEmail($email){$this->email=$email;}

}
?>