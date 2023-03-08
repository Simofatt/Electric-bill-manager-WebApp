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
  if (isset($_GET['idClient'])) {
    $idClient = $_GET['idClient'];
    $requete  = $db->prepare('SELECT count(idClient) as count FROM clients where idClient = ?');
    $requete->execute(array($idClient));
    $result = $requete->fetch();
    if ($result) {
      $verification = $result['count'];
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title>Verification factures </title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="..\css\facturesVerification.css?v=<?php echo time(); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<?php require("navBarAdmin.php"); ?>

<section class="home-section">
  <nav>
    <div class="sidebar-button">
      <i class='bx bx-menu sidebarBtn'></i>
      <span class="dashboard">Dashboard</span>
    </div>
    <div class="search-box">
      <input type="text" placeholder="Search">
      <i class='bx bx-search'></i>
    </div>
    <div class="profile-details">
      <span class="admin_name">Mohamed Fate</span>
      <img src="../images/img4.png" alt="Simo" style="width:40%; height:100%; position : relative; left : 15px;">
    </div>
  </nav>

  <div class="home-content">
    <div class="container">
      <form class="form" method="post" action="facturesVerification.php">

        <div class="txt-field">
          <input class="txt-css" type="text" id="firstName" name="idClient" placeholder="ID CLIENT">
        </div>

        <div>
          <input style=" overflow: hidden;" type="submit" name="submit" value="Search">
        </div>

      </form>
    </div>
    <div class="sales-boxes">

      <?php
      if (isset($verification) && $verification != 0) {
        $idClient =  $_GET['idClient'];
        $requete  = $db->prepare('SELECT fullName,idZoneGeographique FROM clients where idClient = ?');
        $requete->execute(array($idClient));
        while ($result = $requete->fetch()) {
          $fullName  = $result['fullName'];
          $zoneGeo   = $result['idZoneGeographique'];
        }
      ?>

        <div class="recent-sales box">
          <div class="title">Factures de <?php echo $fullName; ?></div>
          <div class="sales-details">
            <ul class="details">
              <li class="topic">Date Factures </li>
              <?php
              $requete = $db->prepare('SELECT dateFacture FROM facture where idClient =? order by dateFacture ');
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
              $requete = $db->prepare('SELECT consommation FROM facture where idClient =? order by dateFacture');
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
              $requete = $db->prepare('SELECT Etat FROM facture WHERE idClient = ? order by dateFacture ');
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
            $requete = $db->prepare('SELECT adresseImg FROM facture WHERE idClient = ? order by dateFacture');
            $requete->execute(array($idClient));
            while ($result = $requete->fetch()) {
              $adresseImg   = $result['adresseImg'];
              echo  '<li> <a style="font-size : 15px;"href="' . $adresseImg . '"> Voir justificatif </a> </li>';
            }
          } else if (isset($verification) && $verification == 0) {
            echo "<script> 
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Client introuvable !'
              }); 
            </script>";
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