<?php 

namespace Models;

class Role{
    private $id;
    private $description;

    public function __construct(){
        $this->id = 0;
        $this->description="client";
    }

    function setId($id){
        $this->id=$id;
        $this->setDescription($id);
    }
    
    function setDescription($id){ 
        if($id == 1){
            $this->description="admin";
        }else{
            $this->description="client";
        }
    }

    function getId(){return $this->id;}
    function getDescription(){return $this->description;}
}

?>