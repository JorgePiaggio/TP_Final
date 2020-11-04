<?php 


use Config\PHPMailer as PHPMailer;
use Config\Exception as Exception;
use Config\SMTP as SMTP;

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'moviepassdevelopers@gmail.com';                     // SMTP username
    $mail->Password   = 'moviepass1';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('moviepassdevelopers@gmail.com', 'MoviePass');
    $mail->addAddress($email, $name);     // Add a recipient


    // Attachments
    foreach($seatList as $seat){
       
    $mail->addAttachment( ROOT.IMG_PATH_TICKET.$seat[0].$seat[1].$idShow.'.png'); 
    }        // Add attachments

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Ticket' .$date;
    $mail->Body    = $name.' You have '.$cantTicket.' ticket/s <b>moviepass thanks you for your purchase<b> Cinema: '.$cinema." Room: ".$room." Movie: ".$movieTitle." Date: ".$date."  Seats: ".$seats;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    $this->msg='Message has been sent to: '.$email.', thanks you for your purchase';
}catch (Exception $e) {
    $this->msg="Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>
<div class="hoc"><br>
<?php if($this->msg != null){?> 
        <center><h4 class="msg"><?php  echo $this->msg;} ?> </h4></center>
</div> <br><br>
</div>
