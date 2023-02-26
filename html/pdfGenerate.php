<?php /*
if (empty($_SESSION['connect'])) {
  header('location: login_as_an_influencer.php');
  exit;
}
require("connexion.php");
$requete = $db->prepare('SELECT count(*) as nbre_brands FROM brands ');
$requete->execute();
while ($result = $requete->fetch()) {
  $nbre_brands = $result['nbre_brands'];
}*/
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
      <div class="title">Factures de .....</div>
      <div class="sales-details">

        <ul class="details">
          <li class="topic">Mois</li>
          <?php /*for ($i = 1; $i <= $nbre_brands; $i++) {
            $requete = $db->prepare('SELECT name_brand FROM brands where id =?');
            $requete->execute(array($i));
            while ($result = $requete->fetch()) {
              $name_brand = $result['name_brand'];

          ?>
              <li> <?php echo  $name_brand; ?> </li>
          <?php
            }
          }*/
          ?>
        </ul>

        <ul class="details">
          <li class="topic">Consomations</li>
          <?php /*for ($i = 1; $i <= $nbre_brands; $i++) {
            $requete = $db->prepare('SELECT instagram_account FROM brands where id =?');
            $requete->execute(array($i));
            while ($result = $requete->fetch()) {

              $instagram_account = $result['instagram_account'];
          ?>
              <li><?php echo $instagram_account; ?></li>
          <?php
            }
          }*/
          ?>
        </ul>

        <ul class="details">
          <li class="topic">Justificatifs</li>
          <?php /*

          $requete = $db->prepare('SELECT id FROM brands');
          $requete->execute();

          while ($result = $requete->fetch()) {
            $id_brand    = $result['id'];

            echo  '<li> <a href="msg.php?id_brand=' . $id_brand . '"> Sent a message </a> </li>';
          }
*/
          ?>
        </ul>

        <ul class="details">
          <li class="topic">Action</li>
          <?php /*

          $requete = $db->prepare('SELECT id FROM brands');
          $requete->execute();

          while ($result = $requete->fetch()) {
            $id_brand    = $result['id'];

            echo  '<li> <a href="msg.php?id_brand=' . $id_brand . '"> Sent a message </a> </li>';
          }
*/
          ?>


        </ul>

      </div>

    </div>

  </div>
</div>
</section>

</body>

</html>