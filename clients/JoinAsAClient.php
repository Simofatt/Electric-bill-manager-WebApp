<?php

require("../commun/connexion.php");
if (isset($_POST['submit'])) {
  if (isset($_POST['fullName']) && isset($_POST['email'])  && isset($_POST['password']) && isset($_POST['zoneGeographique'])  && isset($_POST['passwordConfirm']) && isset($_POST['adresse'])) {
    if (!empty($_POST['fullName']) && !empty($_POST['email'])  && !empty($_POST['password']) && !empty($_POST['zoneGeographique'])  && !empty($_POST['passwordConfirm']) && !empty($_POST['adresse'])) {
      $fullName            = htmlspecialchars($_POST['fullName']);
      $email               = htmlspecialchars($_POST['email']);
      $adresse             = htmlspecialchars($_POST['adresse']);
      $nameZoneGeo         = htmlspecialchars($_POST['zoneGeographique']);
      $password            = htmlspecialchars($_POST['password']);
      $passwordConfirm     = htmlspecialchars($_POST['passwordConfirm']);
      //CHECK IF PASSWORDS ARE THE SAME
      if ($password != $passwordConfirm) {
        header('Location: joinAsAClient.php?error=1&pass=1');
        exit();
      }
      //CHECK IF THE EMAIL IS ALREADY USED 
      $stmt = $db->prepare("SELECT count(*) AS number_email FROM clients WHERE email=?");
      $stmt->execute(array($email));
      while ($user = $stmt->fetch()) {
        if ($user['number_email'] != 0) {
          header('Location: joinAsAClientphp?error=1&email=1');
          exit();
        }
      }

      //HASH PSSWD 
      $password = "aq1" . sha1($password . "1234") . "25";    //aq1 et 1234 25 sont des grain de sels

      //HASH 
      $secret = sha1($email) . time();
      $secret = sha1($secret) . time() . time();

      //zoneGeo 

      $requete = $db->prepare('SELECT idZoneGeo from zonegeographique WHERE nomZoneGeo =?');
      $requete->execute(array($nameZoneGeo));
      $result = $requete->fetch();
      if ($result) {
        $idZoneGeo  = $result['idZoneGeo'];
      }

      //SENT DATA
      $stmt = $db->prepare('INSERT INTO clients(fullName, email,adresse,idZoneGeographique, motDePasse, secret) VALUES(?,?,?,?,?,?)') or die(print_r($db->errorInfo()));
      $stmt->execute(array($fullName, $email, $adresse, $idZoneGeo, $password, $secret));

      header('location: loginAsAClient.php?success=1');
      exit();
    }
  }
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>JoinAsAClient</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Square+Peg&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/joinAsAClient.css?v=<?php echo time(); ?>">
</head>

<body>
  <nav>
    <a href="../commun/index.php">
      <h2 class="logo">L'Y<span>DEC</span></h2>
    </a>
  </nav>
  <div class="title">
    <h2>Sign in to L'Y<span>DEC</span> </h2>
  </div>
  <div class="container">
    <form method="post" action="JoinAsAClient.php">
      <div class="txt-field">
        <input class="txt-css" type="text" name="fullName" required>
        <label>Nom Complet</label>
      </div>
      <div class="txt-field">
        <input class="txt-css" type="email" name="email" required>
        <label for=""> Email</label>
      </div>
      <div class="txt-field">
        <input class="txt-css" type="text" name="adresse" required>
        <label for="">Adresse</label>
      </div>
      <div class="txt-field">
        <select name="zoneGeographique" id="zoneGeographique" class="zone-select" required>
          <option class="zone-label">Zone géographique</option>
          <option value="anfa" name="zoneGeographique">Anfa</option>
          <option value="maarif" name="zoneGeographique">Maarif</option>
          <option value="derbSultan" name="zoneGeographique">Derb Sultan</option>
          <option value="derbOmar" name="zoneGeographique">Derb Omar</option>
          <option value="beausejor" name="zoneGeographique">Beausejor</option>
          <option value="oasis" name="zoneGeographique">Oasis</option>
        </select>
      </div>
      <div class="txt-field">
        <input class="txt-css" type="password" name="password" required>
        <label for="">Password</label>
      </div>
      <div class="txt-field">
        <input class="txt-css" type="password" name="passwordConfirm" required>
        <label for="">Re-enter Password</label>
      </div>
      <?php
      if (isset($_GET['error'])) {
        if (isset($_GET['pass'])) { ?>
          <div id="error">
            <p>Les mots de passe ne sont pas identiques!</p>
          </div>
        <?php
        }
        if (isset($_GET['email'])) {
        ?>
          <div id="error">
            <p>L'email deja utilises!</p>
          </div>
      <?php }
      } ?>

      <div>
        <input class="sign-in-btn" type="submit" name="submit" value="Sign in">
      </div>

    </form>
  </div>
</body>

</html>