<?php
session_start();
include 'db.php';

$userId = $_SESSION['user_id'];
$date = date('Y-m-d');

$sql = "SELECT SUM(f.fat) as total_fat, SUM(f.carb) as total_carb, SUM(f.protein) as total_protein 
        FROM todays_foods tf 
        JOIN foods f ON tf.food_id = f.id 
        WHERE tf.user_id = :user_id AND tf.date = :date";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $userId, 'date' => $date]);
$totals = $stmt->fetch();

$totalFat = $totals['total_fat'] ?? 0;
$totalCarb = $totals['total_carb'] ?? 0;
$totalProtein = $totals['total_protein'] ?? 0;

echo "<canvas id='nutritionChart' width='400' height='400'></canvas>";
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctx = document.getElementById('nutritionChart').getContext('2d');
var nutritionChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Fat', 'Carbohydrates', 'Protein'],
        datasets: [{
            data: [<?php echo $totalFat; ?>, <?php echo $totalCarb; ?>, <?php echo $totalProtein; ?>],
            backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe']
        }]
    },
    options: {
        responsive: true
    }
});
</script>
