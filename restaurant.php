<?php

// Sessionhandling starten
session_start();

// Datenbankverbindung




include('include/dbconnectorRestaurants.inc.php');

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

if (isset($_SESSION["products"]) && !empty($_SESSION["products"])) {
    $products = $_SESSION["products"];
}
foreach ($_POST as $key => $value) {
    if (array_key_exists($key, $products)) {
        unset($products[$key]);
    } else {
        $products[$key] = $value;
    }
}
$_SESSION['products'] = $products;
print_r($_SESSION)
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
                        echo "Foodie | ", $value["name"];
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
</head>
</head>

<body>
    <?php include('include/nav.php'); ?>

    <?php include('include/login.php'); ?>

    <?php include('include/registration.php'); ?>

    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light"><?php
                                        if (isset($_GET["id"]) && $restaurantExists) {
                                            foreach ($result as $value) {
                                                if ($value["id"] == $_GET["id"]) {
                                                    echo $value["name"];
                                                }
                                            }
                                        } else {
                                            echo "<strong style='color: #9C3848;'>Oops...</strong> Restaurant not found!";
                                            echo "<a href='index.php' class='btn btn-primary my-2'>Home</a>";
                                            die();
                                        }
                                        ?></h1>
                <p class="lead text-muted"><?php
                                            foreach ($result as $value) {
                                                if ($value["id"] == $_GET["id"]) {
                                                    echo $value["description"];
                                                }
                                            }
                                            ?></p>
                <p>
                    <?php

                    $website = "";
                    if (isset($_GET["id"]) && $restaurantExists) {
                        foreach ($result as $value) {
                            if ($value["id"] == $_GET["id"]) {
                                $website = $value["website"];
                            }
                        }
                    }

                    echo '<a href="', $website, '"  target="_blank" class="btn btn-warning my-2">More</a>'
                    ?>

                </p>
            </div>
        </div>
    </section>
    <div class="album py-5 bg-light">
        <main class="container">


            <div>
                <?php
                include('include/dbconnectorRestaurants.inc.php');

                $result->free();

                $query = "select * from restaurants as r join food as f on {$_GET['id']} = r.id and {$_GET['id']} = f.restaurantID;";

                $stmt = $mysqli->prepare($query);

                $stmt->execute();

                $result = $stmt->get_result();

                foreach ($result as $value) {
                    $products = $_SESSION["products"];
                    $button= "";
                    if (array_key_exists(preg_replace('/\s+/', '_', $value["foodName"]), $products)) {
                        $button ="<button type='submit' class='btn btn-success' name='{$value['foodName']}' value='{$value['foodID']}'>Remove Item</button>";
                    }else{
                        $button ="<button type='submit' class='btn btn-warning' name='{$value['foodName']}' value='{$value['foodID']}'>Add to shoppingcart</button>";
                    }
                    echo '
                    <div class="col-md-12">
                        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col-auto d-none d-lg-block">
                        <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">>
                                <title>Placeholder</title>
                                <image href="images/pommes-icon.png" height="100%" width="100%" />
                            </svg>

                            </div>
                            <div class="col p-4 d-flex flex-column position-static" >
                                <h3 class="mb-3">', $value["foodName"], '</h3>

                                <p class="card-text mb-auto">', $value["foodDescription"], '</p>
                                <div class="mb-1 text-muted"  ><p style="display: inline; text-align: left;">', number_format((float)$value['price'], 2, '.', ''), ' CHF</p> 
                                <form style="float: right;" action="" method="POST">
                                 ',$button,'
                                </form>

                                </div>

                            </div>

                        </div>
                    </div>
                ';
                } ?>
            </div>

            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
<script>
    function newProduct() {

    }
</script>

</html>