<?php
/*
session_start();
require("connexion.php");
if (!isset($_SESSION['connect'])) {
  header('location: LoginAsAnAdmin.php');
  exit;
}
if (isset($_SESSION['id_influencer'])) {
  $id_influencer  = $_SESSION['id_influencer'];
}
$requete = $db->prepare('SELECT count(*) as count, (SELECT id FROM deals ) as last_id FROM deals');
$requete->execute();
while ($result = $requete->fetch()) {
  $count = $result['count'];
  $last_id = $result['last_id'];
}*/

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



<div class="home-content">
  <div class="overview-boxes">
    <div class="box">
      <div class="right-side">
        <div class="box-topic">Facture non payées</div>
        <div class="number">40,876</div>
        <div class="indicator">
          <i class='bx bx-up-arrow-alt'></i>
          <span class="text">Up from yesterday</span>
        </div>
      </div>
      <i class='bx bx-cart-alt cart'></i>
    </div>
    <div class="box">
      <div class="right-side">
        <div class="box-topic">Nombre de zones</div>
        <div class="number">38,876</div>
        <div class="indicator">
          <i class='bx bx-up-arrow-alt'></i>
          <span class="text">Up from yesterday</span>
        </div>
      </div>
      <i class='bx bxs-cart-add cart two'></i>
    </div>
    <div class="box">
      <div class="right-side">
        <div class="box-topic">Total Consomations</div>
        <div class="number">$12,876</div>
        <div class="indicator">
          <i class='bx bx-up-arrow-alt'></i>
          <span class="text">Up from yesterday</span>
        </div>
      </div>
      <i class='bx bx-cart cart three'></i>
    </div>
    <div class="box">
      <div class="right-side">
        <div class="box-topic">Total Clients</div>
        <div class="number">11,086</div>
        <div class="indicator">
          <i class='bx bx-down-arrow-alt down'></i>
          <span class="text">Down From Today</span>
        </div>
      </div>
      <i class='bx bxs-cart-download cart four'></i>
    </div>
  </div>

  <div class="sales-boxes">
    <div class="recent-sales box">
      <div class="title">Informations synthéthiques</div>
      <div class="sales-details">
        <canvas id="myChart"></canvas>

        <ul class="details">



          <script>
            // Récupérer l'élément canvas
            var ctx = document.getElementById('myChart').getContext('2d');

            // Créer le graphique
            var myChart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ['Maarif', 'Anfa', 'Beausejor', 'Derb Sultan', 'Derb Omar', 'Oasis'],
                datasets: [{
                  label: 'Consommation',
                  data: [12, 19, 3, 5, 2, 3],
                  backgroundColor: 'rgba(255, 99, 132, 0.2)',
                  borderColor: 'rgba(255, 99, 132, 1)',
                  borderWidth: 1
                }]
              },
              options: {
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: true
                    }
                  }]
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