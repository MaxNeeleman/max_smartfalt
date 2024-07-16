          
    <?php
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        use PHPMailer\PHPMailer\SMTP;
        
        require_once '..\smartfalt\vendor\autoload.php';
    ?>
      
    <?php
    if(isset($_POST['input-email']) && $_POST['input-email'] != ''){

      if( filter_var($_POST['input-email'], FILTER_VALIDATE_EMAIL) ){

        $inputemail = $_POST['input-email'];
  
        $nieuwsbrief = new PHPMailer(true);
        $nieuwsbrief->isSMTP();
        $nieuwsbrief->Host = 'smtp.gmail.com';
        $nieuwsbrief->SMTPAuth = true;
        $nieuwsbrief->Username = 'maxneeleman1999@gmail.com';
        $nieuwsbrief->Password = 'mnrnhpyghbfqhamn';
        $nieuwsbrief->Port = 465;
        $nieuwsbrief->SMTPSecure = 'ssl';
        $nieuwsbrief->isHTML(true);
        $nieuwsbrief->setFrom('maxneeleman1999@gmail.com', 'Smartfalt');
        $nieuwsbrief->addAddress($inputemail, $inputemail);
        $nieuwsbrief->Subject = ('Informatie aanvraag Smartfalt');
        $nieuwsbrief->Body = 'De moderne snelweg zoals wij die kennen, stamt af uit 1920. Mix dat met de technologie van de 21e eeuw en je krijgt Smartfalt. Smartfalt is een initiatief om het oude wegennet te moderniseren met de technologie van nu. We denken hierbij aan een weg diede bestuurder helpt met veilig, snel en goedkoper thuiskomen. Dit willen we bereiken doormiddel van sensoren in de geleiderail en lantarenpalen, oplaadlussen in het asfalt en zonnepanelen langs deweg.Smartfalt, een weg naar de toekomst!';
        $nieuwsbrief->Send();
      }
    }
    ?>
