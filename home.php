<?php include('db_connect.php') ?>
<!-- Info boxes -->
<?php if($_SESSION['login_type'] == 1): ?>
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">	Total des clients</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM customers")->num_rows; ?>
                </span>
              </div>
             
            </div>
            
          </div>
         
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Nombre total d’agents</span>
                 <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM staff")->num_rows; ?>
                </span>
              </div>
              
            </div>
           
          </div>
          
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-columns"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Nombre de secteurs</span>
                <span class="info-box-number"><?php echo $conn->query("SELECT * FROM departments")->num_rows; ?></span>
              </div>
              
            </div>
           
          </div>
       
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-ticket-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total des sinistres</span>
                <span class="info-box-number"><?php echo $conn->query("SELECT * FROM tickets")->num_rows; ?></span>
              </div>
         
            </div>
          
          </div>
        
        </div>
       
<div class="card mt-4">
  <div class="card-header">
    <h5 class="card-title">Tendance des sinistres</h5>
  </div>
  <div class="card-body">
    <canvas id="sinistreChart" height="100"></canvas>
  </div>
</div>

<?php
// Exemple de données par mois pour les sinistres
$sinistres_par_mois = [];
for ($i = 1; $i <= 12; $i++) {
    $mois = str_pad($i, 2, "0", STR_PAD_LEFT);
    $count = $conn->query("SELECT * FROM tickets WHERE MONTH(date_created) = $i")->num_rows;
    $sinistres_par_mois[] = $count;
}
// ➕ NOUVEAU GRAPHIQUE : comparaison entre deux mois
$mois_actuel = 8;
$annee_actuelle = 2025;
$mois_prec = 7;
$annee_prec = 2025;

$count_current = $conn->query("SELECT * FROM tickets WHERE MONTH(date_created) = $mois_actuel AND YEAR(date_created) = $annee_actuelle")->num_rows;
$count_previous = $conn->query("SELECT * FROM tickets WHERE MONTH(date_created) = $mois_prec AND YEAR(date_created) = $annee_prec")->num_rows;

?>

<!-- ➕ NOUVELLE CARTE -->
<div class="card mt-4">
  <div class="card-header">
    <h5 class="card-title">Comparaison mensuelle</h5>
  </div>
  <div class="card-body">
    <canvas id="barChart" height="100"></canvas>
  </div>
</div>









<?php
echo "<pre style='background:#eee;padding:10px'>";
echo "Mois actuel : $mois_actuel ($annee_actuelle)\n";
echo "Mois précédent : $mois_prec ($annee_prec)\n";
echo "Sinistres Mois Actuel : $count_current\n";
echo "Sinistres Mois Précédent : $count_previous\n";
echo "</pre>";
?>





<script>
  const ctx = document.getElementById('sinistreChart').getContext('2d');
  const sinistreChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
      datasets: [{
        label: 'Nombre de sinistres',
        data: <?php echo json_encode($sinistres_par_mois); ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: '#36A2EB',
        borderWidth: 2,
        fill: true,
        tension: 0.3,
        pointRadius: 5
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        }
      }
    }
  });
  const barCtx = document.getElementById('barChart').getContext('2d');
  const barChart = new Chart(barCtx, {
    type: 'bar',
    data: {
      labels: ['Mois Précédent', 'Mois Actuel'],
      datasets: [{
        label: 'Nombre de sinistres',
        data: [<?php echo $count_previous; ?>, <?php echo $count_current; ?>],
        backgroundColor: ['#007bff', '#007bff']
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        }
      }
    }
  });
</script>

<?php else: ?>
	 <div class="col-12">
          <div class="card">
          	<div class="card-body">
          		Bienvenue <?php echo $_SESSION['login_name'] ?>!
          	</div>
          </div>
      </div>
<?php endif; ?>
