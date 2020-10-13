<?php 
namespace Controllers;
if(!$_SESSION || $_SESSION["loggedUser"]=="admin@moviepass.com"){
    header("location:../Home/Index");
}
use Models\Client as Client;
use DAO\ClientDAO as ClientDAO;

class ClientController{
    private $ClientDAO;
    public function __construct(){
        $this->ClientDAO = new ClientDAO(); 
    }

    





}


?>