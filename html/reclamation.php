<?php
session_start();
require("connexion.php");
if (empty($_SESSION['connect'])) {
  header('location: loginAsAClient.php');
  exit;
} else {
  $idClient  = $_SESSION['idClient'];
}

if (!empty($_POST['subject']) && !empty($_POST['message'])) {

  $subject         = $_POST['subject'];
  $message         = $_POST['message'];

  $requete         = $db->prepare('INSERT INTO  reclamation(idClient, sujetReclamation, reclamation) VALUES (?,?,?)');
  $requete->execute(array($idClient, $subject, $message));
  header('location: reclamation.php?success=1');
  exit();
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
  <link rel="stylesheet" href="../css/dashboard.css?v=<?php echo time(); ?>">
</head>

<?php require("navBarClient.php"); ?>



<div class="compose-box">
  <form method="post" action="reclamation.php">

    <div class="to">
      <label for="subject">Subject:</label>
      <input type="text" id="subject" name="subject" required><br><br>
    </div>

    <div class="to">
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