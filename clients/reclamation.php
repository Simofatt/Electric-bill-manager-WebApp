<?php
session_start();
require("../commun/connexion.php");
if (!isset($_SESSION['connect'])) {
  header('location: loginAsAClient.php');
  exit;
} else {
  $idClient  = $_SESSION['idClient'];
}
if (isset($_POST['submit'])) {
  if (isset($_POST['subject']) && isset($_POST['message'])) {
    if (!empty($_POST['subject']) && !empty($_POST['message'])) {

      $subject         =  htmlspecialchars($_POST['subject']);
      $message         =  htmlspecialchars($_POST['message']);

      $requete         = $db->prepare('INSERT INTO  reclamation(idClient, sujetReclamation, reclamation) VALUES (?,?,?)');
      $requete->execute(array($idClient, $subject, $message));
      header('location: reclamation.php?success=1');
      exit();
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
  <title>Message</title>
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../css/reclamation.css?v=<?php echo time(); ?>">
</head>

<?php require("navBarClient.php"); ?>



<div class="compose-box">
  <form method="post" action="reclamation.php">

    <div class="too">
      <label for="subject">Subject:</label> <br>
      <select id="subject" name="subject" required>
        <option class="zone-label"></option>
        <option class="zone-label">Fuite externe/interne</option>
        <option value="anfa" name="zoneGeographique">Facture</option>
        <option value="maarif" name="zoneGeographique">Autre</option>

      </select>
      <br>

    </div>

    <div class="too">
      <label for="message">Message:</label><br>
      <textarea id="message" name="message" rows="10" cols="30" required></textarea><br>
    </div>
    <?php
    if (isset($_GET['success'])) { ?>
      <div>
        <p>La reclamation a bien eté envoyée!</p><br>
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