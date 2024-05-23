<?php
include 'db.php';

$sql = "SELECT id, name, fat, carb, protein FROM foods";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$foods = $stmt->fetchAll();

echo "<button onclick='addFoodItem()'>Add Food Item</button>";
echo "<table id='foodTable' class='display'>";
echo "<thead>";
echo "<tr>";
echo "<th>Select</th>";
echo "<th>Name</th>";
echo "<th>Fat (grams)</th>";
echo "<th>Carbohydrates (grams)</th>";
echo "<th>Protein (grams)</th>";
echo "<th>Actions</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

foreach ($foods as $food) {
    echo "<tr>";
    echo "<td><input type='checkbox' class='select-row' value='" . $food['id'] . "'></td>";
    echo "<td>" . htmlspecialchars($food['name']) . "</td>";
    echo "<td>" . htmlspecialchars($food['fat']) . "</td>";
    echo "<td>" . htmlspecialchars($food['carb']) . "</td>";
    echo "<td>" . htmlspecialchars($food['protein']) . "</td>";
    echo "<td>";
    echo "<button onclick='editFoodItem(" . $food['id'] . ")'>Edit</button>";
    echo "<button onclick='deleteFoodItem(" . $food['id'] . ")'>Delete</button>";
    echo "</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "<button onclick='addToToday()'>Add to Today’s List</button>";
?>
<script>
$(document).ready(function() {
    $('#foodTable').DataTable({
        "pageLength": 10
    });
});

function addFoodItem() {
    const name = prompt("Enter food name:");
    const fat = prompt("Enter fat content:");
    const carb = prompt("Enter carbohydrate content:");
    const protein = prompt("Enter protein content:");

    if (name && fat && carb && protein) {
        $.ajax({
            type: "POST",
            url: "Scripts/add_food.php",
            data: { name: name, fat: fat, carb: carb, protein: protein },
            success: function(response) {
                if (response === "success") {
                    alert("Food item added successfully.");
                    location.reload();
                } else {
                    alert("Failed to add food item.");
                }
            }
        });
    } else {
        alert("All fields are required.");
    }
}

function editFoodItem(id) {
    const newName = prompt("Enter new name:");
    const newFat = prompt("Enter new fat content:");
    const newCarb = prompt("Enter new carbohydrate content:");
    const newProtein = prompt("Enter new protein content:");

    if (newName && newFat && newCarb && newProtein) {
        $.ajax({
            type: "POST",
            url: "Scripts/edit_food.php",
            data: { id: id, name: newName, fat: newFat, carb: newCarb, protein: newProtein },
            success: function(response) {
                if (response === "success") {
                    alert("Food item updated successfully.");
                    location.reload();
                } else {
                    alert("Failed to update food item.");
                }
            }
        });
    } else {
        alert("All fields are required.");
    }
}

function deleteFoodItem(id) {
    if (confirm("Are you sure you want to delete this food item?")) {
        $.ajax({
            type: "POST",
            url: "Scripts/delete_food.php",
            data: { id: id },
            success: function(response) {
                if (response === "success") {
                    alert("Food item deleted successfully.");
                    location.reload();
                } else {
                    alert("Failed to delete food item.");
                }
            }
        });
    }
}

function addToToday() {
    const selected = [];
    $('.select-row:checked').each(function() {
        selected.push($(this).val());
    });

    if (selected.length > 0) {
        $.ajax({
            type: "POST",
            url: "Scripts/add_to_today.php",
            data: { food_ids: selected },
            success: function(response) {
                if (response === "success") {
                    alert("Food items added to today's list.");
                } else {
                    alert("Failed to add food items to today's list.");
                }
            }
        });
    } else {
        alert("Please select at least one food item.");
    }
}
</script>
