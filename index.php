<?php

// Sessionhandling starten
session_start();

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

    <link rel="stylesheet" href="css/admin-style.css">
>>>>>>> d297247aa3482e5977ca156f64a05fa8a36ba65c
</head>
</head>

<body>
    <?php include('include/nav.php'); ?>

    <?php include('include/login.php'); ?>

    <?php include('include/registration.php'); ?>

    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <svg class="bi me-2" width="200" height="200" role="img" aria-label="Foodie">
                    <image href='images/6.png' height='100%' width='100%' />
                </svg>
                <p> </p>
                <?php
                //wenn Session personalisiert
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
                    echo '<p class="lead text-muted">Willkommen ', $_SESSION['username'], '!</p>';
                } else {
                    //wenn Session nicht personalisiert
                    echo '<p class="lead text-muted">Finde die besten Restaurants, die Lieferungen anbieten. Kontaktlose Lieferung von Bestellungen von Restaurants, Lebensmitteln und vieles mehr!</p>';
                    echo '<p>
                        <a href="" class="btn btn-warning my-2" data-toggle="modal" data-target="#modalSignup">Sign-up</a>
                        <a href="" class="btn btn-dark my-2" data-toggle="modal" data-target="#modalSignin">Login</a>
                    </p>';
                }
                ?>

            </div>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php


                $query = "SELECT * FROM restaurants";

                $stmt = $mysqli->prepare($query);

                $stmt->execute();

                $result = $stmt->get_result();


                foreach ($result as $value) {

                    echo "<div class='col'>
                    <div class='card shadow-sm'>
                        <svg class='bd-placeholder-img card-img-top' width='100%' height='230' xmlns='http://www.w3.org/2000/svg' role='img' preserveAspectRatio='xMidYMid slice' focusable='false'>
                            <title>Placeholder</title>
                            <image href='images/mc.jpg' height='100%' width='100%' />
                        </svg>

                        <div class='card-body'>
                            <p class='card-text'>", $value['name'], "</p>
                            <p class='card-text'>", $value["description"], "<br>", $value["place"], "</p>
                            <div class='d-flex justify-content-between align-items-center'>
                            <a href='restaurant.php?id=", $value["id"], "' class='text-warning stretched-link' >View</a>
                            <small class='text-muted'>", $value["delivery-from"], "-", $value["delivery-until"], " Min</small>
                            </div>
                        </div>
                    </div>
                </div>";
                }


                ?>

            </div>

        </div>
    </div>
    <?php

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $error = '';
        $restaurantName = $website = $description = $address = $from = $until = '';
        
        if (isset($_POST['restaurantName'])) {
            $restaurantName = trim(htmlspecialchars($_POST['restaurantName']));
            if (empty($restaurantName) || strlen($restaurantName) > 60) {
                $error .= " Invalid Restaurant Name";
            }
        } else {
            $error .= " Invalid Restaurant Name";
        }
        if (isset($_POST['website'])) {
            $website = trim($_POST['website']);
            if (empty($website) || strlen($website) > 256) {
                $error .= " Invalid website";
            }
        } else {
            $error .= " Invalid website";
        }
        if (isset($_POST['description'])) {
            $description = trim(htmlspecialchars($_POST['description']));
            if (empty($description) || strlen($description) > 256) {
                $error .= " Invalid description";
            }
        } else {
            $error .= " Invalid description ";
        }
        if (isset($_POST['address'])) {
            $address = trim(htmlspecialchars($_POST['address']));
            if (empty($address) || strlen($address) > 256) {
                $error .= " Invalid address";
            }
        } else {
            $error .= " Invalid address";
        }
        if (isset($_POST['from'])) {
            $from = trim(htmlspecialchars($_POST['from']));
            if (empty($from) || !is_numeric($from)) {
                $error .= " Invalid from";
            }
        } else {
            $error .= " Invalid from";
        }
        if (isset($_POST['until'])) {
            $until = trim(htmlspecialchars($_POST['until']));
            if (empty($until) || !is_numeric($until)) {
                $error .= " Invalid until";
            }
        } else {
            $error .= " Invalid until";
        }

        if (empty($error)) {

            $query = "INSERT INTO `restaurants` (`name`, `description`, `place`, `website`, `delivery-from`, `delivery-until`) VALUES (?, ?, ?, ?, ?, ?)";

            // Query vorbereiten
            $stmt = $mysqli->prepare($query);
            if ($stmt === false) {
                $error .= 'prepare() failed ' . $mysqli->error . '<br />';
            }
            // Parameter an Query binden
            if (!$stmt->bind_param('ssssii', $restaurantName, $description, $address, $website, $from, $until)) {
                $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
            }
            // Query ausführen
            if (!$stmt->execute()) {
                $error .= 'execute() failed ' . $mysqli->error . '<br />';
            }
            header("location: ");
        }
    }

    
    $result->free();

    $query = "SELECT * FROM restaurants";

    $stmt = $mysqli->prepare($query);

    $stmt->execute();

    $result = $stmt->get_result();
    if (strlen($error)) {
        echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
    }

    if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"]) {
        echo '<div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-12 col-sm-offset-2 col-sm-8">
                <form class="form-horizontal row" method="POST" action="">
                    <div class="form-icon "><i class="fa fa-plus-square" aria-hidden="true"></i></div>
                    <div class="form-group col-md-6 ">
                    </div>
                    <div class="form-group col-md-6 ">
                        <label>Restaurant Name</label>
                        <input class="form-control" type="Name" name="restaurantName" required="" placeholder="Restaurant Name">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Website</label>
                        <input class="form-control" type="Name" name="website" required="" placeholder="Website">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Description</label>
                        <input class="form-control" type="" name="description" required="" placeholder="Description">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Address</label>
                        <input class="form-control" type="name" name="address" required="" placeholder="Address">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Delivery From</label>
                        <input class="form-control" type="number" name="from" required="" placeholder="From">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Delivery Until</label>
                        <input class="form-control" type="number" name="until" required="" placeholder="Until">
                    </div>
                    <button type="submit" class="btn btn-default">Create Restaurant</button>
                </form>
            </div>
        </div>
    </div>';
    }
    ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>