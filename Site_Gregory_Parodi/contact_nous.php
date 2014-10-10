<!-- Merci Oudam :) -->
<?php
if($_POST)
{
    $to_Email       = "gregory.parodi@cifacom.com"; // Email de réception
    $subject        = 'Portfolio'; // Sujet
    
    
    //check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    
        //exit script outputting json data
        $output = json_encode(
        array(
            'type'=>'error', 
            'text' => 'Request must come from Ajax'
        ));
        
        die($output);
    } 
    
    //check le $_POST si les vars ont été correct, sortir si quelques chose manque
    if(!isset($_POST["userName"]) || !isset($_POST["userEmail"]) || !isset($_POST["userPhone"]) || !isset($_POST["userMessage"]))
    {
        $output = json_encode(array('type'=>'error', 'text' => 'Input fields are empty!'));
        die($output);
    }

    //Sanitize input data using PHP filter_var().
    $user_Name        = filter_var($_POST["userName"], FILTER_SANITIZE_STRING);
    $user_Email       = filter_var($_POST["userEmail"], FILTER_SANITIZE_EMAIL);
    $user_Phone       = filter_var($_POST["userPhone"], FILTER_SANITIZE_STRING);
    $user_Message     = filter_var($_POST["userMessage"], FILTER_SANITIZE_STRING);
    
    //validation additionel
    if(strlen($user_Name)<4) // If length is less than 4 it will throw an HTTP error.
    {
        $output = json_encode(array('type'=>'error', 'text' => 'Votre nom est trop court ! Essayez d\'entrer votre "Nom + Prénom"'));
        die($output);
    }
    if(!filter_var($user_Email, FILTER_VALIDATE_EMAIL)) //check si l'e-mail est valide
    {
        $output = json_encode(array('type'=>'error', 'text' => 'Veuillez entrer un mail valide !'));
        die($output);
    }
    if(!is_numeric($user_Phone)) //check si les données entré sont des chiffres
    {
        $output = json_encode(array('type'=>'error', 'text' => 'Seul les chiffres sont autoriser pour les numéros de tel !'));
        die($output);
    }
    if(strlen($user_Message)<5) //check les messages vides
    {
        $output = json_encode(array('type'=>'error', 'text' => 'Votre message est trop court ! Ecrivez aux moins quelques choses.'));
        die($output);
    }
    
    //proceed with PHP email.
    $headers = 'From: '.$user_Email.'' . "\r\n" .
    'Reply-To: '.$user_Email.'' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    
        // send mail
    $sentMail = @mail($to_Email, $subject, $user_Message .'  -'.$user_Name, $headers);
    
    if(!$sentMail)
    {
        $output = json_encode(array('type'=>'error', 'text' => 'Could not send mail! Please check your PHP mail configuration.'));
        die($output);
    }else{
        $output = json_encode(array('type'=>'message', 'text' => 'Bonjour '.$user_Name .' Merci pour votre email !'));
        die($output);
    }
}
?>