<?php
include 'db.php';

$name = $_POST['name'];
$fat = $_POST['fat'];
$carb = $_POST['carb'];
$protein = $_POST['protein'];

$sql = "INSERT INTO foods (name, fat, carb, protein) VALUES (:name, :fat, :carb, :protein)";
$stmt = $pdo->prepare($sql);
$success = $stmt->execute(['name' => $name, 'fat' => $fat, 'carb' => $carb, 'protein' => $protein]);

if ($success) {
    echo "success";
} else {
    echo "Failed to add food item.";
}
?>
