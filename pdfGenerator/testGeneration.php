<?php
$ID = $bdd->query('')
$IDQuestion =
$IDTest =
$IDCandidat =
$Reponse =












$handle = fopen("invoice_gen.html", 'w+');
if ($handle) {
    if (!fwrite($handle, "<table border=1px>\n\t   <tr> <td>dfddfdfdf</td></tr>\t\n\t</table>")) {
        die("couldn't write to file.");
    }
    echo "success writing to file";
}
require 'html2fpdf.php';
$pdf = new HTML2FPDF();
$pdf->AddPage();
$fp = fopen("invoice_gen.html", "r");
$strContent = fread($fp, filesize("invoice_gen.html"));
fclose($fp);
$pdf->WriteHTML($strContent);
$pdf->Output("invoice_gen.pdf");
echo "PDF file is generated successfully!";

?>