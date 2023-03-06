<?php
session_start();
if (!isset($_SESSION['connect'])) {
  header('location: LoginAsAnAdmin.php');
  exit;
} else {
  require("../commun/connexion.php");

  if (isset($_POST['search'])) {
    if (isset($_POST['idClient'])) {
      $idClient =  htmlspecialchars($_POST['idClient']);
    }
  }
  if (isset($idClient)) {
    $requete  = $db->prepare('SELECT *  FROM clients where idClient = ?');
    $requete->execute(array($idClient));
    $result = $requete->fetch();
    if ($result) {

      $password           = $result['motDePasse'];
      $fullName           = $result['fullName'];
      $adresse            = $result['adresse'];
      $email              = $result['email'];
      $idZoneGeo          = $result['idZoneGeographique'];

      $requete2 = $db->prepare('SELECT nomZoneGeo FROM zonegeographique WHERE idZoneGeo = ?');
      $requete2->execute(array($idZoneGeo));
      $result2 = $requete2->fetch();
      if ($result2) {
        $nameZoneGeo = $result2['nomZoneGeo'];
      }
    }
    if (isset($idClient)) {
      $requete  = $db->prepare('SELECT count(idClient) as count FROM clients where idClient = ?');
      $requete->execute(array($idClient));
      $result = $requete->fetch();
      if ($result) {
        $verification = $result['count'];
      }
    }
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
        $nameZoneGeo = htmlspecialchars($_POST['zoneGeographique']);
        $requete2 = $db->prepare('SELECT idZoneGeo FROM zonegeographique WHERE nomZoneGeo =?');
        $requete2->execute(array($nameZoneGeo));
        $result2 = $requete2->fetch();
        if ($result2) {
          $idZoneGeo = $result2['idZoneGeo'];
          $requete = $db->prepare('UPDATE clients SET idZoneGeographique =? WHERE idClient =?');
          $requete->execute(array($idZoneGeo, $idClient));
        }
      }
    }
    if (isset($_POST['password'])) {
      if (!empty($_POST['password'])) {
        $password           = "aq1" . sha1($password . "1234") . "25";
        $requete = $db->prepare('UPDATE clients SET motDePasse= ? WHERE idClient = ?');
        $requete->execute(array($password, $idClient));
      }
    }
    header('location: AdminClientSettings.php?success=1');
    exit;
  }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
      <input class="txt-css" type="text" id="firstName" name="idClient" placeholder="ID CLIENT" style="width :250px; ">
    </div>
    <div>
      <input type="submit" id="search" value="Search" name="search" style="width :250px; ">
    </div>
  </form>
</div>

<?php if (isset($verification) && $verification != 0) {
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
      <div class="txt-field">
        <label for="Zone gerographique">Zone geographique</label>
        <select name="zoneGeographique" id="zoneGeographique" class="zone-select" required>
          <option class="zone-label"><?php echo $nameZoneGeo; ?></option>
          <option value="Anfa" name="zoneGeographique">Anfa</option>
          <option value="Maarif" name="zoneGeographique">Maarif</option>
          <option value="Derb Sultan" name="zoneGeographique">Derb Sultan</option>
          <option value="Derb Omar" name="zoneGeographique">Derb Omar</option>
          <option value="Beausejor" name="zoneGeographique">Beausejor</option>
          <option value="Oasis" name="zoneGeographique">Oasis</option>
        </select>
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
} else if (isset($verification) && $verification == 0) {
  echo "<script> 
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Client introuvable !'
    }); 
  </script>";
}
if (isset($_GET['success'])) {
  echo "<script> 
  Swal.fire({
    icon: 'success',
    title: 'Success...',
    text: 'Les informations ont bien été modifiées!',
    confirmButtonText: 'OK',
    allowOutsideClick: false // disable clicking outside of the alert to close it
  }).then((result) => {
    if (result.isConfirmed) {
      location.replace('AdminClientSettings.php') ; 
    }
  });
</script>";
}
?>



<?php

?>

</body>
<?php

?>

</html>