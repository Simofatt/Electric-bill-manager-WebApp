<?php
session_start();
require("connexion.php");

if (isset($_POST['search'])) {
  if (isset($_POST['idClient'])) {
    $_SESSION['idClient'] =  htmlspecialchars($_POST['idClient']);
  }
}


if (isset($_SESSION['idClient'])) {
  $idClient =  $_SESSION['idClient'];
  $requete  = $db->prepare('SELECT * FROM clients where idClient = ?');
  $requete->execute(array($idClient));
  while ($result = $requete->fetch()) {

    $password           = $result['motDePasse'];
    $fullName           = $result['fullName'];
    $adresse            = $result['adresse'];
    $email              = $result['email'];
    $zoneGeo            = $result['zoneGeographique'];
  }
}
if (isset($_POST['submit'])) {
  $_SESSION['formSubmitted'] = 1;
}
if (isset($_POST['submit'])) {
  if (isset($_POST['fullName'])) {
    if (!empty($_POST['fullName'])) {
      $fullName          = htmlspecialchars($_POST['fullName']);
      $requete = $db->prepare('UPDATE clients SET fullName =? WHERE idClient = ?');
      $requete->execute(array($fullName, $idClient));
    }
  }
  if (isset($_POST['adresse'])) {
    if (!empty($_POST['adresse'])) {
      $adresse        = htmlspecialchars($_POST['adresse']);
      $requete = $db->prepare('UPDATE clients SET adresse =? WHERE idClient = ?');
      $requete->execute(array($adresse, $idClient));
    }
  }
  if (isset($_POST['email'])) {
    if (!empty($_POST['email'])) {
      $email              = htmlspecialchars($_POST['email']);
      $stmt = $db->prepare("SELECT count(*) as number_email from clients where  email=?");
      $stmt->execute(array($email));

      while ($result = $stmt->fetch()) {
        if ($result['number_email'] != 0) {
          header('Location: ClientSettings.php?error=1');
          exit();
        } else {
          $requete = $db->prepare('UPDATE clients SET email = ? WHERE idClient = ?');
          $requete->execute(array($email, $idClient));
        }
      }
    }
  }
  if (isset($_POST['fullName'])) {
    if (!empty($_POST['fullName'])) {
      $fullName          = htmlspecialchars($_POST['fullName']);
      $requete = $db->prepare('UPDATE clients SET fullName =? WHERE idClient = ?');
      $requete->execute(array($fullName, $idClient));
    }
  }
  if (isset($_POST['zoneGeographique'])) {
    if (!empty($_POST['zoneGeographique'])) {
      $zoneGeo  =   htmlspecialchars($_POST['zoneGeographique']);
      $requete = $db->prepare('UPDATE clients SET zoneGeographique = ? WHERE idClient = ?');
      $requete->execute(array($zoneGeo, $idClient));
    }
  }
  if (isset($_POST['password'])) {
    if (!empty($_POST['password'])) {
      $password           = "aq1" . sha1($password . "1234") . "25";
      $requete = $db->prepare('UPDATE clients SET motDePasse= ? WHERE idClient = ?');
      $requete->execute(array($password, $idClient));
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
  <link rel="stylesheet" href="../css/settings.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/dashboard.css?v=<?php echo time(); ?>">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <title>Settings</title>
</head>

<?php require("navBarAdmin.php"); ?>
<div class="container1">
  <form class="form" method="post" action="AdminClientSettings.php">
    <div class="">
      <input class="txt-css" type="text" id="firstName" name="idClient" placeholder="ID CLIENT">
    </div>
    <div>
      <input type="submit" id="search" value="Search" name="search">
    </div>
  </form>
</div>

<?php // if (isset($_SESSION['formSubmitted'])) { 
?>
<div class="container2" id="result" style="">
  <form class=" form" method="post" action="AdminClientSettings.php">
    <div class="txt-field">
      <label for="firstName">Full name</label>
      <input class="txt-css" type="text" id="firstName" name="fullName" placeholder="<?php echo  $fullName; ?>">
    </div>
    <div class="txt-field">
      <label for="email">Email</label>
      <input class="txt-css" type="email" id="email" name="email" placeholder=" <?php echo $email; ?>">
    </div>
    <div class="txt-field">
      <label for="">Adresse</label>
      <input class="txt-css" type="text" name="adresse" placeholder="<?php echo $adresse; ?>">
    </div>
    <div class=" txt-field">
      <label for="password">Zone geographique</label>
      <input class="txt-css" type="text" id="password" name="password" placeholder="<?php echo $zoneGeo; ?>">
    </div>
    <div class="txt-field">
      <label for="password">Modify Password</label>
      <input class="txt-css" type="password" id="password" name="password" placeholder="**********">
    </div>
    <div>
      <input type="submit" name="submit" value="Enregistrer">
    </div>
  </form>
</div>
<?php
//}
?>

<script>
  // Vérifie si l'utilisateur a effectué une recherche sur la page actuelle
  if (localStorage.getItem('searched') !== 'true') {
    // Masque la deuxième partie du contenu
    document.getElementById('container2').style.display = 'none';
  }

  // Écoute les événements de soumission du formulaire
  document.addEventListener('submit', function(event) {
    // Vérifie si le formulaire a été soumis depuis la page actuelle et contient un champ de recherche
    if (event.target.closest('') && event.target.elements.search) {
      // Stocke la valeur de recherche dans le localStorage
      localStorage.setItem('searched', 'true');
    }
  });
</script>


<?php

?>

</body>
<?php

?>

</html>