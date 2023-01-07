<?php
include_once __DIR__ .'/vendor/owasp/csrf-protector-php/libs/csrf/csrfprotector.php';

csrfProtector::init();
include('include/dbconnector.inc.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['deleteRestaurant']) && is_numeric($_POST['deleteRestaurant'])) {
        $query = "DELETE FROM restaurants WHERE id = {$_POST['deleteRestaurant']};";

        $stmt = $mysqli->prepare($query);

        $stmt->execute();

        $stmt->close();
    }
}

echo "<script>
 window.onload = function() {
     window.location.href = 'index.php';
 }
</script>";
