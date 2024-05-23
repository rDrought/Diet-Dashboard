<?php
include 'db.php';

$id = $_POST['id'];
$name = $_POST['name'];
$fat = $_POST['fat'];
$carb = $_POST['carb'];
$protein = $_POST['protein'];

$sql = "UPDATE foods SET name = :name, fat = :fat, carb = :carb, protein = :protein WHERE id = :id";
$stmt = $pdo->prepare($sql);
$success = $stmt->execute(['id' => $id, 'name' => $name, 'fat' => $fat, 'carb' => $carb, 'protein' => $protein]);

if ($success) {
    echo "success";
} else {
    echo "Failed to update food item.";
}
?>
