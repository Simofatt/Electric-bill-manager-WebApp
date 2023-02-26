<?php
session_start();
require("connexion.php");

if ($_SESSION['connect']) {
  $idClient           = $_SESSION['idClient'];
  $fullName           = $_SESSION['fullName'];
  $adresse           = $_SESSION['adresse'];
  $email              = $_SESSION['email'];
  $zoneGeo            = $_SESSION['zoneGeo'];
} else if (!isset($_SESSION['connect'])) {
  header('location: loginAsAClient.php');
}

$requete  = $db->prepare('SELECT motDePasse FROM clients where idClient = ?');
$requete->execute(array($idClient));
while ($result = $requete->fetch()) {
  $password  = $result['motDePasse'];
}

if (!empty($_POST['submit'])) {
  if (!empty($_POST['fullName'])) {
    $fullName          = $_POST['fullName'];
    $requete = $db->prepare('UPDATE clients SET fullName =? WHERE idClient = ?');
    $requete->execute(array($fullName, $idClient));
  }
  if (!empty($_POST['adresse'])) {
    $adresse        = $_POST['adresse'];
    $requete = $db->prepare('UPDATE clients SET adresse =? WHERE idClient = ?');
    $requete->execute(array($adresse, $idClient));
  }
  if (!empty($_POST['email'])) {
    $email              = $_POST['email'];
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

  if (!empty($_POST['fullName'])) {
    $fullName          = $_POST['fullName'];
    $requete = $db->prepare('UPDATE clients SET fullName =? WHERE idClient = ?');
    $requete->execute(array($fullName, $idClient));
  }

  if (!empty($_POST['zoneGeographique'])) {
    $zoneGeo  =   $_POST['zoneGeographique'];
    $requete = $db->prepare('UPDATE clients SET zoneGeographique = ? WHERE idClient = ?');
    $requete->execute(array($zoneGeo, $idClient));
  }
  if (!empty($_POST['password'])) {
    $password           = "aq1" . sha1($password . "1234") . "25";
    $requete = $db->prepare('UPDATE clients SET motDePasse= ? WHERE idClient = ?');
    $requete->execute(array($password, $idClient));
  }
  $_SESSION['adresse']          = $adresse;
  $_SESSION['fullName']           = $fullName;
  $_SESSION['idClient']          = $idClient;
  $_SESSION['email']             = $email;
  $_SESSION['zoneGeo']           = $zoneGeo;

  header('location: ClientSettings.php?success=1');
  exit();
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
<?php require("navBarClient.php"); ?>
</div>
</section>



<form class="form" method="post" action="ClientSettings.php">
  <div class="txt-field">
    <label for="firstName">Full name</label>
    <input class="txt-css" type="text" idClient="firstName" name="fullName" placeholder="<?php echo  $fullName; ?>">
  </div>
  <div class="txt-field">
    <label for="email">Email</label>
    <input class="txt-css" type="email" idClient="email" name="email" placeholder=" <?php echo $email; ?>">
  </div>

  <div class="txt-field">
    <label for="">Adresse</label>
    <input class="txt-css" type="text" name="adresse" placeholder="<?php echo $adresse; ?>"">
       
      </div>

  <div class=" txt-field">
    <label for="password">Zone geographique</label>
    <input class="txt-css" type="text" idClient="password" name="zoneGeographique" placeholder="<?php echo $zoneGeo; ?>">
  </div>

  <div class="txt-field">
    <label for="password">Modify Password</label>
    <input class="txt-css" type="password" idClient="password" name="password" placeholder="**********">
  </div>
  <?php
  if (isset($_GET['error'])) { ?>
    <div>
      <p>Email Existe deja!</p>
    </div>
  <?php
  }
  ?>

  <div>
    <input type="submit" name="submit" value="Enregistrer">
  </div>
</form>

</body>



</html>