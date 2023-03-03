<?php
session_start();
require("../commun/connexion.php");
if (!isset($_SESSION['connect'])) {
    header('location: loginAsAnAdmin.php');
    exit;
} else {
    if (isset($_GET['idReclamation'])) {
        $idReclamation = $_GET['idReclamation'];
        echo $idReclamation;
        $_SESSION['idReclamation'] = $idReclamation;
    }



    if (isset($_POST['submit'])) {
        if (isset($_POST['message'])) {
            if (!empty($_POST['message'])) {
                $etat = "traitée";
                $message         =  htmlspecialchars($_POST['message']);
                $requete         = $db->prepare('UPDATE reclamation set reponse= ?, etat = ? WHERE idReclamation =?');
                $requete->execute(array($message, $etat,  $_SESSION['idReclamation']));
                header('location: answerReclamation.php?success=1');
                exit();
            }
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
    <title>Answer reclamation</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/reclamation.css?v=<?php echo time(); ?>">
</head>

<?php require("navBarAdmin.php"); ?>



<div class="compose-box">
    <form method="post" action="answerReclamation.php">
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