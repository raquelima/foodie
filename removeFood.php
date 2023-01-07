<?php
include('include/dbconnector.inc.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['deleteFood']) && is_numeric($_POST['deleteFood'])) {
        $query = "DELETE FROM food WHERE foodID = {$_POST['deleteFood']};";

        $stmt = $mysqli->prepare($query);

        $stmt->execute();

        $stmt->close();

        echo "<script>
        window.onload = function() {
            window.location.href = 'restaurant.php?id=", htmlspecialchars($_POST["restaurant"]), "';
        }
       </script>";
    }
} else {
    // Weiterleitung wenn man kein POST hat auf die index seite
    echo "<script>
        window.onload = function() {
            window.location.href = 'index.php';
        }
       </script>";
}
