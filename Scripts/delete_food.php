<?php
include 'db.php';

$id = $_POST['id'];

$sql = "DELETE FROM foods WHERE id = :id";
$stmt = $pdo->prepare($sql);
$success = $stmt->execute(['id' => $id]);

if ($success) {
    echo "success";
} else {
    echo "Failed to delete food item.";
}
?>
