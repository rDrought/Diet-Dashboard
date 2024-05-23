<?php
session_start();
include 'db.php';

$id = $_POST['id'];
$userId = $_SESSION['user_id'];
$date = date('Y-m-d');

$sql = "DELETE FROM todays_foods WHERE id = :id AND user_id = :user_id AND date = :date";
$stmt = $pdo->prepare($sql);
$success = $stmt->execute(['id' => $id, 'user_id' => $userId, 'date' => $date]);

if ($success) {
    echo "success";
} else {
    echo "Failed to remove food item.";
}
?>
