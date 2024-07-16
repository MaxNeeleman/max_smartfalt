<?php
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        use PHPMailer\PHPMailer\SMTP;
        
        require_once '..\smartfalt\vendor\autoload.php';
    ?>
      

<?php
    if(isset($_POST['Email']) && $_POST['Email'] != ''){

      if( filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL) ){
    
        $naam = $_POST['Naam'];
        $email = $_POST['Email'];
        $telefoonNummer = $_POST['Telefoonnummer'];
        $bericht = $_POST['Bericht'];
  
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'maxneeleman1999@gmail.com';
        $mail->Password = 'mnrnhpyghbfqhamn';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->isHTML(true);
        $mail->setFrom($email, $naam);
        $mail->addAddress('maxneeleman1999@gmail.com', 'Smartfalt');
        $mail->Subject = ("Nieuwe mail van $email ! - $telefoonNummer");
        $mail->Body = $bericht;
        $mail->send();
      }
    }
    ?>