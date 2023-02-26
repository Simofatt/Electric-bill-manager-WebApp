<?php /*
session_start();
require("connexion.php");

if ($_SESSION['connect']) {
  $id_influencer      = $_SESSION['id_influencer'];

  $stmt = $db->prepare("SELECT * FROM influencer WHERE id=?");
  $stmt->execute(array($id_influencer));
  while ($user = $stmt->fetch()) {
    $_SESSION['full_name']         = $user['full_name']; // c'est pour ca quand a fetch tout
    $_SESSION['id_influencer']     = $user['id'];
    $_SESSION['email']             = $user['email'];
    $_SESSION['phone_number']      = $user['phone_number'];
    $_SESSION['instagram_account'] = $user['instagram_account'];
  }
  $full_name          = $_SESSION['full_name'];
  $email              = $_SESSION['email'];
  $phone_number       = $_SESSION['phone_number'];
  $instagram_account  = $_SESSION['instagram_account'];
} else if (!isset($_SESSION['connect'])) {
  header('location: login_as_an_influencer.php');
}
$requete  = $db->prepare('SELECT password FROM influencer where id = ?');
$requete->execute(array($id_influencer));
while ($result = $requete->fetch()) {
  $password  = $result['password'];
}

if (!empty($_POST['submit'])) {
  if (!empty($_POST['full_name'])) {
    $full_name          = $_POST['full_name'];
    $requete = $db->prepare('UPDATE influencer SET full_name = ? WHERE id = ?');
    $requete->execute(array($full_name, $id_influencer));
  }
  if (!empty($_POST['email'])) {
    $email              = $_POST['email'];
    $stmt = $db->prepare("SELECT count(*) as number_email from influencer where  email=?  ");
    $stmt->execute(array($email));

    while ($result = $stmt->fetch()) {
      if ($result['number_email'] != 0) {
        header('Location: login_as_an_influencer.php?error=1&email=1');
        exit();
      } else {
        $requete = $db->prepare('UPDATE influencer SET email = ? WHERE id = ?');
        $requete->execute(array($email, $id_influencer));
      }
    }
  }
  if (!empty($_POST['phone_number'])) {
    $phone_number       = $_POST['phone_number'];
    $requete = $db->prepare('UPDATE influencer SET phone_number = ? WHERE id = ?');
    $requete->execute(array($phone_number, $id_influencer));
  }
  if (!empty($_POST['instagram_account'])) {
    $instagram_account    =   $_POST['instagram_account'];
    $requete = $db->prepare('UPDATE influencer SET instagram_account = ? WHERE id = ?');
    $requete->execute(array($instagram_account, $id_influencer));
  }
  if (!empty($_POST['password'])) {
    $password           = "aq1" . sha1($password . "1234") . "25";
    $requete = $db->prepare('UPDATE influencer SET password = ? WHERE id = ?');
    $requete->execute(array($password, $id_influencer));
  }

  $stmt = $db->prepare("SELECT * FROM influencer WHERE email=?");
  $stmt->execute(array($email));
  while ($user = $stmt->fetch()) {
    if ($password == $user['password']) {

      $_SESSION['full_name']         = $user['full_name']; // c'est pour ca quand a fetch tout
      $_SESSION['id_influencer']     = $user['id'];
      $_SESSION['email']             = $user['email'];
      $_SESSION['phone_number']      = $user['phone_number'];
      $_SESSION['instagram_account'] = $user['instagram_account'];
    }
  }

  header('location: profileSettings.php?success=1');
  exit();
}
*/

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
</div>
</section>



<form class="form" method="post" action="AdminClientSettings.php">
  <div class="txt-field">
    <label for="firstName">Full name</label>
    <input class="txt-css" type="text" id="firstName" name="full_name" placeholder="<?php echo  $full_name; ?>">
  </div>
  <div class="txt-field">
    <label for="email">Email</label>
    <input class="txt-css" type="email" id="email" name="email" placeholder=" <?php echo $email; ?>">
  </div>
  <div class="txt-field">
    <label for="">Adresse</label>
    <input class="txt-css" type="text" name="adresse" placeholder="<?php echo $adresse; ?>"">
      
      </div>


  <div class=" txt-field">
    <label for="password">Zone geographique</label>
    <input class="txt-css" type="text" id="password" name="password" placeholder="">
  </div>

  <div class="txt-field">
    <label for="password">Modify Password</label>
    <input class="txt-css" type="password" id="password" name="password" placeholder="**********">
  </div>


  <div>
    <input type="submit" name="submit" value="Enregistrer">
  </div>
</form>

</body>



</html>