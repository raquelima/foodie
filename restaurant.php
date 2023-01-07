<?php
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
print_r($_SESSION);
print_r($_COOKIE);

//
if (isset($_GET["err"])) {
    $err = htmlspecialchars(trim($_GET["err"]));
    if (!empty($err)) {
        echo "<script>
        window.onload = function() {
           alert('{$err}')
           window.location.href = 'http://localhost/foodie/restaurant.php?id={$_GET["id"]}';
       }
       </script>";
    }
}

if (isset($_GET["id"])) {
    $_GET["id"] = htmlspecialchars(trim($_GET["id"]));
}

if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = array();
}


// Datenbankverbindung
include('include/dbconnector.inc.php');

$query = "SELECT * FROM restaurants";

$stmt = $mysqli->prepare($query);

$stmt->execute();

$result = $stmt->get_result();

$restaurantExists = false;

foreach ($result as $value) {
    if (isset($_GET["id"]) && $_GET["id"] == $value["id"]) {
        $restaurantExists = true;
    }
}

$products = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["products"])) {
        $products = $_SESSION["products"];
    }
    foreach ($_POST as $key => $value) {
        if (!empty($_SESSION['products']) && array_key_exists($key, $products)) {
            unset($products[$key]);
        } else {
            $products[$key] = $value;
        }
        break;
    }
    $_SESSION['products'] = $products;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php
            if (isset($_GET["id"]) && $restaurantExists) {
                foreach ($result as $value) {
                    if ($value["id"] == $_GET["id"]) {
                        echo "Foodie | ", htmlspecialchars($value["name"]);
                    }
                }
            } else {
                echo "404 Not Found";
            }
            ?></title>
    <link rel="shortcut icon" href="images/7.png" />
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/aa92474866.js" crossorigin="anonymous"></script>

    <style>
        .bgimg {
            background-image: url('images/banner6.png');
            background-size: cover;
        }
    </style>

</head>

<body>
    <?php include('include/editRestaurant.php'); ?>

    <?php include('include/nav.php'); ?>

    <?php include('include/login.php'); ?>

    <?php include('include/addFoodModal.php'); ?>

    <?php include('include/deleteRestaurantModal.php'); ?>

    <?php include('include/map.php'); ?>

    <div class="pt-5 text-center bgimg" style="height: 450px;">
        <div class="row pt-lg-5 mx-auto">
            <div class="col-md-3 mx-auto">
                <h1 class="fw-light"><?php
                                        $result->free();
                                        $query = "SELECT * FROM restaurants";

                                        $stmt = $mysqli->prepare($query);

                                        $stmt->execute();

                                        $result = $stmt->get_result();
                                        if (isset($_GET["id"]) && $restaurantExists && is_numeric($_GET["id"])) {
                                            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) {
                                                foreach ($result as $value) {
                                                    if ($value["id"] == $_GET["id"]) {
                                                        echo htmlspecialchars($value["name"]);
                                                    }
                                                }
                                            } else {
                                                echo "<script>
                                                window.onload = function() {
                                                    window.location.href = 'index.php';
                                                }
                                                 </script>";
                                            }
                                        } else {
                                            echo "<strong style='color: #9C3848;'>Oops...</strong> Restaurant not found!";
                                            echo "<a href='index.php' class='btn btn-primary my-2'>Home</a>";
                                            die();
                                        }
                                        ?></h1>
                <p class="lead text-dark"><?php
                                            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) {

                                                foreach ($result as $value) {
                                                    if ($value["id"] == $_GET["id"]) {
                                                        echo htmlspecialchars($value["description"]);
                                                    }
                                                }
                                            }
                                            ?></p>

                <?php
                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) {
                    $website = "";
                    $address = "";
                    if (isset($_GET["id"]) && $restaurantExists) {
                        foreach ($result as $value) {
                            if ($value["id"] == $_GET["id"]) {
                                $website = htmlspecialchars($value["website"]);
                                $address = htmlspecialchars($value["place"]);
                            }
                        }
                    }
                    echo "<button type='button' onclick='updateMap(`{$address}`)' style='display: inline; text-align: right;' class='btn btn-warning mr-2' data-toggle='modal' data-target='#modalVM' >Find us</button>";
                    echo '<a href="', $website, '"  target="_blank" class="btn btn-warning my-2">More</a><br>';
                    if (isset($_SESSION['isAdmin']) and $_SESSION['isAdmin']) {
                        echo "<h1>Hey <strong style='color: #9C3848;'>Admin</strong> :)</h1><br> <h5>Here you can edit this Restaurant! <br></h5>";

                        echo '<button type="button" class="btn btn-success my-2 m-2" data-toggle="modal" data-target="#modalEditRestaurant">Edit Restaurant</button>';
                        echo '<button type="button" class="btn btn-danger my-2 m-2" data-toggle="modal" data-target="#modalDelete">Delete Restaurant</button>';
                    }
                }
                ?>


            </div>
        </div>
    </div>
    <div class="album pb-5 bg-light">
        <main class="container">
            <p style="text-align: right;">
                <?php
                if (isset($_SESSION['isAdmin']) and $_SESSION['isAdmin']) {
                    echo '<button type="button" class="btn btn-dark my-2 m-2" data-toggle="modal" data-target="#modalAddFood">Add Food</button>';
                }
                ?>
            </p>

            <div>
                <?php

                $result->free();

                $query = "select * from restaurants as r join food as f on {$_GET['id']} = r.id and {$_GET['id']} = f.restaurantID;";

                $stmt = $mysqli->prepare($query);

                $stmt->execute();

                $result = $stmt->get_result();

                foreach ($result as $value) {
                    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) {
                        $products = $_SESSION["products"];
                        $button = "";
                        $foodID = htmlspecialchars($value['foodID']);
                        $foodName = htmlspecialchars($value['foodName']);
                        $foodDescription = htmlspecialchars($value['foodDescription']);
                        $price = htmlspecialchars($value['price']);
                        $removeBtn = "<button type='submit' class='btn btn-danger ml-2' name='deleteFood' value='{$foodID}'>Remove Food</button>";
                        if (!empty($products) && array_key_exists(preg_replace('/\s+/', '_', $value["foodID"]), $products)) {
                            $button = "<button type='submit' class='btn btn-success' name='{$foodID}' value='{$foodName}'>Remove from Cart</button>";
                        } else {
                            $button = "<button type='submit' class='btn btn-warning' name='{$foodID}' value='{$foodName}'>Add to shoppingcart</button>";
                        }
                        echo '
                    <div class="col-md-12">
                        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col-auto d-none d-lg-block">
                        <svg class="bd-placeholder-img" width="200" height="250" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                                <title>Placeholder</title>
                                <image href="images/pommes-icon.png" height="100%" width="100%" />
                            </svg>

                            </div>
                            <div class="col p-4 d-flex flex-column position-static" >
                                <h3 class="mb-3">', $foodName, '</h3>

                                <p class="card-text mb-auto">', $foodDescription, '</p>
                                <div class="mb-1 text-muted"  ><p style="display: inline; text-align: left;">', number_format((float)$price, 2, '.', ''), ' CHF</p> 
                                ';
                        if (isset($_SESSION['isAdmin']) and $_SESSION['isAdmin']) {
                            echo '<form style="float: right; display: inline" action="removeFood.php" method="POST">
                                    <input type="text" name="restaurant" hidden value="', $_GET["id"], '">',
                            $removeBtn, '
                                    </form>';
                        }
                        echo '
                                <form style="float: right; display: inline" action="#" method="POST">
                                 ', $button, '
                                </form>

                                </div>

                            </div>

                        </div>
                    </div>
                ';
                    }
                } ?>
            </div>

        </main>

    </div>


    <?php include('include/footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
        function updateMap(address) {
            map = "https://maps.google.com/maps?q=" + address + "&t=&z=13&ie=UTF8&iwloc=&output=embed";
            document.getElementById('map').src = map;

        }
    </script>

</body>

</html>