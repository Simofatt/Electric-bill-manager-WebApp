<?php
session_start();
require("../commun/connexion.php");
if (empty($_SESSION['connect'])) {
    header('location: LoginAsAnAgent.php');
    exit;
} else {
    $idAgent   = $_SESSION['idAgent'];


    if (isset($_POST['submit'])) {

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {                                      //l'image existe et a été stockée temporairement sur le serveur
            $error = 1;
            if ($_FILES['image']['size'] <= 3000000) {                                                         //l'image fait moins de 3MO

                $informationsImage = pathinfo($_FILES['image']['name']);
                $extensionImage = $informationsImage['extension'];
                $extensionsArray = array('txt');           //extensions qu'on autorise
                $error = 2;
                if (in_array($extensionImage, $extensionsArray)) {                                            // le type de l'image correspond à ce que l'on attend, on peut alors l'envoyer sur notre serveur
                    $address = '../consommationAnnuelles/' . $idAgent . '.' . $extensionImage;
                    move_uploaded_file($_FILES['image']['tmp_name'], $address);                                // on renomme notre image avec une clé unique suivie du nom du fichier
                    $_SESSION['image'] =  $address;
                    $error = 0;
                }
            }
        }


        // initialisation des variables à une valeur par défaut


        // ouverture du fichier et lecture du contenu
        $filename = $address;
        $file = fopen($filename, 'r');
        while ($line = fgets($file)) {
            // conversion en minuscules
            $line = strtolower(trim($line));

            // traitement des lignes
            if (strpos($line, 'id client:') === 0) {
                $id_client = trim(substr($line, 10));
            } elseif (strpos($line, 'consommation:') === 0) {
                $consommation = trim(substr($line, 14));
            } elseif (strpos($line, 'id zonegeo:') === 0) {
                $id_zoneGeo = trim(substr($line, 11));
            } elseif (strpos($line, 'date saisie:') === 0) {
                $date_saisie = trim(substr($line, 12));
            }
        }
        fclose($file);

        // affichage des valeurs extraites
        echo "ID client : $id_client<br>";
        echo "Consommation : $consommation<br>";
        echo "ID zone géographique : $id_zoneGeo<br>";
        echo "Date saisie : $date_saisie<br>";
    }
}




















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
        <form class="form" method="post" action="AgentDashboard.php" enctype="multipart/form-data">

            <div class="txt-field">
                <input class="txt-css" type="file" id="firstName" name="image" placeholder="file">
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