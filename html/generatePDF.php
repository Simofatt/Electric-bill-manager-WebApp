<?php
ob_clean();
if (isset($_POST['submit'])) {
    $date_attestation = " 4 decembre 2022";
    //$imagePath = "Logo.png";
    $imagePath2 = $address;

    // Creating a document object
    $pdf = new Fpdf();
    $pdf->AddPage();

    // Adding color and styles
    $pdf->SetFillColor(200, 200, 200);
    $pdf->SetFont('Helvetica', 'B', 14);
    $pdf->Cell(0, 20, 'FACTURE DÉLECTRICITÉ', 0, 1, 'C', true);
    $pdf->Ln(10);

    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->Write(10, "Client : ");
    $pdf->SetFont('Helvetica', '', 10);
    $pdf->Write(10, $fullName . "\n");

    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->Write(10, "Adresse email : ");
    $pdf->SetFont('Helvetica', '', 10);
    $pdf->Write(10, utf8_decode(" " . $email . "\n\n"));

    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->Write(10, "Facture n° : ");
    $pdf->SetFont('Helvetica', '', 10);
    $pdf->Write(10, "\t" . $idFacture . " \n");

    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->Write(10, "Usage : ");
    $pdf->SetFont('Helvetica', '', 10);
    $pdf->Write(10, "EAU DOMESTIQUE " . "\n");

    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->Write(10, "Date de Facture : ");
    $pdf->SetFont('Helvetica', '', 10);
    $pdf->Write(10, utf8_decode("\t \t \t\t\t " . $dateFacture) . "\n");

    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->Write(10, "Electricité : ");
    $pdf->SetFont('Helvetica', '', 10);
    $pdf->Write(10, utf8_decode("\t \t \t\t\t " . $consommation) . " \n");

    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->Write(10, "Taxes : ");
    $pdf->SetFont('Helvetica', '', 10);
    $pdf->Write(10, utf8_decode("\t \t \t\t\t " . $taxes) . " \n");

    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->Write(10, "TOTAL TTC : ");
    $pdf->SetFont('Helvetica', '', 10);
    $pdf->Write(10, utf8_decode("\t \t \t\t " . $totalTTC) . " \n\n");

    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->Write(10, "Date d'échéance : ");
    $pdf->SetFont('Helvetica', '', 10);
    $pdf->Write(10, utf8_decode("\t \t \t " . $dateEcheance) . "\n");

    $pdf->Ln(10);

    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->Write(10, "Adresse de facturation : ");
    $pdf->SetFont('Helvetica', '', 10);
    $pdf->Write(10, utf8_decode("\n" . $address) . "\n");

    $pdf->Ln(10);

    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->Write(10, "Veuillez trouver ci-joint votre facture d'électricité. Merci de votre");
}
