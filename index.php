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
    <title>Login</title>

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
                <h1 class="fw-light">Foodie</h1>
                <p class="lead text-muted">Finde die besten Restaurants, die Lieferungen anbieten. Kontaktlose Lieferung von Bestellungen von Restaurants, Lebensmitteln und vieles mehr!</p>
                <p>
                    <a href="" class="btn btn-primary my-2" data-toggle="modal" data-target="#modalSignup">Register</a>
                    <a href="" class="btn btn-secondary my-2" data-toggle="modal" data-target="#modalSignin">Log in</a>
                </p>
            </div>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php

                include('include/dbconnectorRestaurants.inc.php');

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
                            <a onclick='goTo(", $value["id"], ")' href='' class='stretched-link' >View</a>
                            <small class='text-muted'>", $value["delivery-from"], "-", $value["delivery-until"], " Min</small>
                            </div>
                        </div>
                    </div>
                </div>";
                }


                ?>

                <a href="" onclick="goTo(4)">resr</a>

            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
<script>
    function goTo(id) {
        var myform = document.createElement("form");
        myform.action = "restaurant.php";
        myform.method = "post";


        product = document.createElement("input");
        product.value = id;
        product.name = "restaurantID";

        myform.appendChild(product);
        myform.submit();
    }
</script>

</html>