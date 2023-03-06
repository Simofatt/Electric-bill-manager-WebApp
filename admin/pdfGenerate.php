<?php
session_start();
require("../commun/connexion.php");
require_once('../depen/pdf/fpdf.php');

use \setasign\Fpdi\Fpdi;

if (!isset($_SESSION['connect'])) {
  header('location: loginAsAnAdmin.php');
  exit;
} else {
  $statut = 'nonValidée';
  $requete  = $db->prepare('SELECT count(*) as count  FROM facture where statut  = ?');
  $requete->execute(array($statut));
  $result = $requete->fetch();
  if ($result) {
    $count = $result['count'];
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title>Generer PDF </title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="..\css\facturesVerification.css?v=<?php echo time(); ?>">
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
        <div class="title">Factures à valider </div>
        <div class="sales-details">

          <ul class="details">
            <li class="topic">Mois</li>
            <?php
            $statut = 'nonValidée';
            $requete  = $db->prepare('SELECT idFacture FROM facture where statut  = ?');
            $requete->execute(array($statut));
            while ($result = $requete->fetch()) {
              $idFacture   = $result['idFacture'];
              $requete2  = $db->prepare('SELECT * FROM facture where idFacture  = ?');
              $requete2->execute(array($idFacture));
              $result2 = $requete2->fetch();
              if ($result2) {
                $dateFacture   = $result2['dateFacture'];

            ?>
                <li> <?php echo $dateFacture; ?> </li>
            <?php }
            } ?>
          </ul>

          <ul class="details">
            <li class="topic">Consomations</li>
            <?php
            $statut = 'nonValidée';
            $requete  = $db->prepare('SELECT idFacture FROM facture where statut  = ?');
            $requete->execute(array($statut));
            while ($result = $requete->fetch()) {
              $idFacture   = $result['idFacture'];
              $requete2  = $db->prepare('SELECT * FROM facture where idFacture  = ?');
              $requete2->execute(array($idFacture));
              $result2 = $requete2->fetch();
              if ($result2) {
                $consommation = $result2['consommation'];
            ?>
                <li> <?php echo $consommation; ?> </li>
            <?php }
            } ?>
          </ul>

          <ul class="details">
            <li class="topic">Justificatifs</li>
            <?php
            $statut = 'nonValidée';
            $requete  = $db->prepare('SELECT idFacture FROM facture where statut  = ?');
            $requete->execute(array($statut));
            while ($result = $requete->fetch()) {
              $idFacture   = $result['idFacture'];
              $requete2  = $db->prepare('SELECT * FROM facture where idFacture  = ?');
              $requete2->execute(array($idFacture));
              $result2 = $requete2->fetch();
              if ($result2) {
                $justificatif = $result2['adresseImg'];
            ?>
                <?php echo  '<li> <a href="' . $justificatif . '"> Voir justificatif </a> </li>'; ?>
            <?php }
            } ?>
          </ul>

          <ul class="details">
            <li class="topic" style="margin-left: 60px;">Action</li>
            <?php
            $statut = 'nonValidée';
            $requete = $db->prepare('SELECT idFacture FROM facture where statut  = ?');
            $requete->execute(array($statut));
            while ($result = $requete->fetch()) {
              $idFacture = $result['idFacture'];
              $requete2 = $db->prepare('SELECT * FROM facture where idFacture  = ?');
              $requete2->execute(array($idFacture));
              $result2 = $requete2->fetch();
              if ($result2) {
                $idClient = $result2['idClient'];
            ?>
                <li>
                  <div style="display: flex; justify-content: center;">
                    <form action="test.php?idFacture=<?php echo $idFacture; ?>" method="post" style="display: flex;">
                      <input type="submit" name="submit" value="Valider" style="margin-right: 10px;">
                      <input type="submit" name="submit" value="Rectifier">
                    </form>
                  </div>

                </li>


              <?php

              }
            }

            if (isset($_GET['idFacture']) && isset($_GET['rectification'])) {
              $idFacture = $_GET['idFacture'];
              ?>
              <script>
                Swal.fire({
                  title: 'Rectifier la consommation',
                  input: 'text',
                  inputLabel: 'Consommation (en KWH)',
                  inputPlaceholder: 'Entrez la consommation ici',
                  confirmButtonText: 'Soumettre',
                  showLoaderOnConfirm: true,
                  preConfirm: (consommation) => {
                    return new Promise((resolve) => {
                      $.ajax({
                        type: "POST",
                        url: "pdfGenerate.php",
                        data: {
                          idFacture: "<?php echo $idFacture; ?>",
                          consommation: consommation
                        },
                        success: function(response) {
                          resolve(response);
                        }
                      });
                    });
                  },
                  allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                  // Do something with the response from the AJAX request
                  console.log(result);
                  Swal.fire({
                    title: 'Succès!',
                    text: 'La consommation a été mise à jour',
                    icon: 'success',
                    confirmButtonText: 'OK'
                  }).then(() => {
                    // Redirect to the same page to refresh the data
                    location.href = "pdfGenerate.php?idFacture=<?php echo $idFacture; ?>";
                  });

                })
              </script>

            <?php
            }
            if (isset($_POST['consommation'])) {
              $idFacture = $_POST['idFacture'];
              $consommation = $_POST['consommation'];

              $requete2 = $db->prepare('UPDATE  facture set consommation =?  where idFacture  = ?');
              $requete2->execute(array($consommation, $idFacture));
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