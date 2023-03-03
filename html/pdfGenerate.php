<?php
session_start();
require("connexion.php");
require_once('../depen/pdf/fpdf.php');

use \setasign\Fpdi\Fpdi;

if (!isset($_SESSION['connect'])) {
  header('location: loginAsAnAdmin.php');
  exit;
} else {
  $statut = 'nonValidée';
  $requete  = $db->prepare('SELECT count(*) as count  FROM facture where statut  = ?');
  $requete->execute(array($statut));
  $result = $requete->fetch();
  if ($result) {
    $count = $result['count'];
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title>Generer PDF </title>
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="..\css\facturesVerification.css?v=<?php echo time(); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<?php require("navBarAdmin.php"); ?>


<div class="home-content">
  <div class="sales-boxes">
    <div class="recent-sales box">
      <div class="title">Factures à valider </div>
      <div class="sales-details">

        <ul class="details">
          <li class="topic">Mois</li>
          <?php
          $statut = 'nonValidée';
          $requete  = $db->prepare('SELECT idFacture FROM facture where statut  = ?');
          $requete->execute(array($statut));
          while ($result = $requete->fetch()) {
            $idFacture   = $result['idFacture'];
            $requete2  = $db->prepare('SELECT * FROM facture where idFacture  = ?');
            $requete2->execute(array($idFacture));
            $result2 = $requete2->fetch();
            if ($result2) {
              $dateFacture   = $result2['dateFacture'];

          ?>
              <li> <?php echo $dateFacture; ?> </li>
          <?php }
          } ?>
        </ul>

        <ul class="details">
          <li class="topic">Consomations</li>
          <?php
          $statut = 'nonValidée';
          $requete  = $db->prepare('SELECT idFacture FROM facture where statut  = ?');
          $requete->execute(array($statut));
          while ($result = $requete->fetch()) {
            $idFacture   = $result['idFacture'];
            $requete2  = $db->prepare('SELECT * FROM facture where idFacture  = ?');
            $requete2->execute(array($idFacture));
            $result2 = $requete2->fetch();
            if ($result2) {
              $consommation = $result2['consommation'];
          ?>
              <li> <?php echo $consommation; ?> </li>
          <?php }
          } ?>
        </ul>

        <ul class="details">
          <li class="topic">Justificatifs</li>
          <?php
          $statut = 'nonValidée';
          $requete  = $db->prepare('SELECT idFacture FROM facture where statut  = ?');
          $requete->execute(array($statut));
          while ($result = $requete->fetch()) {
            $idFacture   = $result['idFacture'];
            $requete2  = $db->prepare('SELECT * FROM facture where idFacture  = ?');
            $requete2->execute(array($idFacture));
            $result2 = $requete2->fetch();
            if ($result2) {
              $justificatif = $result2['adresseImg'];
          ?>
              <?php echo  '<li> <a href="' . $justificatif . '"> Voir justificatif </a> </li>'; ?>
          <?php }
          } ?>
        </ul>

        <ul class="details">
          <li class="topic">Action</li>
          <?php
          $statut = 'nonValidée';
          $requete = $db->prepare('SELECT idFacture FROM facture where statut  = ?');
          $requete->execute(array($statut));
          while ($result = $requete->fetch()) {
            $idFacture = $result['idFacture'];
            $requete2 = $db->prepare('SELECT * FROM facture where idFacture  = ?');
            $requete2->execute(array($idFacture));
            $result2 = $requete2->fetch();
            if ($result2) {
              $idClient = $result2['idClient'];
          ?>
              <li>
                <form action="test.php?idFacture=<?php echo $idFacture; ?>" method="post">
                  <input type="submit" name="submit" value="Valider">
                </form>
              </li>
          <?php

            }
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