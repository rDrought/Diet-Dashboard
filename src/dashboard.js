$(document).ready(function() {
    $('#chart-button').on('click', function() {
        $.ajax({
            url: "Scripts/chart.php",
            success: function(response) {
                $('#content').html(response);
            },
            error: function() {
                alert("Error loading chart.php");
            }
        });
    });

    $('#today-button').on('click', function() {
        $.ajax({
            url: "Scripts/today.php",
            success: function(response) {
                $('#content').html(response);
            },
            error: function() {
                alert("Error loading today.php");
            }
        });
    });

    $('#food-list-button').on('click', function() {
        $.ajax({
            url: "Scripts/food_list.php",
            success: function(response) {
                $('#content').html(response);
            },
            error: function() {
                alert("Error loading food_list.php");
            }
        });
    });

    function updateDateTime() {
        const now = new Date();
        $('#current-date-time').text(now.toLocaleString());
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();
});

function logout() {
    $.ajax({
        url: "Scripts/logout.php",
        type: 'POST',
        success: function(response) {
            if (response === "success") {
                window.location.href = 'login.html';
            } else {
                alert("Failed to logout.");
            }
        }
    });
}
