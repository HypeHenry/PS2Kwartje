<?php
if(isset($_POST['email'])) {

    $email_from = $_POST['email']; // required
    $email_to =  $email_from;
    $email_subject = "Bierbrouwerij Kwartje | Contactform";

    function died($error) {
        echo "Het spijt ons zeer, maar er zijn fout (en) gevonden in het formulier dat u heeft ingediend. ";
        echo "Deze fouten worden hieronder weergegeven.<br /><br />";
        echo $error."<br /><br />";
        echo "Ga terug en los deze fouten op.<br /><br />";
        die();
    }


    if(!isset($_POST['name']) ||
        !isset($_POST['subject']) ||
        !isset($_POST['email']) ||
        !isset($_POST['telephone']) ||
        !isset($_POST['comments'])) {
        died('Het spijt ons, maar er lijkt een probleem te zijn met het ingevulde formulier.');
    }



    $name = $_POST['name']; // required
    $subject = $_POST['subject']; // required
    $telephone = $_POST['telephone']; // not required
    $comments = $_POST['comments']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if(!preg_match($email_exp,$email_from)) {
        $error_message .= 'Het e-mailadres dat u heeft ingevoerd, lijkt niet geldig te zijn.<br />';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if(!preg_match($string_exp,$name)) {
        $error_message .= '\'De opgegeven naam lijkt niet geldig te zijn.<br />';
    }

    if(!preg_match($string_exp,$subject)) {
        $error_message .= 'De door u onderwerp lijkt niet geldig te zijn<br />';
    }

    if(strlen($comments) < 2) {
        $error_message .= 'De opmerkingen die je hebt ingevoerd, lijken niet geldig te zijn<br />';
    }

    if(strlen($error_message) > 0) {
        died($error_message);
    }

    $email_message = "Formulierdetails hieronder.\n\n";


    function clean_string($string) {
        $bad = array("content-type","bcc:","to:","cc:","href");
        return str_replace($bad,"",$string);
    }



    $email_message .= "Name: ".clean_string($name)."\n";
    $email_message .= "Onderwerp: ".clean_string($subject)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telephone: ".clean_string($telephone)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";

    $headers = 'Van: '.$email_from."\r\n".
        'Reply-To: '.$email_from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);
    ?>


    Hartelijk dank dat u contact met ons heeft opgenomen. We nemen spoedig contact met u op.
    <?php
    header("Location: contact.html");
    die();
}
?>