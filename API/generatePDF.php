<?php



    ini_set( "display_errors", 1);
    ini_set( "display_startup_errors", 1);
    error_reporting( E_ALL );


    require_once "../vendor/autoload.php";

    use Spipu\Html2Pdf\Html2Pdf;

    $html2pdf = new Html2Pdf();
    $html2pdf->writeHTML('<h1>HelloWorld</h1>This is my first test');
    $html2pdf->output();
    // Courage bg;



?>