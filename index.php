<?php

// Sessionhandling starten
session_start();

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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">FOODIE</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <?php
                //wenn Session personalisiert
                if (isset($_SESSION['loggedin'])) {
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                } else {
                    //wenn Session nicht personalisiert
                    echo '<li class="nav-item"><a class="nav-link" href="registration.php">Registrierung</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="" data-toggle="modal" data-target="#modalSignin">Login</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>

    <div class="modal fade" id="modalSignin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Sign in</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        <i class="fas fa-envelope prefix grey-text"></i>
                        <input type="email" id="defaultForm-email" class="form-control validate">
                        <label data-error="wrong" data-success="right" for="defaultForm-email">Your email</label>
                    </div>

                    <div class="md-form mb-4">
                        <i class="fas fa-lock prefix grey-text"></i>
                        <input type="password" id="defaultForm-pass" class="form-control validate">
                        <label data-error="wrong" data-success="right" for="defaultForm-pass">Your password</label>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-default">Login</button>
                </div>
            </div>
        </div>
    </div>

    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">Foodie</h1>
                <p class="lead text-muted">Finde die besten Restaurants, die Lieferungen anbieten. Kontaktlose Lieferung von Bestellungen von Restaurants, Lebensmitteln und vieles mehr!</p>
                <p>
                    <a href="registration.php" class="btn btn-primary my-2">Register</a>
                    <a href="login.php" class="btn btn-secondary my-2">Log in</a>
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