<!--<?php
    /*
session_start();
require("connexion.php");
if (empty($_SESSION['connect'])) {
  header('location: login_as_an_influencer.php');
  exit;
}
if (isset($_SESSION['id_influencer'])) {
  $id_influencer  = $_SESSION['id_influencer'];
}
$requete = $db->prepare('SELECT count(*) as count, (SELECT id FROM deals ) as last_id FROM deals');
$requete->execute();
while ($result = $requete->fetch()) {
  $count = $result['count'];
  $last_id = $result['last_id'];
}
*/
    ?>
-->

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title> DASHBOARD </title>
  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../css/dashboard.css?v=<?php echo time(); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<?php require("navBarAdmin.php"); ?>



<div class="home-content">
  <div class="overview-boxes">
    <div class="box">
      <div class="right-side">
        <div class="box-topic">Facture non payées</div>
        <div class="number">40,876</div>
        <div class="indicator">
          <i class='bx bx-up-arrow-alt'></i>
          <span class="text">Up from yesterday</span>
        </div>
      </div>
      <i class='bx bx-cart-alt cart'></i>
    </div>
    <div class="box">
      <div class="right-side">
        <div class="box-topic">Nombre de zones</div>
        <div class="number">38,876</div>
        <div class="indicator">
          <i class='bx bx-up-arrow-alt'></i>
          <span class="text">Up from yesterday</span>
        </div>
      </div>
      <i class='bx bxs-cart-add cart two'></i>
    </div>
    <div class="box">
      <div class="right-side">
        <div class="box-topic">Total Consomations</div>
        <div class="number">$12,876</div>
        <div class="indicator">
          <i class='bx bx-up-arrow-alt'></i>
          <span class="text">Up from yesterday</span>
        </div>
      </div>
      <i class='bx bx-cart cart three'></i>
    </div>
    <div class="box">
      <div class="right-side">
        <div class="box-topic">Total Clients</div>
        <div class="number">11,086</div>
        <div class="indicator">
          <i class='bx bx-down-arrow-alt down'></i>
          <span class="text">Down From Today</span>
        </div>
      </div>
      <i class='bx bxs-cart-download cart four'></i>
    </div>
  </div>

  <div class="sales-boxes">
    <div class="recent-sales box">
      <div class="title">Informations synthéthiques</div>
      <div class="sales-details">
        <ul class="details">
          <li class="topic">Zones</li>
          <!-- <?php /*
          for ($i = 1; $i <= $count; $i++) {
            $requete = $db->prepare('SELECT b.name_brand, d.id_brand, b.id FROM brands as b INNER JOIN deals as d ON b.id = d.id_brand WHERE d.id_influencer = ?');
            $requete->execute(array($id_influencer));
            while ($result = $requete->fetch()) {
              $name_brand  = $result['name_brand'];
          ?>
              <li><?php echo $name_brand; ?> </li>
          <?php
            }
          }*/
                ?>-->


        </ul>
        <ul class="details">
          <li class="topic">Consomations/mois</li>
          <!--<?php /*
          for ($i = 1; $i <= $last_id; $i++) {
            $requete = $db->prepare('SELECT montant FROM deals WHERE id = ?');
            $requete->execute(array($i));
            while ($result = $requete->fetch()) {
              $amount   = $result['montant'];
          ?>
              <li><?php echo $amount; ?></li>
          <?php }
          }*/
              ?>-->



        </ul>
        <ul class="details">
          <li class="topic">Facture non payées</li>
          <!--   <?php /*
          for ($i = 1; $i <= $last_id; $i++) {
            $requete = $db->prepare('SELECT duree_contrat as duration FROM deals WHERE id = ?');
            $requete->execute(array($i));
            while ($result = $requete->fetch()) {
              $duration   = $result['duration'];
          ?>
              <li><?php echo $duration; ?></li>
          <?php }
          }*/
                  ?>-->

        </ul>



      </div>

    </div>
  </div>
  </section>



  </body>

</html>