<?php
session_start();
require("../commun/connexion.php");
require_once('../depen/pdf/fpdf.php');

use \setasign\Fpdi\Fpdi;

if (empty($_SESSION['connect'])) {
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
      $year = date("Y", strtotime($dateFacture));


      //GERER LA DIFFERENCE EN DEBUT DE CHAQUE ANNEE 
      $requete         = $db->prepare('SELECT difference ,idZoneGeographique FROM clients WHERE idClient = ?');
      $requete->execute(array($idClient));

      while ($result = $requete->fetch()) {
        $difference = $result['difference'];
        $idZoneGeo  = $result['idZoneGeographique'];
      }
      if ($difference > 0) {
        if ($consommation > $difference) {
          $consommation = $consommation - $difference;
        } else {
          $consommation = 0;
          $difference =  $difference - $consommation;

          $requete1 = $db->prepare('UPDATE consommation_annuelle SET difference = ? WHERE idClient = ? ');
          $requete1->execute($array($difference, $idClient));
        }
      } else if ($difference < 0) {
        $consommation = $consommation - $difference;
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
        $requete5         = $db->prepare('INSERT INTO  facture(idClient, consommation, prixHT, prixTTC,adresseImg, Année) VALUES (?,?,?,?,?,?)');
        $requete5->execute(array($idClient, $consommation, $prixHT, $prixTTC, $address, $year));
        $requete2          = $db->prepare('SELECT idFacture FROM facture ORDER BY idFacture DESC LIMIT 1 ');
        $requete2->execute();
        $result2 = $requete2->fetch();
        if ($result2) {
          $idFacture = $result2['idFacture'];
        }

        //AJOUT DE LA CONSOMATION DU CLIENT A LA CONSOMATION MENSULLE DE LA ZONE DONT IL FAIT PARTIE
        $requete3         = $db->prepare('SELECT consommationMensuelle FROM zonegeographique WHERE idZoneGeo =? ');
        $requete3->execute(array($idZoneGeo));
        $result3 = $requete3->fetch();
        if ($result3) {
          $sommeConsommation   =  $result3['consommationMensuelle'];
        }
        $sommeConsommation += $consommation;
        $requete4        = $db->prepare('UPDATE zonegeographique  set consommationMensuelle =?  WHERE idZoneGeo =? ');
        $requete4->execute(array($sommeConsommation, $idZoneGeo));


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
            $pdf->AddPage();
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
            $pdf->Write(10, "\t" . $idFacture . " \n");
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
            $pdfPath = 'facture' . $idClient . $idFacture . '.pdf';
            $requete7 = $db->prepare('UPDATE facture SET statut ="validée" WHERE idFacture = ?');
            $requete7->execute(array($idFacture));
            $pdf->Output('D', $pdfPath);
          }
        } else if ($consommation >= 400) {
          $requete8 = $db->prepare('UPDATE facture SET statut ="nonValidée" WHERE idFacture = ?');
          $requete8->execute(array($idFacture));
        }

        //header('location: saisieFacture.php?success=1');
        // exit();
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
    if (isset($_GET['success'])) { ?>
      <div>
        <p>Facture bien saisie !</p>
      </div>
    <?php
    } ?>
    <?php
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
</div>
</div>
</section>



</body>

</html>