<?php
include_once __DIR__ . '/vendor/owasp/csrf-protector-php/libs/csrf/csrfprotector.php';

//Set the session timeout
$timeout = 900;

//Set the maxlifetime of the session
ini_set("session.gc_maxlifetime", $timeout);

//Set the cookie lifetime of the session
ini_set("session.cookie_lifetime", $timeout);

//Set cookie to http only
ini_set( 'session.cookie_httponly', 1 );

// Sessionhandling starten
session_start();

csrfProtector::init();

ini_set("error_log", dirname(__FILE__) . "/logs/error_log.txt");

include("./vendor/autoload.php");

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('my_logger');
// Now add some handlers
$logger->pushHandler(new StreamHandler(dirname(__FILE__) . '/logs/log.txt', Logger::INFO));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foodie</title>

    <link rel="shortcut icon" href="images/7.png" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/aa92474866.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin-style.css">

    <style>
        .bgimg {
            background-image: url('images/banner1.png');
            background-size: cover;
        }
    </style>

</head>

<body>
    <?php include('include/nav.php'); ?>

    <div class="text-center bgimg">
        <div class="row py-lg-5 mx-auto">
            <div class="col-lg-6 col-md-8 mx-auto">
                <svg class="bi me-2" width="200" height="200" role="img" aria-label="Foodie">
                    <image href='images/browser.png' height='100%' width='100%' />
                </svg>
                <h3><?php echo htmlspecialchars($_GET['err']) ?></h3>
                <h1><?php if (isset($_GET['msg'])) {
                        echo htmlspecialchars($_GET['msg']);
                    } else {
                        echo 'Ups, something went wrong';
                    } ?></h1>
            </div>
        </div>
    </div>


    <?php include('include/footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>


</html>