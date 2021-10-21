<?php

// Sessionhandling starten
session_start();

//Datenbank verbinden
include('include/dbconnector.inc.php');
// Initialisierung
$error = $message =  '';
$firstname = $lastname = $email = $username = $password = $street = $city = $state = $zip ='';

// Wurden Daten mit "POST" gesendet?
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    print_r($_POST);
    // Vorname ausgefüllt?
    if (isset($_POST['firstname'])) {
        //trim and sanitize
        $firstname = htmlspecialchars(trim($_POST['firstname']));

        //mindestens 1 Zeichen und maximal 30 Zeichen lang
        if (empty($firstname) || strlen($firstname) > 30) {
            $error .= "Geben Sie bitte einen korrekten Vornamen ein.<br />";
        }
    } else {
        $error .= "Geben Sie bitte einen Vornamen ein.<br />";
    }

    // Nachname ausgefüllt?
    if (isset($_POST['lastname'])) {
        //trim and sanitize
        $lastname = htmlspecialchars(trim($_POST['lastname']));

        //mindestens 1 Zeichen und maximal 30 Zeichen lang
        if (empty($lastname) || strlen($lastname) > 30) {
            $error .= "Geben Sie bitte einen korrekten Nachname ein.<br />";
        }
    } else {
        $error .= "Geben Sie bitte einen Nachname ein.<br />";
    }

    // Email ausgefüllt?
    if (isset($_POST['email'])) {
        //trim an sanitize
        $email = htmlspecialchars(trim($_POST['email']));

        //mindestens 1 Zeichen und maximal 100 Zeichen lang, gültige Emailadresse
        if (empty($email) || strlen($email) > 100 || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $error .= "Geben Sie bitte eine korrekten Emailadresse ein.<br />";
        }
    } else {
        $error .= "Geben Sie bitte eine Emailadresse ein.<br />";
    }

    // Username ausgefüllt?
    if (isset($_POST['username'])) {
        //trim and sanitize
        $username = htmlspecialchars(trim($_POST['username']));

        //mindestens 1 Zeichen , entsprich RegEX
        if (empty($username) || !preg_match("/(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,30}/", $username)) {
            $error .= "Geben Sie bitte einen korrekten Usernamen ein.<br />";
        }
    } else {
        $error .= "Geben Sie bitte einen Username ein.<br />";
    }

    // Passwort ausgefüllt
    if (isset($_POST['password'])) {
        //trim and sanitize
        $password = trim($_POST['password']);

        //mindestens 1 Zeichen , entsprich RegEX
        if (empty($password) || !preg_match("/(?=^.{8,255}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $password)) {
            $error .= "Geben Sie bitte einen korrektes Password ein.<br />";
        }
    } else {
        $error .= "Geben Sie bitte ein Password ein.<br />";
    }

    // street ausgefüllt
    if (isset($_POST['street'])) {
        //trim and sanitize
        $street = trim($_POST['street']);

        //mindestens 1 Zeichen und maximal 100 Zeichen lang
        if (empty($street) || strlen($street) > 100) {
            $error .= "Geben Sie bitte eine korrektes Strasse ein.<br />";
        }
    } else {
        $error .= "Geben Sie bitte eine Strasse ein.<br />";
    }

    // city ausgefüllt
    if (isset($_POST['city'])) {
        //trim and sanitize
        $city = trim($_POST['city']);

        //mindestens 1 Zeichen und maximal 100 Zeichen lang
        if (empty($city) || strlen($city) > 30) {
            $error .= "Geben Sie bitte eine korrektes city ein.<br />";
        }
    } else {
        $error .= "Geben Sie bitte eine city ein.<br />";
    }

    // state ausgefüllt
    if (isset($_POST['state'])) {
        //trim and sanitize
        $state = trim($_POST['state']);

        //mindestens 1 Zeichen und maximal 100 Zeichen lang
        if (empty($state) || strlen($state) > 30) {
            $error .= "Geben Sie bitte eine korrektes state ein.<br />";
        }
    } else {
        $error .= "Geben Sie bitte eine state ein.<br />";
    }

     // zip ausgefüllt
     if (isset($_POST['zip'])) {
        //trim and sanitize
        $zip = trim($_POST['zip']);

        //mindestens 1 Zeichen und maximal 100 Zeichen lang
        if (empty($zip) || strlen($zip) > 4) {
            $error .= "Geben Sie bitte eine korrektes zip ein.<br />";
        }
    } else {
        $error .= "Geben Sie bitte eine zip ein.<br />";
    }

    // wenn kein Fehler vorhanden ist, schreiben der Daten in die Datenbank
    if (empty($error)) {
        // Password haschen
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Query erstellen
        $query = "UPDATE  users  SET firstname = ?, lastname = ?, username = ?, password = ?, email = ?, street = ?, city = ?, state = ?, zip = ? WHERE users.id = {$_SESSION['id']};";
//UPDATE `users` SET `firstname` = 'Elia', `lastname` = 'Matte', `username` = 'CoalPlay', `password` = '$2y$10$x/e0Q/6PgR0EY5F7gvKHpeH8DKBZca/IHCci.lzyW.xEPdku5.Lp', `email` = 'em2012@gmx.c', `street` = 'höldeliweg 2', `city` = 'Gelterkinde', `state` = 'Basellan', `zip` = '446' WHERE `users`.`id` = 1;

        // Query vorbereiten
        $stmt = $mysqli->prepare($query);
        if ($stmt === false) {
            $error .= 'prepare() failed ' . $mysqli->error . '<br />';
        }

        // Parameter an Query binden
        if (!$stmt->bind_param('sssssssss', $firstname, $lastname, $username, $password_hash, $email, $street, $city, $state, $zip)) {
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
            $username = $password = $firstname = $lastname = $email = $street = $city = $state = $zip ='';
            // Verbindung schliessen
            $mysqli->close();
            // Weiterleiten auf login.php
            echo '<script>
            window.onload = function() {
              location.replace("profile.php")
            }
            </script>';
            // beenden des Scriptes
            exit();
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
    <title>Profile</title>

    <link rel="shortcut icon" href="images/7.png" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/aa92474866.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <?php include('include/nav.php'); ?>

    <div class='container bootstrap snippets bootdeys' style='margin-top: 150px;'>
        <?php
        // fehlermeldung oder nachricht ausgeben
        if (!empty($message)) {
            echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
        } else if (!empty($error)) {
            echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
        }
        ?>

        <div class='row' id='user-profile'>
            <?php

            $query = "SELECT * FROM users WHERE {$_SESSION['id']}=id;";


            $stmt = $mysqli->prepare($query);

            $stmt->execute();

            $result = $stmt->get_result();

            foreach ($result as $value) {
                $firstname = $value['firstname'];
                $lastname = $value['lastname'];
                $email = $value['email'];
                $username = $value['username'];
                $password = '';
                $street = $value['street'];
                $city = $value['city'];
                $state = $value['state'];
                $zip = $value['zip'];

                echo "<div class='col-lg-3 col-md-4 col-sm-4'>
                <div class='main-box clearfix'>
                    <h2>{$firstname} {$lastname} </h2>
                    <img src='http://dipsinternational.com/wp-content/uploads/2017/03/user-icon-fontawesome.png' alt='' class='profile-img img-responsive center-block'>
                    <div class='profile-label'>";

                if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
                    echo "<span class='label label-danger'>Admin</span>";
                } else {
                    echo "<span class='label label-danger'>User</span>";
                }
                echo "
                        
                    </div>

                    <div class='profile-since'>
                        Member since: Jan 2012
                    </div>

                    <div class='profile-details'>
                        <ul class='fa-ul'>
                            <li><i class='fa-li fa fa-truck'></i>Orders: <span>456</span></li>

                        </ul>
                    </div>

                    <div class='profile-message-btn center-block text-center'>
                        <button id='editBtn' onclick='showUpdate()' href='' class='btn btn-warning edit-profile'>
                            <i class='fa fa-pencil-square fa-lg'></i> Edit profile
                        </button>
                    </div>
                </div>
            </div>

            <div class='col-lg-9 col-md-8 col-sm-8'>
                <div class='main-box clearfix'>
                    <div class='profile-header'>
                        <h3><span>User info</span></h3>
                    </div>
                    <form id='profileForm' action='' method='POST'>

                    <div class='row gutters'>
                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
                            <h6 class='mb-3 text-primary'>Personal Details</h6>
                        </div>
                        <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'>
                            <div class='form-group'>
                                <label for='firstname'>First Name</label>
                                <input type='text' class='form-control' name='firstname' id='firstname' value='{$firstname}' placeholder='' maxlength='30' required='true' disabled>
                            </div>
                        </div>
                        <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'>
                            <div class='form-group'>
                                <label for='lastname'>Last Name</label>
                                <input type='text' class='form-control' name='lastname' id='lastname' value='{$lastname}' placeholder='' maxlength='30' required='true' disabled>
                            </div>
                        </div>
                        <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'>
                            <div class='form-group'>
                                <label for='email'>Email</label>
                                <input type='email' class='form-control' name='email' id='email' value='{$email}' placeholder='' maxlength='100' required='true' disabled>
                            </div>
                        </div>
                        <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'>
                            <div class='form-group' style='margin-top: 10px;'>
                                <label for='username'>Username</label>
                                <input type='text' class='form-control' name='username' id='username' value='{$username}' pattern='(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,}' placeholder='' maxlength='30' required='true' disabled>
                            </div>
                        </div>
                        <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'>
                            <div class='form-group' style='margin-top: 10px;'>
                                <label for='password'>Password</label>
                                <input type='password' class='form-control' name='password' value='{$password}' id='password' pattern='(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$' placeholder='' maxlength='255' required='true' disabled>
                            </div>
                        </div>
                    </div>
                    <div class='row gutters'>
                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
                            <h6 class='mb-3 text-primary'>Address</h6>
                        </div>
                        <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'>
                            <div class='form-group'>
                                <label for='street'>Street</label>
                                <input type='name' class='form-control' name='street' id='street' value='{$street}' placeholder='Enter Street' maxlength='100' disabled>
                            </div>
                        </div>
                        <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'>
                            <div class='form-group'>
                                <label for='city'>City</label>
                                <input type='name' class='form-control' name='city' id='city' value='{$city}' placeholder='Enter City' maxlength='30' disabled>
                            </div>
                        </div>
                        <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'>
                            <div class='form-group' style='margin-top: 10px;'>
                                <label for='state'>State</label>
                                <input type='text' class='form-control' name='state' id='state' value='{$state}' placeholder='Enter State' maxlength='30' disabled>
                            </div>
                        </div>
                        <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'>
                            <div class='form-group' style='margin-top: 10px;'>
                                <label for='zip'>Zip Code</label>
                                <input type='text' class='form-control' name='zip' id='zip' value='{$zip}' placeholder='Zip Code' maxlength='4' disabled>
                            </div>
                        </div>

                    </div>
                    </form>

                    <div class='row gutters'>
                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
                            <div id='update' class='text-right' style='display: none;'>
                                <button form='profileForm'  type='submit' class='btn btn-primary'>Update</button>

                            </div>
                        </div>
                    </div>

                </div>

            </div>";
            }
            ?>

        </div>
    </div>

    <script>
        function showUpdate() {
            const targetDiv = document.getElementById("update");

            const username = document.getElementById("username");

            if (username.disabled != true) {
                username.disabled = true;
                document.getElementById("firstname").disabled = true;
                document.getElementById("lastname").disabled = true;
                document.getElementById("email").disabled = true;
                document.getElementById("password").disabled = true;
                document.getElementById("street").disabled = true;
                document.getElementById("city").disabled = true;
                document.getElementById("state").disabled = true;
                document.getElementById("zip").disabled = true;

            } else {
                username.disabled = false;
                document.getElementById("firstname").disabled = false;
                document.getElementById("lastname").disabled = false;
                document.getElementById("email").disabled = false;
                document.getElementById("password").disabled = false;
                document.getElementById("street").disabled = false;
                document.getElementById("city").disabled = false;
                document.getElementById("state").disabled = false;
                document.getElementById("zip").disabled = false;

            }


            if (targetDiv.style.display !== "none") {
                targetDiv.style.display = "none";
            } else {
                targetDiv.style.display = "block";
            }


        }
    </script>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>