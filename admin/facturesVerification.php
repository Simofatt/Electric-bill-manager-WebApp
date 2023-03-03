<?php
session_start();
require("../commun/connexion.php");

if (!isset($_SESSION['connect'])) {
  header('location: loginAsAnAdmin.php');
  exit;
} else {
  if (isset($_POST['submit'])) {
    if (isset($_POST['idClient'])) {
      $idClient =  htmlspecialchars($_POST['idClient']);
      header('location: facturesVerification.php?idClient=' . $idClient . '');
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title>Verification factures </title>
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="..\css\facturesVerification.css?v=<?php echo time(); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<?php require("navBarAdmin.php"); ?>




<div class="home-content">
  <div class="container">
    <form class="form" method="post" action="facturesVerification.php">

      <div class="txt-field">
        <input class="txt-css" type="text" id="firstName" name="idClient" placeholder="ID CLIENT">
      </div>

      <div>
        <input type="submit" name="submit" value="Search">
      </div>

    </form>
  </div>
  <div class="sales-boxes">

    <?php
    if (isset($_GET['idClient'])) {
      $idClient =  $_GET['idClient'];
      $requete  = $db->prepare('SELECT fullName,zoneGeographique FROM clients where idClient = ?');
      $requete->execute(array($idClient));
      while ($result = $requete->fetch()) {
        $fullName  = $result['fullName'];
        $zoneGeo   = $result['zoneGeographique'];
      }
    ?>

      <div class="recent-sales box">
        <div class="title">Factures de <?php echo $fullName; ?></div>
        <div class="sales-details">


          <ul class="details">
            <li class="topic">Date Factures </li>
            <?php
            $requete = $db->prepare('SELECT dateFacture FROM facture where idClient =?');
            $requete->execute(array($idClient));
            while ($result = $requete->fetch()) {
              $dateFacture   =   $result['dateFacture'];

            ?>
              <li> <?php echo  $dateFacture; ?> </li>
            <?php
            }

            ?>
          </ul>

          <ul class="details">
            <li class="topic">Consomations</li>
            <?php
            $requete = $db->prepare('SELECT consommation FROM facture where idClient =?');
            $requete->execute(array($idClient));
            while ($result = $requete->fetch()) {
              $consommation  = $result['consommation'];

            ?>
              <li><?php echo $consommation; ?></li>
            <?php
            }

            ?>
          </ul>

          <ul class="details">
            <li class="topic">Etat</li>
            <?php
            $requete = $db->prepare('SELECT Etat FROM facture WHERE idClient = ? ');
            $requete->execute(array($idClient));
            while ($result = $requete->fetch()) {
              $etatFacture = $result['Etat'];
            ?>
              <li><?php echo $etatFacture; ?></li>
            <?php
            }

            ?>
          </ul>

          <ul class="details">
            <li class="topic">Justificatifs</li>
          <?php
          $requete = $db->prepare('SELECT adresseImg FROM facture WHERE idClient = ? ');
          $requete->execute(array($idClient));
          while ($result = $requete->fetch()) {
            $adresseImg   = $result['adresseImg'];
            echo  '<li> <a href="' . $adresseImg . '"> Voir justificatif </a> </li>';
          }
        } else {
          //ALERT
        }
          ?>
          </ul>
        </div>
      </div>
  </div>
</div>
</section>

</body>

</html>