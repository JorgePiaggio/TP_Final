<?php 

namespace Controllers;


use Models\User as User;
use DAO\UserDAO as UserDAO;
use DAO\RoleDAO as RoleDAO;
use Models\Role as Role;
use DAO\TicketDAO as TicketDAO;
use DAO\UsersReviewsDAO as UsersReviewsDAO;
use Config\Validate as Validate;
use \Exception as Exception;
use lib\PHPMailer\PHPMailer as PHPMailer;
#use lib\PHPMailer\Exception as Exception;
use lib\PHPMailer\SMTP as SMTP;

class UserController{
    private $userDAO;
    private $userReviewsDAO;
    private $user;
    private $msg;
    private $roleDAO;
    private $ticketDAO;
    
    public function __construct(){
        $this->userDAO = new UserDAO(); 
        $this->userReviewsDAO = new UsersReviewsDAO(); 
        $this->user = null;
        $this->msg = null;
        $this->ticketDAO= new TicketDAO();
        $this->roleDAO= new RoleDAO();
        $this->createRoles();
   
    }

    public function showLogin(){
    require_once(VIEWS_PATH."Users/User-login.php");
    }


    public function showProfile(){
        
        if($_SESSION){
            try{
                $user = $this->userDAO->search($_SESSION['loggedUser']);
                $ticketHistory = $this->ticketDAO->getTicketsByClient($user->getIdUser());
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }

            require_once(VIEWS_PATH."Users/User-profile.php");

        }else{
            header("location:../Home/index");
        }
    }


    public function showRegister(){
        require_once(VIEWS_PATH."Users/User-register.php");
    }


    public function showEditView(){
        if($_SESSION){
            require_once(VIEWS_PATH."Users/User-profile.php");
        }else{
            header("location:../Home/index");
        }
    }


    public function showSelectUser(){
        Validate::validateSession();

        require_once(VIEWS_PATH."Users/User-search.php");
    }


    public function showUserView($emailUser=""){
        Validate::checkParameter($emailUser);
        Validate::validateSession();

        try{
            $user = $this->userDAO->search($emailUser);
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }

        if(!$user){
            $this->msg = "Email doesn't exist";
            $this->showSelectUser();
        }
        else{
            require_once(VIEWS_PATH."Users/User-view.php");    
        }
        
    }
    

    /* lista de reviews que envian los users en el footer */
    public function showUserReviews($idRemove = ""){
        Validate::validateSession();

        try{
            if($idRemove){
                $this->userReviewsDAO->remove($idRemove);
            }

            $messageList=$this->userReviewsDAO->getAll();

        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
        require_once(VIEWS_PATH."Users/User-reviews.php");
    }


    public function login($email="",$pass=""){
        #Validate::checkParameter($email);

        try{
            $user=$this->userDAO->search($email); //busco el user a traves del email
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
        
        if(($email=="admin@moviepass.com" && $pass=="admin") || ($user!=null && strcmp($user->getPassWord(),$pass)==0)){ //Comparo si es el admin o un user y si coincide mail y pass
            $_SESSION["loggedUser"]=$email; 
            if(strcmp($email,"admin@moviepass.com")!=0){   
                $_SESSION["role"]=$user->getRole()->getId();
            }else{
                $_SESSION["role"]=1;
            }
            header("location:../Home/index");
        }else{
            $this->msg = "Incorrect Email or Password";
            $this->showLogin();
        }
    }


    public function logout(){ 
  
        session_destroy();
        
        #header("location:../Home/index");

        $this->showLogin();
    }
    

    /* usuario logueado por facebook, si no existe se registra */
    public function userFacebook(){
    
        $name= $_SESSION['facebookUser']['first_name'];
        $surname= $_SESSION['facebookUser']['last_name'];
        $email= $_SESSION['facebookUser']['email'];
        $pass= "Ff".substr($_SESSION['facebookUser']['id'],0,14);

        $user = $this->userDAO->search($email);

        if($user == false){
            $this->register($name, $surname,"0","Undefined","0",$email, $pass, $pass);
        }else{
            $_SESSION["loggedUser"]=$email;
            $_SESSION["role"]=$user->getRole()->getId();
            header("location:../Home/index");
        }
    }



    public function register($name="",$surname="",$dni="",$street="",$number="",$email="",$pass="",$repass=""){
        Validate::checkParameter($name);
   
                $this->user= new user();
                $this->user->setName($name);
                $this->user->setSurname($surname);
                $this->user->setDni($dni);
                $this->user->setStreet($street);
                $this->user->setNumber($number);
                $this->user->setEmail($email);
                $this->user->setPassword($pass);

            if(!$this->validateEmail($email)){                   //Valido que ya no exista un usuario con ese email
                if($this->validatePass($pass, $repass)){         //Valido que la contraseña cumpla con los requisitos
                    try{
                        $this->userDAO->add($this->user);
                
                        $_SESSION["loggedUser"]=$email;
                        $_SESSION["role"]=$this->user->getRole()->getId();

                        if(isset($_SESSION["facebookUser"])){   //usuario registrado a traves de facebook
                            $this->sendEmail($email,$name,$surname,$pass);
                        }
                    }catch(\Exception $e){
                        echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
                    }
                header("location:../Home/index");
                }
          
            }
            else{
                $this->msg="Email: '$email' already exists";
        }
        $this->showRegister();
    }


    public function edit($name="",$surname="",$dni="",$street="",$number="",$email="",$pass="",$repass=""){
        Validate::checkParameter($name);
        #Validate::validateSession();
        try{
            $userAux = $this->userDAO->search($email);
                
            if($this->validatePass($pass, $repass)){
                $user= new user();
                $user->setIdUser($userAux->getIdUser());
                $user->setName($name);
                $user->setSurname($surname);
                $user->setDni($dni);
                $user->setStreet($street);
                $user->setNumber($number);
                $user->setEmail($email);
                $user->setPassword($pass);
                $result = $this->userDAO->update($user);
                
                if($result > 0) {
                    $_SESSION["loggedUser"]=$email;
                    $_SESSION["role"]=$user->getRole()->getId();
                    $this->msg = "Profile updated";
                }else{
                    $this->msg = "Internal error. Please try again later";
                }
            }
            else{
                $this->msg = "Invalid password";  
            }
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
        $this->showProfile();
    }


    private function validatePass($pass, $repass){
        Validate::checkParameter($pass);

        if(strlen($pass) < 6){
           $this->msg = "The password must be at least 6 characters";
           return false;
        }
        if(strlen($pass) > 16){
           $this->msg = "The password cannot be longer than 16 characters";
           return false;
        }
        if (!preg_match('`[a-z]`',$pass)){
           $this->msg = "The password must have at least one lowercase letter";
           return false;
        }
        if (!preg_match('`[A-Z]`',$pass)){
           $this->msg = "The key must have at least one capital letter";
           return false;
        }
        if (!preg_match('`[0-9]`',$pass)){
           $this->msg = "The password must have at least one numeric character";
           return false;
        }
        if (strcmp($pass, $repass) != 0){     
            $this->msg = "Passwords don't match";
            return false;
        }
        return true;
    }

    /* Valida que ya no exista un usuario con ese email */
    private function validateEmail($email=""){
        Validate::checkParameter($email);

        try{
            $user = $this->userDAO->search($email);           //Busco en la BD un usuario a través del email
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }

        $answer = false;
        
        if($user){
            $answer = true;
        }
        else{
            if($email == "admin@moviepass.com"){             //Valido que el email ingresado no sea igual al email del super admin
                $answer = true;
            }
        }

        return $answer;     //Retorna true si ya existe un usuario con ese email y false si no
    }


    public function changeRole($userEmail=""){
        Validate::checkParameter($userEmail);
        Validate::validateSession();
        
        try{
            $result = $this->userDAO->changeRole($userEmail);
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }

        if($result > 0){
            $this->msg = "Role changed succesfully!";
        }else{
            $this->msg = "Internal error. Please try again later";
        } 
        
        $this->showUserView($userEmail);
    }


    public function sendEmail($email="", $name="", $lastname="", $pass=""){
        Validate::checkParameter($email);

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'moviepassdevelopers@gmail.com';                     // SMTP username
            $mail->Password   = '';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        
        //Recipients
            $mail->setFrom('moviepassdevelopers@gmail.com', 'MoviePass');
            $mail->addAddress($email, $name);     // Add a recipient
                // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Welcome to MoviePass!';
                $mail->Body = 'Thanks '.$name.' '.$lastname. ' for registering in MoviePass.'. '<br><br> Change your password for your account security.<br><br>
                                Email: '. $email.'<br>
                                Password: '. $pass.'<br> ';
            $mail->send();
            $this->msg='Message has been sent to: '.$email.', thanks for registering';
        }catch (Exception $e) {
            $this->msg='Message could not be sent, Mailer Error:'.$mail->ErrorInfo;
        }

    }




    /* Guarda mensajes de users sobre la web en un json */    
    public function submitReview($mail=null, $message=null){
        Validate::validateSession();

        if($message != null){
           
            //lista de insultos
            $censuradas=array('mamón', 'forro', 'hdp', 'chupachichi');
            //contar los insultos
            $partes=count($censuradas);
            
            //censura en proceso..
            for ($i=0; $i < $partes; $i++) { 
                if(strpos($message,$censuradas[$i]) !== false ){
                    $message=str_replace($censuradas[$i],'****',$message);
                }
            }          

            try{
                // guardar en JSON 
                $msgArray = array();
                $id=($this->userReviewsDAO->getLastId())+1;
                array_push($msgArray,$id);
                array_push($msgArray,$message);
                array_push($msgArray,$mail);
                $this->userReviewsDAO->add($msgArray);
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }
        }
        header("location:../Home/index");
    }

    private function createRoles(){
        try{
            if($this->roleDAO->getAll()==null){
                $roleUser=new Role();
                $roleAdmin= new Role();
                $roleAdmin->setId(1);
                $this->roleDAO->add($roleUser);
                $this->roleDAO->add($roleAdmin);
            }
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
    }

}

?>
