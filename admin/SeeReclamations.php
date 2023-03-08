<?php
session_start();
require("../commun/connexion.php");
if (!isset($_SESSION['connect'])) {
    header('location: LoginAsAnAdmin.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> SEE RECLAMATIONS </title>
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="..\css\SeeReclamations.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<?php require("navBarAdmin.php"); ?>


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



    <div class="home-content">
        <div class="sales-boxes">
            <div class="recent-sales box">
                <div class="title">Communicate with a client</div>
                <div class="sales-details">

                    <ul class="details">
                        <li class="topic">Clients</li>
                        <?php
                        $requete = $db->prepare('SELECT * FROM  reclamation WHERE etat = "non_traitée"');
                        $requete->execute();
                        while ($result = $requete->fetch()) {
                            $idClient  = $result["idClient"];
                            $reclamation = $result['reclamation'];
                            $object = $result['sujetReclamation'];

                            $requete2 = $db->prepare('SELECT fullName FROM  clients WHERE idClient = ?');
                            $requete2->execute(array($idClient));
                            $result2 = $requete2->fetch();
                            if ($result2) {
                                $fullName = $result2['fullName'];
                            }
                        ?>
                            <li><?php echo $fullName; ?> </li>
                        <?php
                        }
                        ?>

                    </ul>
                    <ul class="details">
                        <li class="topic">Object of the message</li>
                        <?php
                        $requete = $db->prepare('SELECT sujetReclamation FROM  reclamation WHERE etat = "non_traitée"');
                        $requete->execute();
                        while ($result = $requete->fetch()) {
                            $object = $result['sujetReclamation'];
                        ?>
                            <li><?php echo $object; ?></li>
                        <?php }

                        ?>
                    </ul>
                    <ul class="details">
                        <li class="topic">Content</li>
                        <?php
                        $requete = $db->prepare('SELECT reclamation FROM reclamation WHERE etat = "non_traitée"');
                        $requete->execute();
                        while ($result = $requete->fetch()) {
                            $reclamation   = $result['reclamation'];
                        ?>
                            <li><?php echo $reclamation; ?></li>
                        <?php }

                        ?>
                    </ul>
                    <ul class="details">
                        <li class="topic">Action</li>
                        <?php
                        $requete = $db->prepare('SELECT idReclamation FROM reclamation WHERE etat = "non_traitée"');
                        $requete->execute();
                        while ($result = $requete->fetch()) {
                            $idReclamation = $result['idReclamation'];
                            echo '<li><a href="answerReclamation.php?idReclamation=' . $idReclamation . '">Reply</a></li>';
                        }
                        ?>

                    </ul>
                </div>

            </div>

        </div>
    </div>
</section>



</body>

</html>