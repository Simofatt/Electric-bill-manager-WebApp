<?php
session_start();
if (!isset($_SESSION['connect'])) {
    header('location: LoginAsAClient.php');
    exit;
} else {
    $idClient = $_SESSION['idClient'];
    require("../commun/connexion.php");
    $requete = $db->prepare('SELECT c.fullName  FROM facture f INNER JOIN clients as c ON f.idClient = c.idClient WHERE f.idClient = ?');
    $requete->execute(array($idClient));
    while ($result = $requete->fetch()) {
        $fullName        = $result['fullName'];
    }

    if (isset($_POST['submit']) && isset($_GET['idFacture'])) {
        $idFacture  = $_GET['idFacture'];
        $requete = $db->prepare('UPDATE facture set Etat ="Payée" WHERE idFacture= ?');
        $requete->execute(array($idFacture));
        header('location: payementFacture.php?success=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Client dashboard </title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="..\css\facturesVerification.css?v=<?php echo time(); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<?php require("navBarClient.php"); ?>


<div class="home-content">
    <div class="sales-boxes">
        <div class="recent-sales box">
            <div class="title">Factures de <?php echo $fullName; ?></div> <br><br> <br>
            <div class="sales-details">

                <ul class="details">
                    <li class="topic">Date Factures </li>
                    <?php
                    $requete = $db->prepare('SELECT dateFacture FROM facture where idClient =? AND statut = "Validée" and Etat = "nonPayée"');
                    $requete->execute(array($idClient));
                    while ($result = $requete->fetch()) {
                        $dateFacture   =   $result['dateFacture'];
                    ?>
                        <li class="data"> <?php echo  $dateFacture; ?> </li>
                    <?php
                    }

                    ?>
                </ul>

                <ul class="details">
                    <li class="topic">Consomations</li>
                    <?php
                    $requete = $db->prepare('SELECT consommation FROM facture where idClient =? AND statut = "Validée" and Etat = "nonPayée"');
                    $requete->execute(array($idClient));
                    while ($result = $requete->fetch()) {
                        $consommation  = $result['consommation'];
                    ?>
                        <li class="data"><?php echo $consommation; ?></li>
                    <?php
                    }
                    ?>
                </ul>


                <ul class="details">
                    <li class="topic">Prix HT</li>
                    <?php
                    $requete = $db->prepare('SELECT prixHT FROM facture where idClient =? AND statut = "Validée" and Etat = "nonPayée"');
                    $requete->execute(array($idClient));
                    while ($result = $requete->fetch()) {
                        $prixHT = $result['prixHT'];
                    ?>
                        <li class="data"> <?php echo $prixHT; ?></li>
                    <?php
                    }
                    ?>
                </ul>



                <ul class="details">
                    <li class="topic">Prix TTC</li>
                    <?php
                    $requete = $db->prepare('SELECT prixTTC FROM facture where idClient =? AND statut = "Validée" and Etat = "nonPayée"');
                    $requete->execute(array($idClient));
                    while ($result = $requete->fetch()) {
                        $prixTTC = $result['prixTTC'];
                    ?>
                        <li class="data"><?php echo $prixTTC; ?></li>
                    <?php
                    }
                    ?>
                </ul>


                <ul class="details">
                    <li class="topic">Action</li>
                    <?php
                    $requete = $db->prepare('SELECT idFacture FROM facture WHERE idClient = ?  AND statut = "Validée" and Etat = "nonPayée"');
                    $requete->execute(array($idClient));
                    while ($result = $requete->fetch()) {
                        $idFacture   = $result['idFacture'];
                        echo '<form action="payementFacture.php?idFacture=' . $idFacture . '" method="post">';


                        echo ' <li> <input class="payer" style =" height: 10px; " type="submit" name="submit" value="Payer"> </li>';
                        echo ' </form>';
                    }
                    ?>

                    <?php

                    if (isset($_GET['success']) && $_GET['success'] == 1) {
                        echo "<script> 
                            Swal.fire({
                            icon: 'success',
                            title: 'Success...',
                            text: 'La facture a bien été payer!',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false // disable clicking outside of the alert to close it
                            }).then((result) => {
                          
                            });
                        </script>";
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