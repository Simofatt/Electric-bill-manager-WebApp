<?php
require("../commun/connexion.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
if (isset($_POST['submit'])) {
    // Inclure la librairie PHPMailer


    // Créer une nouvelle instance de PHPMailer
    $mail = new PHPMailer(true);

    // Configurer les paramètres du serveur SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'mohamedalhabib.fatehi@etu.uae.ac.ma';
    $mail->Password = 'med@widadi01';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Configurer les paramètres de l'email
    $mail->setFrom('mohamedalhabib.fatehi@etu.uae.ac.ma', 'fatehi mohamed alhabib');
    $mail->addAddress('simosins78@gmail.com');
    $mail->Subject = 'Sujet de l\'email';
    $mail->Body = 'Contenu de l\'email';

    // Envoyer l'email
    if (!$mail->send()) {
        echo 'Erreur: ' . $mail->ErrorInfo;
    } else {
        echo 'Email envoyé';
    }
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