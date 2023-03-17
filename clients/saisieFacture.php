<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../commun/connexion.php");
require_once('../depen/pdf/fpdf.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

use \setasign\Fpdi\Fpdi;

if (!isset($_SESSION['connect'])) {
  header('location: LoginAsAClient.php');
  exit;
} else {
  $idClient   = $_SESSION['idClient'];
}
if (isset($_POST['submit'])) {
  if (isset($_POST['consommation']) && isset($_POST['dateFacture'])) {
    if (!empty($_POST['consommation']) && !empty($_POST['dateFacture'])) {

      $consommation        = htmlspecialchars($_POST['consommation']);
      $dateFacture         = htmlspecialchars($_POST['dateFacture']);

      //EXTRACTION DE L'ANNEE 
      $dateFacture = date("y-m-d", strtotime($dateFacture));

      //GERER LA DIFFERENCE EN DEBUT DE CHAQUE ANNEE 
      $requete         = $db->prepare('SELECT difference FROM consommation_annuelle WHERE idClient = ?');
      $requete->execute(array($idClient));
      while ($result = $requete->fetch()) {
        $difference = $result['difference'];
      }
      if (isset($difference)) {
        if ($difference > 0) {
          if ($consommation >= $difference) {
            $consommation = $consommation - $difference;
            $difference =  0;
          } else {
            $difference =  $difference - $consommation;
            $consommation = 0;
          }
        } else if ($difference < 0) {
          $consommation = $consommation - $difference;
          $difference = 0;
        }
        $requete15 = $db->prepare('UPDATE consommation_annuelle SET difference =? WHERE idClient = ? ');
        $requete15->execute(array($difference, $idClient));
      }

      //FACTURACTION DU PRIX 
      if ($consommation <= 100) {
        $prixHT   =  $consommation * 0.91;
      } else if ($consommation >= 101 && $consommation <= 200) {
        $prixHT   =  $consommation * 1.01;
      } else if ($consommation >= 201) {
        $prixHT  = $consommation  * 1.12;
      }
      $prixTTC = $prixHT + ($prixHT * 0.14);


      //TRAITEMENT IMAGE 
      if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {                                      //l'image existe et a été stockée temporairement sur le serveur
        $error = 1;
        if ($_FILES['image']['size'] <= 3000000) {                                                         //l'image fait moins de 3MO

          $informationsImage = pathinfo($_FILES['image']['name']);
          $extensionImage = $informationsImage['extension'];
          $extensionsArray = array('PNG', 'png', 'gif', 'jpg', 'jpeg', 'GIF', 'JPG ', 'JPEG');           //extensions qu'on autorise
          $error = 2;
          if (in_array($extensionImage, $extensionsArray)) {                                            // le type de l'image correspond à ce que l'on attend, on peut alors l'envoyer sur notre serveur
            $address = '../uploads/' . $idClient . time() . rand() . '.' . $extensionImage;
            move_uploaded_file($_FILES['image']['tmp_name'], $address);                                // on renomme notre image avec une clé unique suivie du nom du fichier
            $_SESSION['image'] =  $address;
            $error = 0;
          }
        }
      }


      //INSERTION DES INFOS DANS LA TABLE FACTURE
      if ($error == 0) {
        $requete5         = $db->prepare('INSERT INTO  facture(idClient, consommation,dateFacture, prixHT, prixTTC,adresseImg) VALUES (?,?,?,?,?,?)');
        $requete5->execute(array($idClient, $consommation, $dateFacture, $prixHT, $prixTTC, $address,));
        $requete2          = $db->prepare('SELECT idFacture FROM facture ORDER BY idFacture DESC LIMIT 1 ');
        $requete2->execute();
        $result2 = $requete2->fetch();
        if ($result2) {
          $idFacture = $result2['idFacture'];
        }


        //GENERER FACTURE CLIENT SI SA CONSOMMATION < 400 
        ob_start();
        if ($consommation < 400) {
          if (isset($_POST['submit'])) {
            $requete6 = $db->prepare('SELECT * FROM clients where idClient = ?');
            $requete6->execute(array($idClient));
            $result6 = $requete6->fetch();
            if ($result6) {
              $fullName = $result6['fullName'];
              $email = $result6['email'];
              $adresse = $result6['adresse'];
            }
            $taxes = $prixTTC - $prixHT;
            $dateEcheance = date('d-m-Y', strtotime($dateFacture . ' +30 days'));
            //$imagePath = "Logo.png";
            //$imagePath2 = $address;
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
            $mail->Password = 'med@widadi01';
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

              header('location: saisieFacture.php?success=1');
              exit();
            }
          }
        } else if ($consommation >= 400) {
          $requete8 = $db->prepare('UPDATE facture SET statut ="nonValidée" WHERE idFacture = ?');
          $requete8->execute(array($idFacture));
          header('location: saisieFacture.php?wait=1');
          exit();
        }
      }
    }
  }
}



?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Saisie d'une facture </title>
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../css/sasieFacture.css?v=<?php echo time(); ?>">
</head>

<?php require("navBarClient.php"); ?>



<div class="compose-box">
  <form method="post" action="saisieFacture.php" enctype="multipart/form-data">


    <div class="to">
      <label for="subject">Consommation en KWH : </label><br>
      <input type="text" id="subject" name="consommation" required><br>
    </div>

    <div class="to">
      <label for="message">Date de la Facture :</label><br>
      <input type="date" name="dateFacture" required><br><br>
    </div>

    <div class="to">
      <label for="subject"> Justificatif : </label><br><br>
      <input type="file" id="subject" name="image" required><br><br><br><br>
    </div>


    <?php
    if (isset($_GET['success']) && $_GET['success'] == 1) {
      echo "<script> 
      Swal.fire({
        icon: 'success',
        title: 'Success...',
        text: 'La facture a bien été saisie, veuilez verifier votre email!',
        confirmButtonText: 'OK',
        allowOutsideClick: false // disable clicking outside of the alert to close it
      }).then((result) => {
        if (result.isConfirmed) {
          location.replace('saisieFacture.php') ; 
        }
      });
    </script>";
    }

    if (isset($error) && $error == 1) { ?>
      <div>
        <p>La taille de l'image ne doit pas dépasser 3MO !</p> <br>
      </div>
    <?php
    } else if (isset($error) && $error == 2) { ?>
      <div>
        <p>L'extension de cette image n'est pas autoriser!</p> <br>
      </div>

    <?php
    }
    ?>
    <div class="sub">
      <input type="submit" name="submit" value="Send">
    </div>
  </form>
  <?php
  if (isset($_GET['wait']) && $_GET['wait'] == 1) {
    echo "<script> 
    Swal.fire({
      icon: 'success',
      title: 'Success...',
      text: 'La facture a bien été saisie, en attente de la confirmation !',
      confirmButtonText: 'OK',
      allowOutsideClick: false // disable clicking outside of the alert to close it
    }).then((result) => {
      if (result.isConfirmed) {
        location.replace('saisieFacture.php') ; 
      }
    });
  </script>";
  }
  ?>
</div>
</div>
</section>



</body>

</html>