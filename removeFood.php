<?php
include_once __DIR__ .'/vendor/owasp/csrf-protector-php/libs/csrf/csrfprotector.php';
csrfProtector::init();
include("./vendor/autoload.php");

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$logger = new Logger('my_logger');
$logger->pushHandler(new StreamHandler(dirname(__FILE__).'/logs/log.txt', Logger::INFO));

include('include/dbconnector.inc.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['deleteFood']) && is_numeric($_POST['deleteFood'])) {
        $query = "DELETE FROM food WHERE foodID = {$_POST['deleteFood']};";

        $stmt = $mysqli->prepare($query);

        $stmt->execute();

        if ($mysqli->error) {
            $logger->error($mysqli->error);
        } else {
            $logger->info("food successfully removed");
        }

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
