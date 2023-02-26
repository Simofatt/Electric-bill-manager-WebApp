<?php
session_start();
require("connexion.php");
if (empty($_SESSION['connect'])) {
  header('location: loginAsAClient.php');
  exit;
} else {
  $idClient   = $_SESSION['idClient'];
}
if (!empty($_POST['consommation']) && !empty($_POST['dateFacture'])) {

  $consommation        = $_POST['consommation'];
  $dateFacture         = $_POST['dateFacture'];

  //EXTRACTION DE L'ANNEE 
  $year = date("Y", strtotime($dateFacture));


  //GERER LA DIFFERENCE EN DEBUT DE CHAQUE ANNEE 
  $requete         = $db->prepare('SELECT difference FROM clients WHERE idClient = ? ');
  $requete->execute(array($idClient));

  while ($result = $requete->fetch()) {
    $difference = $result['difference'];
  }
  if ($difference > 0) {
    if ($consommation > $difference) {
      $consommation = $consommation - $difference;
    } else {
      $consommation = 0;
      $difference =  $difference - $consommation;

      $requete = $db->prepare('UPDATE consommation_annuelle SET difference = ? WHERE idClient = ? ');
      $requete->execute($array($difference, $idClient));
    }
  } else if ($difference < 0) {
    $consommation = $consommation - $difference;
  }

  //FACTURACTION DU PRIX 
  if ($consommation <= 100) {
    $prixHT   =  $consommation * 0.91;
  } else if ($consommation <= 101 && $consommation >= 200) {
    $prixHT   =  $consommation * 1.01;
  } else if ($consommation >= 201) {
    $prixHT  = $consommation  * 1.12;
  }
  $prixTTC = $prixHT * ($prixHT * 0.14);

  //TRAITEMENT IMAGE 
  if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {  //l'image existe et a été stockée temporairement sur le serveur

    if ($_FILES['image']['size'] <= 3000000) { //l'image fait moins de 3MO

      $informationsImage = pathinfo($_FILES['image']['name']);
      $extensionImage = $informationsImage['extension'];
      $extensionsArray = array('PNG', 'png', 'gif', 'jpg', 'jpeg'); //extensions qu'on autorise

      if (in_array($extensionImage, $extensionsArray)) {  // le type de l'image correspond à ce que l'on attend, on peut alors l'envoyer sur notre serveur
        $address = '../uploads/' . $idClient . '.' . $extensionImage;
        move_uploaded_file($_FILES['image']['tmp_name'], $address); // on renomme notre image avec une clé unique suivie du nom du fichier
        $_SESSION['image'] =  $address;
      }
    }
  }







  $requete         = $db->prepare('INSERT INTO  facture(idClient, consommation, prixHT, prixTTC,@Image, Année) VALUES (?,?,?,?,?,?)');
  $requete->execute(array($idClient, $consommation, $prixHT, $prixTTC, $address, $year));
  header('location: saisieFacture.php?success=1');
  exit();
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
  <link rel="stylesheet" href="../css/dashboard.css?v=<?php echo time(); ?>">
</head>

<?php require("navBarClient.php"); ?>



<div class="compose-box">
  <<form method="post" action="saisieFacture.php">


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