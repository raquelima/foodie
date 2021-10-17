<?php

// Sessionhandling starten
session_start();

// Datenbankverbindung
include('include/dbconnector.inc.php');

$error = '';
$message = '';
$username = $password = '';


// Formular wurde gesendet und Besucher ist noch nicht angemeldet.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // username
    if (isset($_POST['username'])) {
        //trim and sanitize
        $username = htmlspecialchars(trim($_POST['username']));

        // Prüfung username
        if (empty($username) || !preg_match("/(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,30}/", $username)) {
            $error .= "Der Benutzername entspricht nicht dem geforderten Format.<br />";
        }
    } else {
        $error .= "Geben Sie bitte den Benutzername an.<br />";
    }
    // password
    if (isset($_POST['password'])) {
        //trim and sanitize
        $password = trim($_POST['password']);
        // passwort gültig?
        if (empty($password) || !preg_match("/(?=^.{8,255}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $password)) {
            $error .= "Das Passwort entspricht nicht dem geforderten Format.<br />";
        }
    } else {
        $error .= "Geben Sie bitte das Passwort an.<br />";
    }

    // kein Fehler
    if (empty($error)) {
        // Query erstellen
        $query = "SELECT id, username, password from users where username = ?";

        // Query vorbereiten
        $stmt = $mysqli->prepare($query);
        if ($stmt === false) {
            $error .= 'prepare() failed ' . $mysqli->error . '<br />';
        }
        // Parameter an Query binden
        if (!$stmt->bind_param("s", $username)) {
            $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
        }
        // Query ausführen
        if (!$stmt->execute()) {
            $error .= 'execute() failed ' . $mysqli->error . '<br />';
        }
        // Daten auslesen
        $result = $stmt->get_result();

        // Userdaten lesen
        if ($row = $result->fetch_assoc()) {

            // Passwort ok?
            if (password_verify($password, $row['password'])) {

                // Session personifizieren
                $_SESSION['username'] = $username;
                $_SESSION['loggedin'] = true;

                // Session ID regenerieren
                $_SESSION['userid'] = session_regenerate_id(true);

                // weiterleiten auf admin.php
                header("location: admin.php");

                // Script beenden
                die();
            } else {
                $error .= "Benutzername oder Passwort sind falsch";
            }
        } else {
            $error .= "Benutzername oder Passwort sind falsch";
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
    <title>Login</title>

    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
            <ul class="navbar-nav mr-auto ml-auto">
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </ul>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <?php
                //wenn Session personalisiert
                if (isset($_SESSION['loggedin'])) {
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                } else {
                    //wenn Session nicht personalisiert
                    echo '<li class="nav-item"><a class="nav-link" href="registration.php">Registrierung</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>

    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">Restaurant</h1>
                <p class="lead text-muted">Finde die besten Restaurants, die Lieferungen anbieten. Kontaktlose Lieferung von Bestellungen von Restaurants, Lebensmitteln und vieles mehr!</p>
                <p>
                    <a href="registration.php" class="btn btn-primary my-2">More</a>
                </p>
            </div>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <div class="col">
                    <div class="card shadow-sm">
                        <svg class="bd-placeholder-img card-img-top" width="100%" height="230" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false">
                            <title>Placeholder</title>
                            <image href="images/mc.jpg" height="100%" width="100%" />
                        </svg>

                        <div class="card-body">
                            <p class="card-text">McDonald's®</p>
                            <p class="card-text">Burgers • American • Fast Food<br>Centralbahnstrasse 9, 4051</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="#" class="stretched-link">View</a>
                                <small class="text-muted">15-25 Min</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <svg class="bd-placeholder-img card-img-top" width="100%" height="230" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false">
                            <title>Placeholder</title>
                            <image href="images/subway.jpeg" height="100%" width="100%" />
                        </svg>

                        <div class="card-body">
                            <p class="card-text">Subway®</p>
                            <p class="card-text">Sandwich • American<br>Centralbahnpl. 6, 4051</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="#" class="stretched-link">View</a>
                                <small class="text-muted">30-40 Min</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <svg class="bd-placeholder-img card-img-top" width="100%" height="230" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false">
                            <title>Placeholder</title>
                            <image href="images/king.jpeg" height="100%" width="100%" />
                        </svg>

                        <div class="card-body">
                            <p class="card-text">Burger King</p>
                            <p class="card-text">American • Fast Food • Burgers<br>Steinenvorstadt 51, 4051</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="#" class="stretched-link">View</a>
                                <small class="text-muted">35-45 Min</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>