<?php 


use lib\PHPMailer\PHPMailer as PHPMailer;
use lib\PHPMailer\Exception as Exception;
use lib\PHPMailer\SMTP as SMTP;

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


    // Attachments
    /*foreach($seatList as $seat){
       
    $mail->addAttachment( ROOT.IMG_PATH_TICKET.$seat[0].$seat[1].$idShow.'.png'); 
    }        // Add attachments*/

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Ticket '.$date;

    $msg= $name.' You have '.$cantTicket.' <b>MoviePass<b> ticket/s. Thank you for your purchase<br><br><br>';
    $msg.=  '<table border="1" width="auto" height="auto" bgcolor="#ffa500">
    <thead class="bg-dark text-white">
        <th>User</th>
        <th>Cinema</th>
        <th>Room</th>
        <th>Movie</th>
        <th>Date </th>
        <th>Seat</th>                            
        <th>QR Code</th>
    </thead>
<tbody>';
        
        if($seatList){ 
            foreach($seatList as $seat){
            $msg.='<tr>';
               $msg.= '<td><p>'.$name.'</p></td>';
               $msg.= '<td><p>'.$cinema.'</p></td>';
               $msg.= '<td><p>'.$room.'</p></td>';
               $msg.='<td><p>'.$movieTitle.'</p></td>';  
               $msg.='<td><p>'.$date.' hs</p></td>';   
                $msg.='<td><p>'." Row: ".$seat[0]."  Column:".$seat[1].'</p></td>'; 
                $msg.='<td><img src="'.APIQRCODE.$card.$seat[0].$seat[1].$idShow.'">'.'</td>';
           $msg.=' </tr> ';
             }
        } 
        
        
  $msg.= ' </tbody>
</table><br><br>';
$mail->Body = $msg;
    $mail->send();
    $this->msg='Message has been sent to: '.$email.', thanks for your purchase';
}catch (Exception $e) {
    $this->msg='Message could not be sent, Mailer Error:'.$mail->ErrorInfo;
}

?>

<div class="hoc"><br>
<?php if($this->msg != null){?> 
        <center><h4 class="msg"><?php  echo $this->msg;} ?> </h4></center>
</div> <br><br>
</div>
