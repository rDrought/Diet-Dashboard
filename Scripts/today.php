<?php
session_start();
include 'db.php';

$userId = $_SESSION['user_id'];
$date = date('Y-m-d');

$sql = "SELECT tf.id, f.name, f.fat, f.carb, f.protein 
        FROM todays_foods tf 
        JOIN foods f ON tf.food_id = f.id 
        WHERE tf.user_id = :user_id AND tf.date = :date";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $userId, 'date' => $date]);
$foods = $stmt->fetchAll();

$totalFat = 0;
$totalCarb = 0;
$totalProtein = 0;

echo "<table border='1' cellspacing='0' cellpadding='10'>";
echo "<thead>";
echo "<tr>";
echo "<th>Name</th>";
echo "<th>Fat (grams)</th>";
echo "<th>Carbohydrates (grams)</th>";
echo "<th>Protein (grams)</th>";
echo "<th>Actions</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

foreach ($foods as $food) {
    $totalFat += $food['fat'];
    $totalCarb += $food['carb'];
    $totalProtein += $food['protein'];
    echo "<tr>";
    echo "<td>" . htmlspecialchars($food['name']) . "</td>";
    echo "<td>" . htmlspecialchars($food['fat']) . "</td>";
    echo "<td>" . htmlspecialchars($food['carb']) . "</td>";
    echo "<td>" . htmlspecialchars($food['protein']) . "</td>";
    echo "<td><button onclick='removeFromToday(" . $food['id'] . ")'>Remove</button></td>";
    echo "</tr>";
}

echo "<tr>";
echo "<td><strong>Total</strong></td>";
echo "<td><strong>$totalFat</strong></td>";
echo "<td><strong>$totalCarb</strong></td>";
echo "<td><strong>$totalProtein</strong></td>";
echo "<td></td>";
echo "</tr>";

echo "</tbody>";
echo "</table>";
?>
<script>
function removeFromToday(id) {
    if (confirm("Are you sure you want to remove this food item from today's list?")) {
        $.ajax({
            type: "POST",
            url: "Scripts/remove_from_today.php",
            data: { id: id },
            success: function(response) {
                if (response === "success") {
                    alert("Food item removed from today's list.");
                    location.reload();
                } else {
                    alert("Failed to remove food item from today's list.");
                }
            }
        });
    }
}
</script>
