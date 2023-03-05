<?php
require("../commun/connexion.php");
if (isset($_POST['submit'])) {
    $idZoneGeo = 2;
    $consommation = 150;
    $requete3         = $db->prepare('SELECT consommationMensuelle FROM zonegeographique WHERE idZoneGeo =? ');
    $requete3->execute(array($idZoneGeo));
    $result3 = $requete3->fetch();
    if ($result3) {
        $sommeConsommation   =  $result3['consommationMensuelle'];
    }
    $sommeConsommation += $consommation;
    $requete4        = $db->prepare('UPDATE zonegeographique  set consommationMensuelle =?  WHERE idZoneGeo =? ');
    $requete4->execute(array($sommeConsommation, $idZoneGeo));
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
    <link rel="stylesheet" href="../css/sasieFacture.css?v=<?php echo time(); ?>">
</head>

<?php require("navBarClient.php"); ?>



<div class="compose-box">
    <form method="post" action="test.php" enctype="multipart/form-data">




        <?php
        if (isset($_GET['success'])) { ?>
            <div>
                <p>Facture bien saisie !</p>
            </div>
        <?php
        } ?>
        <?php
        if (isset($error) && $error == 1) { ?>
            <div>
                <p>La taille de l'image ne doit pas dépasser 3MO !</p> <br>
            </div>
        <?php
        } else if (isset($error) && $error == 2) { ?>
            <div>
                <p>L'extension de cette image n'est pas autoriser!</p> <br>
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