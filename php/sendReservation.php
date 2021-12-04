<?php
if(isset($_POST['email'])) {

    $email_from = $_POST['email']; // required
    $email_to =  $email_from;
    $email_subject = "Bierbrouwerij Kwartje | ArrangementForm";

    function died($error) {
        echo "Het spijt ons zeer, maar er zijn fout (en) gevonden in het formulier dat u heeft ingediend. ";
        echo "Deze fouten worden hieronder weergegeven.<br /><br />";
        echo $error."<br /><br />";
        echo "Ga terug en los deze fouten op.<br /><br />";
        die();
    }


    if(!isset($_POST['vname']) ||
        !isset($_POST['aname']) ||
        !isset($_POST['arrangement']) ||
        !isset($_POST['date']) ||
        !isset($_POST['time']) ||
        !isset($_POST['email']) ||
        !isset($_POST['telephone']) ||
        !isset($_POST['comments'])) {
        died('Het spijt ons, maar er lijkt een probleem te zijn met het ingevulde formulier.');
    }



    $vname = $_POST['vname']; // required
    $aname = $_POST['aname']; // required
    $arrangement = $_POST['arrangement']; // required
    $time = $_POST['time']; // required
    $date = $_POST['date']; // required
    $telephone = $_POST['telephone']; // not required
    $comments = $_POST['comments']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if(!preg_match($email_exp,$email_from)) {
        $error_message .= 'Het e-mailadres dat u heeft ingevoerd, lijkt niet geldig te zijn.<br />';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if(!preg_match($string_exp,$vname)) {
        $error_message .= '\'De opgegeven voornaam lijkt niet geldig te zijn.<br />';
    }
    if(!preg_match($string_exp,$aname)) {
        $error_message .= '\'De opgegeven achternaam lijkt niet geldig te zijn.<br />';
    }

    if(!preg_match($string_exp,$arrangement)) {
        $error_message .= 'De door u arrangement lijkt niet geldig te zijn<br />';
    }

    if(!preg_match($string_exp, $time)) {
        $error_message .= 'De door u tijd lijkt niet geldig te zijn<br />';
    }

    if(!preg_match($string_exp, $date)) {
        $error_message .= 'De door u datum lijkt niet geldig te zijn<br />';
    }

    if(strlen($comments) < 2) {
        $error_message .= 'De opmerkingen die je hebt ingevoerd, lijken niet geldig te zijn<br />';
    }

    if(strlen($error_message) > 0) {
        died($error_message);
    }

    $email_message = "Formulierdetails hieronder\n\n";


    function clean_string($string) {
        $bad = array("content-type","bcc:","to:","cc:","href");
        return str_replace($bad,"",$string);
    }



    $email_message .= "Voornaam: ".clean_string($vname)."\n";
    $email_message .= "Achternaam: ".clean_string($aname)."\n";
    $email_message .= "Arrangement: ".clean_string($arrangement)."\n";
    $email_message .= "Tijd: ".clean_string($time)."\n";
    $email_message .= "Datum: ".clean_string($date)."\n";
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
    header("Location: ../contact.html");
    die();

}
?>