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

        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        // Ajout de la couleur et des styles
        $pdf->SetFillColor(26, 188, 156);
        $pdf->SetFont('Helvetica', 'B', 16);

        // En-tête de la facture
        $pdf->Cell(0, 30, utf8_decode("FACTURE D'ÉLECTRICITÉ"), 0, 1, 'C', true);
        $pdf->Ln(20);

        // Informations sur le client
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->SetTextColor(44, 62, 80);
        $pdf->Cell(0, 10, utf8_decode("Informations du client"), 0, 1, 'L');
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->SetTextColor(52, 73, 94);
        $pdf->Cell(0, 10, utf8_decode("Nom complet : " . $fullName), 0, 1, 'L');
        $pdf->Cell(0, 10, utf8_decode("Adresse email : " . $email), 0, 1, 'L');
        $pdf->Ln(10);

        // Informations de facturation
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->SetTextColor(44, 62, 80);
        $pdf->Cell(0, 10, utf8_decode("Informations de facturation"), 0, 1, 'L');
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->SetTextColor(52, 73, 94);
        $pdf->Cell(0, 10, utf8_decode("Facture n° : " . $idFacture), 0, 1, 'L');
        $pdf->Cell(0, 10, utf8_decode("Usage : ÉLECTRICITÉ DOMESTIQUE"), 0, 1, 'L');
        $pdf->Cell(0, 10, utf8_decode("Consommation : " . $consommation . " KWH"), 0, 1, 'L');
        $pdf->Ln(10);

        // Détail des prix
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->SetTextColor(44, 62, 80);
        $pdf->Cell(0, 10, utf8_decode("Détail des prix"), 0, 1, 'L');
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->SetTextColor(52, 73, 94);
        $pdf->Cell(0, 10, utf8_decode("Prix HT : " . number_format($prixHT, 2) . " MAD"), 0, 1, 'L');
        $pdf->Cell(0, 10, utf8_decode("Taxes : " . number_format($taxes, 2) . " MAD"), 0, 1, 'L');
        $pdf->Cell(0, 10, utf8_decode("Prix TTC : " . number_format($prixTTC, 2) . " MAD"), 0, 1, 'L');
        $pdf->Ln(10);

        // Dates
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->SetTextColor(44, 62, 80);
        $pdf->Cell(0, 10, utf8_decode("Dates"), 0, 1, 'L');
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->SetTextColor(52, 73, 94);
        $pdf->Cell(0, 10, utf8_decode("Date de facturation : " . date('d-m-Y', strtotime($dateFacture))), 0, 1, 'L');
        $pdf->Cell(0, 10, utf8_decode("Date limite de paiement : " . date('d-m-Y', strtotime($dateLimite))), 0, 1, 'L');
        $pdf->Ln(20);

        // Pied de page
        $pdf->SetTextColor(149, 165, 166);
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->Cell(0, 10, utf8_decode("Cette facture a été générée automatiquement."), 0, 0, 'L');
        $pdf->Cell(0, 10, utf8_decode("Merci de régler votre facture dans les délais impartis."), 0, 1, 'R');
        // Message d'accompagnement
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
        $mail->Password = '';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Configurer les paramètres de l'email
        $mail->setFrom('mohamedalhabib.fatehi@etu.uae.ac.ma', 'fatehi mohamed alhabib');
        $mail->addAddress($email);
        $mail->Subject = utf8_decode("Facture d'électricité");
        $mail->Body =  utf8_decode("Bonjour, Voici votre facture n°" . $idFacture . "  Merci de bien vouloir proceder au paiement avant la date d'echeance mentionnée ci-dessus");
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
