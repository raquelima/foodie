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
error_reporting(0);

csrfProtector::init();
include("./vendor/autoload.php");

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('my_logger');
$logger->pushHandler(new StreamHandler(dirname(__FILE__) . '/logs/log.txt', Logger::INFO));
//turn String into array with food id
$products = explode(" ", trim($_POST['orderText']));

//Datenbank verbinden
include('include/dbconnector.inc.php');

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

</head>

<body class='bg-light'>

    <div class='container'>
        <main>
            <div class='py-5 text-center'>
                <img class='d-block mx-auto mb-4' src='images/6.png' alt='' width='80' height='80'>
                <h2>Checkout form</h2>
                <p class='lead'>All the items you would like to purchase</p>
            </div>
            <?php if (empty($_POST["orderText"])) {
                header("location: fehlerseite.php?err=404&msg=Items not found");
                die();
            } ?>
            <div class='row g-5'>
                <div class='col-md-5 col-lg-4 order-md-last'>
                    <h4 class='d-flex justify-content-between align-items-center mb-3'>
                        <span class='text-primary'>Your cart</span>
                        <span class='badge bg-primary rounded-pill'><?php echo count($products) ?></span>
                    </h4>
                    <ul class='list-group mb-3'>
                        <?php

                        $totalPrice = 0;
                        foreach ($products as $key => $value) {

                            $query = "select * from food where foodID = {$value};";

                            $stmt = $mysqli->prepare($query);

                            $stmt->execute();
                            if ($mysqli->error) {
                                $logger->error($mysqli->error);
                                header("location: fehlerseite.php?err=500&msg=Internal Server Error");
                            } else {
                                $logger->info("selected food");
                            }

                            $result = $stmt->get_result();

                            foreach ($result as $food) {
                                $totalPrice += htmlspecialchars($food['price']);
                                $totalPrice = number_format((float)$totalPrice, 2, '.', '');
                                $price = number_format((float)htmlspecialchars($food['price']), 2, '.', '');
                                $foodName = htmlspecialchars($food['foodName']);
                                echo " <li class='list-group-item d-flex justify-content-between lh-sm'>
                                            <div>
                                                <h6 class='my-0'>{$foodName}</h6>
                                            </div>
                                            <span class='text-muted'>{$price} CHF</span>
                                        </li>";
                            }
                        }
                        ?>
                    </ul>

                    <ul class='list-group mb-3'>
                        <li class='list-group-item d-flex justify-content-between'>
                            <span>Total</span>
                            <strong><?php echo $totalPrice; ?> CHF</strong>
                        </li>
                    </ul>

                </div>
                <div class='col-md-7 col-lg-8'>
                    <h4 class='mb-3'>Shipping address</h4>
                    <form class='needs-validation' action="orderConfirmation.php" method="POST">

                        <div class="col-md-3 pb-2">
                            <label class="form-label">Title</label>
                            <select class="form-select" name="title" required>
                                <option value="">Choose...</option>
                                <option>Mr</option>
                                <option>Mrs</option>
                                <option>Miss</option>
                                <option>Ms</option>
                                <option>Mx</option>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid title.
                            </div>
                        </div>
                        <?php

                        $query = "SELECT * FROM users WHERE {$_SESSION['id']}=id;";

                        $stmt = $mysqli->prepare($query);

                        $stmt->execute();

                        $result = $stmt->get_result();

                        foreach ($result as $value) {
                            $firstname = htmlspecialchars($value['firstname']);
                            $lastname = htmlspecialchars($value['lastname']);
                            $email = htmlspecialchars($value['email']);
                            $username = htmlspecialchars($value['username']);
                            $street = htmlspecialchars($value['street']);
                            $city = htmlspecialchars($value['city']);
                            $state = htmlspecialchars($value['state']);
                            $zip = htmlspecialchars($value['zip']);


                            echo "<div class='row g-3'>
                            <div class='col-sm-6'>
                                <label class='form-label'>First name</label>
                                <input type='text' class='form-control' name='firstname' value='{$firstname}' pattern='[A-Z a-z]{2,30}' placeholder='' maxlength='30' required title='Firstname name must contain at least one upper case letter and between 2 to 30 letters. Example: Elias'>
                                <div class='invalid-feedback'>
                                    Valid first name is required.
                                </div>
                            </div>

                            <div class='col-sm-6'>
                                <label class='form-label'>Last name</label>
                                <input type='text' class='form-control' name='lastname' value='{$lastname}' pattern='[A-Z a-z]{2,30}' placeholder='' maxlength='30' required title='Lastname name must contain at least one upper case letter and between 2 to 30 letters. Example: Mustermann'>
                                <div class='invalid-feedback'>
                                    Valid last name is required.
                                </div>
                            </div>

                            <div class='col-12'>
                                <label class='form-label'>Street</label>
                                <input type='text' class='form-control' name='street' placeholder='' value='{$street}' pattern='[a-z A-Z]+\s[0-9]+' maxlength='255' required title='Example: Centralbahnstrasse 9'>
                                <div class='invalid-feedback'>
                                    Please enter your shipping address.
                                </div>
                            </div>

                            <div class='col-md-4'>
                                <label class='form-label'>State</label>
                                <input type='text' class='form-control' name='state' placeholder='' value='{$state}' pattern='[A-Z a-z]{3,30}'  maxlength='30' required title='State must contain at least one upper case letter and between 3 to 30 letters. Example: Basel'>
                                <div class='invalid-feedback'>
                                    State required.
                                </div>
                            </div>

                            <div class='col-md-4'>
                                <label class='form-label'>City</label>
                                <input type='text' class='form-control' name='city' placeholder='' value='{$city}' pattern='[A-Z a-z]{3,30}' maxlength='30' required title='City must contain at least one upper case letter and between 3 to 30 letters. Example: Basel'>
                                <div class='invalid-feedback'>
                                    City required.
                                </div>
                            </div>

                            <div class='col-md-4'>
                                <label class='form-label'>Zip</label>
                                <input type='text' class='form-control' name='zip' placeholder='' value='{$zip}' pattern='[0-9]{4,6}' minlength='4' maxlength='6' required title='Example: 4460'>
                                <div class='invalid-feedback'>
                                    Zip code required.
                                </div>
                            </div>
                        </div>";
                        }
                        ?>

                        <hr class="my-4">

                        <h4 class="mb-3">Payment</h4>

                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label class="form-label">Name on card</label>
                                <input type="text" class="form-control" name="cc-name" pattern="^[a-zA-Z].*[\s\.]*$" minlength="2" maxlength="30" required>
                                <small class="text-muted">Full name as displayed on card</small>
                                <div class="invalid-feedback">
                                    Name on card is required
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Credit card number</label>
                                <input type="number" step="1" class="form-control" name="cc-number" min="1000000000000000" max="9999999999999999" required>
                                <div class="invalid-feedback">
                                    Valid credit card number is required
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Expiration</label>
                                <input class="inputCard" name="expiry" id="expiry" type="month" required />
                                <div class="invalid-feedback">
                                    Expiration date required
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">CVV</label>
                                <input type="number" step="1" class="form-control" name="cc-cvv" min="100" max="999" required>
                                <div class="invalid-feedback">
                                    Valid security code required
                                </div>
                            </div>

                            <input type="text" name="orderText" value="<?php echo htmlspecialchars($_POST['orderText']); ?>" hidden>

                        </div>

                        <hr class="my-4">

                        <button class="w-100 btn btn-primary btn-lg" type="submit">Pay</button>
                    </form>
                </div>
            </div>
        </main>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; 2021 Foodie</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Privacy</a></li>
                <li class="list-inline-item"><a href="#">Terms</a></li>
                <li class="list-inline-item"><a href="#">Support</a></li>
            </ul>
        </footer>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    <script src="form-validation.js"></script>
</body>




</html>