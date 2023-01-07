<?php
include_once __DIR__ . '/vendor/owasp/csrf-protector-php/libs/csrf/csrfprotector.php';

csrfProtector::init();
include("./vendor/autoload.php");

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('my_logger');
$logger->pushHandler(new StreamHandler(dirname(__FILE__) . '/logs/log.txt', Logger::INFO));
include('include/dbconnector.inc.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['deleteRestaurant']) && is_numeric($_POST['deleteRestaurant'])) {
        $query = "DELETE FROM restaurants WHERE id = {$_POST['deleteRestaurant']};";

        $stmt = $mysqli->prepare($query);

        $stmt->execute();
        if ($mysqli->error) {
            $logger->error($mysqli->error);
            header("location: fehlerseite.php?err=500&msg=Internal Server Error");
        } else {
            $logger->info("restaurant successfully deleted");
        }

        $stmt->close();
    }
}

echo "<script>
 window.onload = function() {
     window.location.href = 'http://localhost/foodie/index.php';
 }
</script>";
