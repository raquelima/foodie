<?php
include_once __DIR__ .'/vendor/owasp/csrf-protector-php/libs/csrf/csrfprotector.php';

include_once __DIR__ .'/vendor/owasp/csrf-protector-php/libs/csrf/csrfprotector.php';
//Set the session timeout
$timeout = 900;

//Set the maxlifetime of the session
ini_set( "session.gc_maxlifetime", $timeout );

//Set the cookie lifetime of the session
ini_set( "session.cookie_lifetime", $timeout );
// Sessionhandling starten
session_start();
csrfProtector::init();

//Datenbank verbinden
include('include/dbconnector.inc.php');
$error = $message =  '';
$userID = $orderDate = $orderText = $orderAddress =  '';
$orderPrice = 0;

//turn String into array with food id
if (isset($_POST['orderText'])) {
    $orderArray = explode(" ", trim(htmlspecialchars($_POST['orderText'])));
}

// Wurden Daten mit "POST" gesendet?
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Adresse ausgefüllt?
    if (isset($_POST['firstname'])) {
        //trim and sanitize
        $firstname = htmlspecialchars(trim($_POST['firstname']));

        //mindestens 1 Zeichen und maximal 30 Zeichen lang
        if (empty($firstname) || !preg_match("/(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{2,30}/", $firstname)) {
            $error .= "Please enter a valid first name.<br />";
        }
    } else {
        $error .= "Please enter a first name.<br />";
    }

    // Nachname ausgefüllt?
    if (isset($_POST['lastname'])) {
        //trim and sanitize
        $lastname = htmlspecialchars(trim($_POST['lastname']));

        //mindestens 1 Zeichen und maximal 30 Zeichen lang
        if (empty($lastname) || !preg_match("/(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{2,30}/", $lastname)) {
            $error .= "Please enter a valid last name.<br />";
        }
    } else {
        $error .= "Please enter a last name.<br />";
    }

    // street ausgefüllt
    if (isset($_POST['street'])) {
        //trim and sanitize
        $street = htmlspecialchars(trim($_POST['street']));

        //mindestens 1 Zeichen und maximal 100 Zeichen lang
        if (empty($street) || !preg_match("/[a-zA-Z]+\\s[0-9]+/i", $street)) {
            $error .= "Please enter a valid street.<br />";
        }
    } else {
        $error .= "Please enter a street.<br />";
    }

    // city ausgefüllt
    if (isset($_POST['city'])) {
        //trim and sanitize
        $city = htmlspecialchars(trim($_POST['city']));

        //mindestens 1 Zeichen und maximal 100 Zeichen lang
        if (empty($city) || !preg_match("/(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{3,30}/", $city)) {
            $error .= "Please enter a valid city.<br />";
        }
    } else {
        $error .= "Please enter a city.<br />";
    }

    // state ausgefüllt
    if (isset($_POST['state'])) {
        //trim and sanitize
        $state = htmlspecialchars(trim($_POST['state']));

        //mindestens 1 Zeichen und maximal 100 Zeichen lang
        if (empty($state) || !preg_match("/(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{3,30}/", $state)) {
            $error .= "Please enter a valid state.<br />";
        }
    } else {
        $error .= "Please enter a state.<br />";
    }

    // zip ausgefüllt
    if (isset($_POST['zip'])) {
        //trim and sanitize
        $zip = htmlspecialchars(trim($_POST['zip']));

        //mindestens 1 Zeichen und maximal 100 Zeichen lang
        if (empty($zip) || !preg_match("/[0-9]{4,6}/i", $zip)) {
            $error .= "Please enter a valid zip.<br />";
        }
    } else {
        $error .= "Please enter a zip.<br />";
    }

    // wenn kein Fehler vorhanden ist, schreiben der Daten in die Datenbank
    if (empty($error)) {
        foreach ($_SESSION['products'] as $key => $value) {
            unset($_SESSION['products'][$key]);
        }
        $userID = htmlspecialchars($_SESSION['id']);
        $orderDate = date("Y-m-d h:i:s");
        foreach ($orderArray as $key => $value) {

            $query = "select * from food where foodID = {$value};";

            $stmt = $mysqli->prepare($query);

            $stmt->execute();

            $result = $stmt->get_result();

            foreach ($result as $food) {
                $orderPrice += htmlspecialchars($food['price']);

                $orderText .= htmlspecialchars($food['foodName']) . "<br>";
            }
        }
        $orderAddress = $street . " " . $zip . " " . $city . " " . $state;

        // Query erstellen
        $query = "INSERT INTO orders (userID, orderDate, orderText, orderPrice, orderAddress) VALUES (?, ?, ?, ?, ?);";

        // Query vorbereiten
        $stmt = $mysqli->prepare($query);
        if ($stmt === false) {
            $error .= 'prepare() failed ' . $mysqli->error . '<br />';
        }

        // Parameter an Query binden
        if (!$stmt->bind_param('issds', $userID, $orderDate, $orderText, $orderPrice, $orderAddress)) {
            $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
        }

        // Query ausführen
        if (!$stmt->execute()) {
            $error .= 'execute() failed ' . $mysqli->error . '<br />';
        }

        // kein Fehler!
        if (empty($error)) {
            $message .= "Die Daten wurden erfolgreich in die Datenbank geschrieben<br/ >";
            // Felder leeren und Weiterleitung auf anderes Script: z.B. Login!
            $userID = $orderDate = $orderText = $orderPrice = $orderAddress =  '';
        }
    }
}
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


    <div class="container mt-5 mb-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <?php
                if (empty($_POST)) {
                    echo "<strong style='color: #9C3848;'>Error: </strong>No order found! <br>";
                    echo "<a href='index.php' class='btn btn-primary my-2'>Home</a>";
                    die();
                }
                if (!empty($error)) {
                    echo "<strong style='color: #9C3848;'>Error: </strong>", htmlspecialchars($error), "<br>";
                    echo "<a href='index.php' class='btn btn-primary my-2'>Home</a>";
                    die();
                }
                ?>
                <div class="card">
                    <div class="text-center logo p-5"> <img src="images/6.png" alt="logo" width="100" height="100"> </div>
                    <div class="invoice p-5">
                        <h5>Your order was confirmed!</h5>
                        <span class="font-weight-bold d-block mt-4">Hello, <?php echo htmlspecialchars($firstname) ?> </span>
                        <span>You order has been confirmed and will be shipped in hour!</span>
                        <div class="payment border-top mt-3 mb-3 border-bottom table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="py-2"> <span class="d-block text-muted">Order Date</span> <span><?php echo date("d M, Y"); ?></span> </div>
                                        </td>
                                        <td>
                                            <?php

                                            $query = "SELECT * FROM orders ORDER BY orderID DESC LIMIT 1;";

                                            $stmt = $mysqli->prepare($query);

                                            $stmt->execute();

                                            $result = $stmt->get_result();

                                            $count = 0;

                                            foreach ($result as $value) {
                                                $count = htmlspecialchars($value["orderID"]);
                                            }


                                            ?>
                                            <div class="py-2"> <span class="d-block text-muted">Order No</span> <?php echo "#", str_pad($count, 6, '0', STR_PAD_LEFT); ?><span></span> </div>
                                        </td>
                                        <td>
                                            <div class="py-2"> <span class="d-block text-muted">Payment</span> <span><img src="https://img.icons8.com/color/48/000000/mastercard.png" alt="mastercard" width="20" /></span> </div>
                                        </td>
                                        <td>
                                            <div class="py-2">
                                                <span class="d-block text-muted">Shipping Address</span> <span><?php echo htmlspecialchars($_POST["title"]) ?></span>
                                                <span class="d-block"><?php echo $firstname, " ", $lastname ?></span>
                                                <span class="d-block"><?php echo $street ?></span>
                                                <span class="d-block"><?php echo $zip, ", ", $city ?></span>
                                                <span class="d-block"><?php echo $state ?></span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class='products mt-3 mb-3 '>
                            <?php
                            $totalPrice = 0;
                            foreach ($orderArray as $key => $value) {

                                $query = "select * from food where foodID = {$value};";

                                $stmt = $mysqli->prepare($query);

                                $stmt->execute();

                                $result = $stmt->get_result();

                                foreach ($result as $food) {
                                    $totalPrice += htmlspecialchars($food['price']);
                                    $totalPrice = number_format((float)$totalPrice, 2, '.', '');
                                    $price = number_format((float)htmlspecialchars($food['price']), 2, '.', '');
                                    $orderText .= htmlspecialchars($food['foodName']) . " ";
                                    $foodName = htmlspecialchars($food['foodName']);
                                    echo " 
                                            <ul class='list-group mb-2'>
                                                <li class='list-group-item d-flex justify-content-between lh-sm'>
                                                     <div>
                                                        <h6 class='my-0'>{$foodName}</h6>
                                                     </div>
                                                     <span class='text-muted'>{$price} CHF</span>
                                                </li>
                                            </ul>
                                        ";
                                }
                            }

                            $orderDate = date("Y-m-d h:i:s");
                            $orderPrice = $totalPrice;


                            ?>
                        </div>

                        <div class="total mt-3 mb-3 ">
                            <ul>
                                <li class='d-flex justify-content-between'>
                                    <span>Total</span>
                                    <strong><?php echo $totalPrice; ?> CHF</strong>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <ul>
                                <li class='d-flex justify-content-between'>
                                    <p class="font-weight-bold mb-0">Thanks for choosing us!</p>
                                    <form action="orders.php">
                                        <button class="btn btn-warning btn-sm" type="submit">Go to orders</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <span>Foodie</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

</body>

</html>