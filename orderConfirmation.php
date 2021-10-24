<?php

// Sessionhandling starten
session_start();

//Datenbank verbinden
include('include/dbconnector.inc.php');
$error = $message =  '';
$userID = $orderDate = $orderText = $orderPrice = $orderAddress =  '';

//turn String into array with food id
$orderArray = explode(" ", trim($_POST['orderText']));

foreach ($_SESSION['products'] as $key => $value) {
    unset($_SESSION['products'][$key]);
}

$userID = $_SESSION['id'];

foreach ($orderArray as $key => $value) {

    $query = "select * from food where foodID = {$value};";

    $stmt = $mysqli->prepare($query);

    $stmt->execute();

    $result = $stmt->get_result();

    foreach ($result as $food) {
        
        $orderText .= $food['foodName'] . "<br>";
       
    }
}

// Wurden Daten mit "POST" gesendet?
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $orderPrice = $food['price'];
    $orderDate = date("Y-m-d h:i:s");
    // Adresse ausgefüllt?
    if (isset($_POST['firstname'])) {
        //trim and sanitize
        $firstname = htmlspecialchars(trim($_POST['firstname']));

        //mindestens 1 Zeichen und maximal 30 Zeichen lang
        if (empty($firstname) || strlen($firstname) > 30) {
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
        if (empty($lastname) || strlen($lastname) > 30) {
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
        if (empty($street) || strlen($street) > 100) {
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
        if (empty($city) || strlen($city) > 30) {
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
        if (empty($state) || strlen($state) > 30) {
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
        if (empty($zip) || strlen($zip) > 4) {
            $error .= "Please enter a valid zip.<br />";
        }
    } else {
        $error .= "Please enter a zip.<br />";
    }

    // wenn kein Fehler vorhanden ist, schreiben der Daten in die Datenbank
    if (empty($error)) {
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
</head>

<body class='bg-light'>

    <div class="container mt-5 mb-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="text-center logo p-5"> <img src="images/6.png" width="100" height="100"> </div>
                    <div class="invoice p-5">
                        <h5>Your order was confirmed!</h5>
                        <span class="font-weight-bold d-block mt-4">Hello, <?php echo $firstname ?> </span>
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

                                            $query = "SELECT * FROM orders;";

                                            $stmt = $mysqli->prepare($query);

                                            $stmt->execute();

                                            $result = $stmt->get_result();

                                            $count = 0;

                                            foreach ($result as $value) {
                                                $count++;
                                            }

                                            ?>
                                            <div class="py-2"> <span class="d-block text-muted">Order No</span> <?php echo $count + 1; ?><span></span> </div>
                                        </td>
                                        <td>
                                            <div class="py-2"> <span class="d-block text-muted">Payment</span> <span><img src="https://img.icons8.com/color/48/000000/mastercard.png" width="20" /></span> </div>
                                        </td>
                                        <td>
                                            <div class="py-2">
                                                <span class="d-block text-muted">Shipping Address</span> <span><?php echo $_POST["title"] ?></span>
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
                                    $totalPrice += $food['price'];
                                    $totalPrice = number_format((float)$totalPrice, 2, '.', '');
                                    $price = number_format((float)$food['price'], 2, '.', '');
                                    $orderText .= $food['foodName'] . "<br>";
                                    echo " 
                                            <ul class='list-group mb-2'>
                                                <li class='list-group-item d-flex justify-content-between lh-sm'>
                                                     <div>
                                                        <h6 class='my-0'>{$food['foodName']}</h6>
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
                            <li class='d-flex justify-content-between'>
                                <span>Total</span>
                                <strong><?php echo $totalPrice; ?> CHF</strong>
                            </li>
                        </div>
                        <div>
                            <li class='d-flex justify-content-between'>
                                <p class="font-weight-bold mb-0">Thanks for choosing us!</p>
                                <form action="orders.php">
                                    <button class="btn btn-warning btn-sm" type="submit">Go to orders</button>
                                </form>
                            </li>
                        </div>
                        <span>Foodie</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>