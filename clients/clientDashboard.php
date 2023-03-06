<?php
session_start();
if (!isset($_SESSION['connect'])) {
  header('location: LoginAsAClient.php');
  exit;
} else {
  $idClient = $_SESSION['idClient'];
  require("../commun/connexion.php");
  $requete = $db->prepare('SELECT count(*) as count, c.fullName  FROM facture f INNER JOIN clients as c ON f.idClient = c.idClient WHERE f.idClient = ?');
  $requete->execute(array($idClient));
  while ($result = $requete->fetch()) {
    $fullName        = $result['fullName'];
    $nbreFactures    = $result['count'];
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title>Client dashboard </title>
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="..\css\facturesVerification.css?v=<?php echo time(); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<?php require("navBarClient.php"); ?>


<div class="home-content">
  <div class="sales-boxes">
    <div class="recent-sales box">
      <div class="title">Factures de <?php echo $fullName; ?></div> <br>
      <div class="sales-details">

        <ul class="details">
          <li class="topic">Date Factures </li>
          <?php
          $annee = date('Y');
          $requete = $db->prepare('SELECT dateFacture FROM facture where idClient =? AND Année =?');
          $requete->execute(array($idClient, $annee));
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

          $requete = $db->prepare('SELECT consommation FROM facture where idClient =?  AND Année =?');
          $requete->execute(array($idClient, $annee));
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

          $requete = $db->prepare('SELECT Etat FROM facture where idClient =? AND Année =?');
          $requete->execute(array($idClient, $annee));
          while ($result = $requete->fetch()) {
            $etat  = $result['Etat'];
          ?>
            <li><?php echo $etat; ?></li>
          <?php
          }
          ?>
        </ul>


        <ul class="details">
          <li class="topic">Justificatifs</li>
          <?php

          $requete = $db->prepare('SELECT adresseImg FROM facture WHERE idClient = ?  AND Année =?');
          $requete->execute(array($idClient, $annee));
          while ($result = $requete->fetch()) {
            $adresseImg   = $result['adresseImg'];
            echo  '<li> <a href="' . $adresseImg . '"> Voir justificatif </a> </li>';
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