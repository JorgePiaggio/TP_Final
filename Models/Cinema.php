<?php
namespace Models;

class Cinema{

    private $name;
    private $address;
    private $phone;
    private $email;

    function __construct(){}
    
    function getName(){return $this->name;}
    function getAddress(){return $this->address;}
    function getPhone(){return $this->phone;}
    function getEmail(){return $this->email;}
    function setName($name){$this->name=$name;}
    function setAddress($address){$this->address=$address;}
    function setPhone($phone){$this->phone=$phone;}
    function setEmail($email){$this->email=$email;}

}
?>