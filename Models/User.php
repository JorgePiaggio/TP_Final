<?php 
namespace Models;

class User{

    private $idUser;
    private $idRole;
    private $dni;
    private $name;
    private $surname;
    private $street;
    private $number;
    private $phone;
    private $email;
    private $password;



    public function __construct(){
        $this->idRole=0;
    }

    public function setIdUser($idUser){$this->idUser=$idUser;}
    public function getIdUser(){return $this->idUser;}
    public function setIdRole($idRole){$this->idRole=$idRole;}
    public function getIdRole(){return $this->idRole;}
    public function setDni($dni){$this->dni=$dni;}
    public function getDni(){return $this->dni;}
    public function setName($name){$this->name=$name;}
    public function getName(){return $this->name;}
    public function setSurname($surname){$this->surname=$surname;}
    public function getSurname(){return $this->surname;}
    public function setStreet($street){$this->street=$street;}
    public function getStreet(){return $this->street;}
    public function setNumber($number){$this->number=$number;}
    public function getNumber(){return $this->number;}
    public function setPhone($phone){$this->phone=$phone;}
    public function getPhone(){return $this->phone;}
    public function setEmail($email){$this->email=$email;}
    public function getEmail(){return $this->email;}
    public function setPassword($password){$this->password=$password;}
    public function getPassword(){return $this->password;}

    



}



?>