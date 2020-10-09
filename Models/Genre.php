<?php
namespace Models;

class Genre{ 

    private $id;
    private $name;
  
    function __construct(){
    }
    
    function getId(){return $this->id;}
    function getName(){return $this->name;}
    function setId($id){$this->id=$id;}
    function setName($name){$this->name=$name;}

}
?>