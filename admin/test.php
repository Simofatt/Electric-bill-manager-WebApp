<?php
session_start();
require("../commun/connexion.php");
require_once('../depen/pdf/fpdf.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

use \setasign\Fpdi\Fpdi;


ob_start();
if (isset($_POST['submit'])  && isset($_GET['idFacture'])) {
    $submitValue = $_POST['submit'];
    if ($submitValue == "Valider") {
        $idFacture = $_GET['idFacture'];
        $requete5 = $db->prepare('SELECT * FROM facture where idFacture  = ?');
        $requete5->execute(array($idFacture));
        $result5 = $requete5->fetch();
        if ($result5) {
            $idClient = $result5['idClient'];
            $consommation = $result5['consommation'];
            $dateFacture = $result5['dateFacture'];
            $prixHT = $result5['prixHT'];
            $prixTTC = $result5['prixTTC'];
        }
        $requete3 = $db->prepare('SELECT * FROM clients where idClient = ?');
        $requete3->execute(array($idClient));
        $result3 = $requete3->fetch();
        if ($result3) {
            $fullName = $result3['fullName'];
            $email = $result3['email'];
            $adresse = $result3['adresse'];
        }
        $taxes = $prixTTC - $prixHT;
        $dateEcheance = date('d-m-Y', strtotime($dateFacture . ' +30 days'));
        //$imagePath = "Logo.png";
        //$imagePath2 = $address;
        // Creating a document object
        $pdf = new Fpdf();
        $pdf->AddPage();
        // Adding color and styles
        $pdf->SetFillColor(200, 200, 200);
        $pdf->SetFont('Helvetica', 'B', 14);
        $pdf->Cell(0, 20, utf8_decode('FACTURE DÉLECTRICITÉ'), 0, 1, 'C', true);
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
        $pdf->Write(10, utf8_decode("Facture n° : "));
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Write(10, "\t" . $idFacture  . " \n");
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Write(10, "Usage : ");
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Write(10, "EAU DOMESTIQUE " . "\n");
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Write(10, "Consommation : ");
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Write(10, $consommation . " KWH" . "\n");
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Write(10, "Prix HT : ");
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Write(10, number_format($prixHT, 2) . "MAD" . "\n");
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Write(10, "Taxes : ");
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Write(10, number_format($taxes, 2) . "MAD" . "\n");
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Write(10, "Prix TTC : ");
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Write(10, number_format($prixTTC, 2) . "MAD" . "\n\n");
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Write(10, "Date de facturation : ");
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Write(10, date('d-m-Y', strtotime($dateFacture)) . "\n");
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Write(10, utf8_decode("Date d'échéance : "));
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Write(10, $dateEcheance . "\n\n");
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Write(10, utf8_decode("Veuillez trouver ci-joint la facture correspondant à votre consommation d'eau domestique. Vous trouverez ci-dessous le détail de votre consommation ainsi que le montant total de votre facture. Veuillez effectuer le paiement avant la date d'échéance mentionnée ci-dessus. En cas de retard de paiement, des pénalités pourront être appliquées."));
        $pdfPath = '../Factures/facture' . $idFacture . $idClient . '.pdf';
        $requete3 = $db->prepare('UPDATE facture SET statut ="validée" WHERE idFacture = ?');
        $requete3->execute(array($idFacture));
        $pdf->Output('F', $pdfPath); // Save PDF to server file path


        $mail = new PHPMailer(true);

        // Configurer les paramètres du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mohamedalhabib.fatehi@etu.uae.ac.ma';
        $mail->Password = 'med@widadi01';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Configurer les paramètres de l'email
        $mail->setFrom('mohamedalhabib.fatehi@etu.uae.ac.ma', 'fatehi mohamed alhabib');
        $mail->addAddress($email);
        $mail->Subject = utf8_decode("Facture d'électricité");
        $mail->Body =  utf8_decode("Bonjour, Voici votre facture n°" . $idFacture . "Merci de bien vouloir proceder au paiement avant la date d'echeance cité dans la facture");
        $mail->addAttachment($pdfPath);


        // Envoyer l'email
        if (!$mail->send()) {
            echo 'Erreur: ' . $mail->ErrorInfo;
        } else {
            echo 'Email envoyé';
        }
        header('location: pdfGenerate.php');
        exit();
    } else if (isset($_POST['submit'])   && isset($_GET['idFacture'])) {
        $submitValue = $_POST['submit'];
        if ($submitValue == "Rectifier") {
            $idFacture = $_GET['idFacture'];
            header('location: pdfGenerate.php?idFacture=' . $idFacture . '&rectification=1');
            exit();
        }
    }
}
