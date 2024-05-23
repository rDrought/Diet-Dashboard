<?php
session_start();
include 'db.php';

$userId = $_SESSION['user_id'];
$foodIds = $_POST['food_ids'];
$date = date('Y-m-d');

foreach ($foodIds as $foodId) {
    $sql = "INSERT INTO todays_foods (user_id, food_id, date) VALUES (:user_id, :food_id, :date)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId, 'food_id' => $foodId, 'date' => $date]);
}

echo "success";
?>
