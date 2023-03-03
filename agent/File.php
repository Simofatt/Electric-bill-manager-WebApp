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

<?php require("navBarAgent.php"); ?>




<div class="home-content">
    <div class="container">
        <form class="form" method="post" action="File.php">

            <div class="txt-field">
                <input class="txt-css" type="file" id="firstName" name="idClient" placeholder="ID CLIENT">
            </div>

            <div>
                <input id="input" type="submit" name="submit" value="Send">
            </div>

        </form>
    </div>

    <style>
        .container {
            position: relative;
            top: 150px;
        }

        #input {
            position: relative;
            top: 1px;
            left: 30px;
        }
    </style>
</div>


</div>
</section>

</body>

</html>