<?php

// Sessionhandling starten
session_start();

if (isset($_GET["err"])) {
    echo "<script>
             window.onload = function() {
                alert('{$_GET["err"]}')
                window.location.href = 'http://localhost/foodie/index.php';
            }
            </script>";
}

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

    <style>
        .bgimg {
            background-image: url('images/banner1.png');
            background-size: cover;
        }
    </style>

</head>

<body>
    <?php include('include/nav.php'); ?>

    <?php include('include/login.php'); ?>

    <?php include('include/registration.php'); ?>

    <div class="text-center bgimg">
        <div class="row py-lg-5 mx-auto">
            <div class="col-lg-6 col-md-8 mx-auto">
                <svg class="bi me-2" width="250" height="250" role="img" aria-label="Foodie">
                    <image href='images/6.png' height='100%' width='100%' />
                </svg>
                <p> </p>
                <?php

                //wenn Session personalisiert
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
                    echo '<p class="lead text">Welcome ', $_SESSION['username'], '!</p>';

                    if (isset($_SESSION['isAdmin']) and $_SESSION['isAdmin']) {

                        include('include/addRestaurantModal.php');
                        echo "<a href='' class='btn btn-dark my-2 text-warning' data-toggle='modal' data-target='#addRestaurantModal'>Create Restaurant</a>";
                    }
                } else {
                    //wenn Session nicht personifiziert
                    echo '<p class="lead text">Find the best restaurants that deliver.<br>Get contactless delivery for restaurant takeout, groceries, and more!</p>';
                    echo '<p>
                        <a href="" class="btn btn-warning my-2" data-toggle="modal" data-target="#modalSignup">Sign-up</a>
                        <a href="" class="btn btn-dark my-2" data-toggle="modal" data-target="#modalSignin">Login</a>
                    </p>';
                }
                ?>
            </div>
        </div>
    </div>

    <div class="album py-4 bg-light">
        <div class="container">

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php
                $query = "SELECT * FROM restaurants";

                $stmt = $mysqli->prepare($query);

                $stmt->execute();

                $result = $stmt->get_result();

                foreach ($result as $value) {
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
                        $btn = "<a href='restaurant.php?id={$value['id']}' class='text-warning stretched-link'>";
                    } else {
                        $btn = " <a class='text-warning stretched-link' onclick='errorLogin()'>";
                    }

                    echo "<div class='col'>
                    <div class='card shadow-sm'>
                        <svg class='bd-placeholder-img card-img-top' width='100%' height='230' role='img' preserveAspectRatio='xMidYMid slice' focusable='false'>
                            <title>Placeholder</title>
                            <image href='images/mc.jpg' height='100%' width='100%' />
                        </svg>

                        <div class='card-body'>
                            <h6 class='card-text'>", $value['name'], "</h6>
                            <p class='card-text'>", $value["description"], "<br>", $value["place"], "</p>
                            <div class='d-flex justify-content-between align-items-center'>
                            {$btn}View</a>
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
    <?php include('include/footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        function errorLogin() {
            alert("You must be logged in to visit Restaurants")
        }
    </script>
</body>


</html>