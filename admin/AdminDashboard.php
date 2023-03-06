<?php

session_start();
require("../commun/connexion.php");
if (!isset($_SESSION['connect'])) {
  header('location: LoginAsAnAdmin.php');
  exit;
} else {
  $mois = isset($_GET['mois']) ? $_GET['mois'] : date('m');
  $requete = $db->prepare('SELECT count(*) as count  FROM facture WHERE Etat = "nonPayée" AND MONTH(dateFacture) = ?');
  $requete->execute(array($mois));
  $result = $requete->fetch();
  if ($result) {
    $totalFactureNonPayée = $result['count'];
  }


  $requete2 = $db->prepare('SELECT SUM(consommation) AS consommationTotale  FROM facture WHERE MONTH(dateFacture) = ?');
  $requete2->execute(array($mois));
  $result2 = $requete2->fetch();
  if ($result2) {
    $totalConsommation = $result2['consommationTotale'];
  }

  $requete = $db->prepare('SELECT count(*) as count  FROM facture WHERE statut = "nonValidée" AND MONTH(dateFacture) = ?');
  $requete->execute(array($mois));
  $result = $requete->fetch();
  if ($result) {
    $totalFactureNonValidée = $result['count'];
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title> DASHBOARD </title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../css/dashboard.css?v=<?php echo time(); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<?php require("navBarAdmin.php"); ?>
<section class="home-section">
  <form method="get" action="AdminDashboard.php">
    <select name="mois" id="mois">
      <?php
      $moisActuel = date('m');
      for ($i = 1; $i <= 12; $i++) {
        $selected = ($i == $moisActuel) ? 'selected' : '';
        echo '<option value="' . $i . '" ' . $selected . '>' . date('F', mktime(0, 0, 0, $i, 1)) . '</option>';
      }
      ?>
    </select>
    <button type="submit">Afficher</button>
  </form>
  <div class="home-content">
    <div class="overview-boxes">
      <div class="box">
        <div class="right-side">
          <div class="box-topic">Facture non payées</div>
          <div class="number"><?php echo $totalFactureNonPayée; ?></div>
          <div class="indicator">
            <i class='bx bx-up-arrow-alt'></i>
            <span class="text">Up from yesterday</span>
          </div>
        </div>
        <i class='bx bx-cart-alt cart'></i>
      </div>

      <div class="box">
        <div class="right-side">
          <div class="box-topic"> Total Consommations</div>
          <div class="number"> <?php echo $totalConsommation; ?></div>
          <div class="indicator">
            <i class='bx bx-up-arrow-alt'></i>
            <span class="text">Up from yesterday</span>
          </div>
        </div>
        <i class='bx bx-cart-alt cart'></i>
      </div>



      <div class="box">
        <div class="right-side">
          <div class="box-topic">Facture non validée</div>
          <div class="number"> <?php echo $totalFactureNonValidée; ?></div>
          <div class="indicator">
            <i class='bx bx-up-arrow-alt'></i>
            <span class="text">Up from yesterday</span>
          </div>
        </div>
        <i class='bx bx-cart-alt cart'></i>
      </div>


    </div>

    <div class="sales-boxes">
      <div class="recent-sales box">
        <div class="title">Informations synthéthiques</div>
        <div class="sales-details">
          <canvas id="myChart" style="height: 300px;"></canvas>
          <style>

          </style>
          <ul class="details">
            <script>
              // Récupérer l'élément canvas
              var ctx = document.getElementById('myChart').getContext('2d');
              // Créer le graphique
              var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                  labels: [<?php
                            $requete = $db->prepare('SELECT nomZoneGeo FROM zoneGeographique');
                            $requete->execute();
                            $labels = array();
                            while ($result = $requete->fetch()) {
                              $labels[] = '"' . $result['nomZoneGeo'] . '"';
                            }
                            echo implode(',', $labels);
                            ?>],
                  datasets: [{
                    label: 'Consommation',
                    data: [<?php
                            $mois = isset($_GET['mois']) ? $_GET['mois'] : date('m');
                            $annee = date('Y');
                            $requete = $db->prepare('SELECT SUM(f.consommation) AS consommationTotale FROM clients c JOIN facture f ON c.idClient = f.idClient WHERE MONTH(f.dateFacture) = ? AND YEAR(f.dateFacture) = ? GROUP BY c.idZoneGeographique');
                            $requete->execute(array($mois, $annee));
                            $data = array();
                            while ($result = $requete->fetch()) {
                              $data[] = $result['consommationTotale'];
                            }
                            echo implode(',', $data);
                            ?>],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                  }]
                },
                options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  scales: {
                    yAxes: [{
                      ticks: {
                        beginAtZero: true
                      }
                    }]
                  },
                  layout: {
                    padding: {
                      left: 50,
                      right: 50,
                      top: 0,
                      bottom: 0
                    }

                  }
                }
              });
            </script>
        </div>
      </div>
    </div>
</section>
</body>

</html>