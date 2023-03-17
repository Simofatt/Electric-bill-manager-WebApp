<?php
session_start();
require("../commun/connexion.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

if (!isset($_SESSION['connect'])) {
    header('location: LoginAsAnAdmin.php');
    exit;
} else {
    if (isset($_GET['idReclamation'])) {
        $idReclamation = htmlspecialchars($_GET['idReclamation']);
        $_SESSION['idReclamation'] = $idReclamation;
    }



    if (isset($_POST['submit'])) {
        if (isset($_POST['message'])) {
            if (!empty($_POST['message'])) {

                $etat = "traitée";
                $message         =  htmlspecialchars($_POST['message']);
                $requete1         = $db->prepare('SELECT r.idClient, c.email ,c.fullName FROM reclamation r INNER JOIN clients c on r.idClient = c.idclient WHERE idReclamation =?');
                $requete1->execute(array($_SESSION['idReclamation']));
                $result = $requete1->fetch();
                if ($result) {
                    $idClient = $result['idClient'];
                    $email    = $result['email'];
                    $fullName = $result['fullName'];
                }
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
                $mail->addAddress($email);
                $mail->Subject = utf8_decode("Reponse à la reclamation");
                $mail->Body =  utf8_decode("Bonjour " . $fullName . "\n" . $message);



                // Envoyer l'email
                if (!$mail->send()) {
                    echo 'Erreur: ' . $mail->ErrorInfo;
                } else {

                    $requete2         = $db->prepare('UPDATE reclamation set reponse= ?, etat = ? WHERE idReclamation =?');
                    $requete2->execute(array($message, $etat,  $_SESSION['idReclamation']));
                    header('location: answerReclamation.php?success=1');
                    exit();
                }
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer reclamation</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/reclamation.css?v=<?php echo time(); ?>">
</head>

<?php require("navBarAdmin.php");
?>

<section class="home-section">
    <nav>
        <div class="sidebar-button">
            <i class='bx bx-menu sidebarBtn'></i>
            <span class="dashboard">Dashboard</span>
        </div>
        <div class="search-box">
            <input type="text" placeholder="Search">
            <i class='bx bx-search'></i>
        </div>
        <div class="profile-details">
            <a href="ClientSettings.php"> <span class="admin_name">Mohamed Fatehi</span> </a>

        </div>
    </nav>





    <div class="compose-box">
        <form method="post" action="answerReclamation.php">
            <div class="too">
                <label for="message">Message:</label><br>
                <textarea id="message" name="message" rows="10" cols="30" required></textarea><br>
            </div>
            <?php
            if (isset($_GET['success']) && $_GET['success'] == 1) {
                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success...',
                    text: 'La reclamation a bien été traitée!',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false // disable clicking outside of the alert to close it
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.replace('seeReclamations.php');
                    }
                });
            </script>";
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