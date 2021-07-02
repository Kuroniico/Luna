<?php

    require_once dirname(__FILE__)."./../vendor/autoload.php";
    require_once dirname(__FILE__)."./../DB.php";

    // —— Load applicant data
    $candidat = $DB->prepare( "SELECT * FROM Candidats WHERE Token = ?" );
    $candidat->execute( array( $_GET["uid"] ) );
    $candidat = $candidat->fetch( );

    // —— Load parametres
    $parametres = $DB->query( "SELECT * FROM Parametres Limit 1" );
    $parametres = $parametres->fetch( );


    // —— Import Html2Pdf classes into the global namespace
    use Spipu\Html2Pdf\Html2Pdf;
    use Spipu\Html2Pdf\Exception\Html2PdfException;
    use Spipu\Html2Pdf\Exception\ExceptionFormatter;

    // —— Import PHPMailer classes into the global namespace
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // —— PDF Generation
    try {

        // —— Generate new base PDF with default parameters
        $html2pdf = new Html2Pdf( "P", "A4", "fr", true, "UTF-8", array( 0, 0, 0, 0 ) );
        $html2pdf->pdf->SetDisplayMode( "fullpage" );

        // —— Start html capture content
        ob_start();
        include dirname( __FILE__ ) . "/pdf.php";
        $content = ob_get_clean();

        $html2pdf->writeHTML($content);

        // —— Create an instance of PHPMailer
        $mail = new PHPMailer( );

        // —— Mail Server settings
        $mail->isSMTP( );
        $mail->Host       = $parametres["ServerSMTP"];
        $mail->SMTPAuth   = true;
        $mail->Username   = $parametres["UserSMTP"];
        $mail->Password   = $parametres["PasswordSMTP"];
        $mail->SMTPSecure = $parametres["SecureSMTP"];
        $mail->Port       = $parametres["PortSMTP"];

        $mail->setFrom( $parametres["FromSMTP"] );
        $mail->addAddress( $parametres["ToSMTP"] );

        $name = date( "Y-m-d" ) . "-" . preg_replace( "/[^a-zA-Z0-9_ -]/s", "", $candidat["Prenom"]."-".$candidat["Nom"] )  . "-" .  $candidat["DateDeNaissance"] . ".pdf";

        $html2pdf->Output( $_SERVER['DOCUMENT_ROOT'] . "gestion_questionnaires_rh/BackupTest/" . $name, "F" );
        $mail->addStringAttachment( $html2pdf->Output( $name, "S" ), $name, $encoding = "base64", $type = "application/pdf");


        // —— Content
        $mail->isHTML(true);
        $mail->Subject = "Guide d'entretien Collectif " . $candidat[ "Nom" ] . " " . $candidat[ "Prenom" ] . " / " . date( "Y-m-d" );
        $mail->Body    = " ";

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: { $mail->ErrorInfo }";
    }