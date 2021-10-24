<?php

// Initialisierung
$error = $message =  '';
$firstname = $lastname = $email = $username = $password =  '';

// Wurden Daten mit "POST" gesendet?
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Vorname ausgefüllt?
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

    // Email ausgefüllt?
    if (isset($_POST['email'])) {
        //trim an sanitize
        $email = htmlspecialchars(trim($_POST['email']));

        //mindestens 1 Zeichen und maximal 100 Zeichen lang, gültige Emailadresse
        if (empty($email) || strlen($email) > 100 || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $error .= "Please enter a valid email.<br />";
        }
    } else {
        $error .= "Please enter an email.<br />";
    }

    // Username ausgefüllt?
    if (isset($_POST['username'])) {
        //trim and sanitize
        $username = htmlspecialchars(trim($_POST['username']));

        //mindestens 1 Zeichen , entsprich RegEX
        if (empty($username) || !preg_match("/(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,30}/", $username)) {
            $error .= "Please enter a valid username.<br />";
        }
    } else {
        $error .= "Please enter a username.<br />";
    }

    // Passwort ausgefüllt
    if (isset($_POST['password'])) {
        //trim and sanitize
        $password = htmlspecialchars(trim($_POST['password']));

        //mindestens 1 Zeichen , entsprich RegEX
        if (empty($password) || !preg_match("/(?=^.{8,255}$)((?=.*\d+)(?=.*\W+))[.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $password)) {
            $error .= "Please enter a valid password.<br />";
        }
    } else {
        $error .= "Please enter a username.<br />";
    }

    // wenn kein Fehler vorhanden ist, schreiben der Daten in die Datenbank
    if (empty($error)) {

        // Password haschen
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Query erstellen
        $query = "Insert into users (firstname, lastname, username, password, em) values (?,?,?,?,?)";

        // Query vorbereiten
        $stmt = $mysqli->prepare($query);
        if ($stmt === false) {
            $error .= 'prepare() failed ' . $mysqli->error . '<br />';
        }

        // Parameter an Query binden
        if (!$stmt->bind_param('sssss', $firstname, $lastname, $username, $password_hash, $email)) {
            $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
        }

        // Query ausführen
        if (!$stmt->execute()) {
            $error .= 'execute() failed ' . $mysqli->error . '<br />';
        }

        // kein Fehler!
        if (empty($error)) {
            $message .= "The data was successfully written to the database<br/ >";
            // Felder leeren und Weiterleitung auf anderes Script: z.B. Login!
            $username = $password = $firstname = $lastname = $email =  '';
            // Verbindung schliessen
            $mysqli->close();
            // Weiterleiten auf login.php
            echo '<script>
            window.onload = function() {
              location.replace("index.php")
            }
            </script>';
            // beenden des Scriptes
            exit();
        }
    }
}

?>

<div class="modal fade modal-signup" tabindex="-1" role="dialog" id="modalSignup" aria-hidden="true" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-5 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h2 class="fw-bold mb-0">Sign-up for free</h2>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-5 pt-0">
                <?php
                // fehlermeldung oder nachricht ausgeben
                if (!empty($message)) {
                    echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
                } else if (!empty($error)) {
                    if(isset($_POST["registrationErr"])){
                        echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
                    }
                    
                }
                ?>
                <form action="" method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" name="firstname" class="form-control rounded-4" id="firstname"  placeholder="First name" maxlength="30" required="true">
                        <label for="firstname">First name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="lastname" class="form-control rounded-4" id="lastname"  placeholder="Last name" maxlength="30" required="true">
                        <label for="lastname">Last name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control rounded-4" id="email"  placeholder="name@example.com" maxlength="100" required="true">
                        <label for="email">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="username" class="form-control rounded-4" id="username"  pattern="(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,}" placeholder="Password" maxlength="30" required="true">
                        <label for="username">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control rounded-4" id="password" pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Password" maxlength="255" required="true">
                        <label for="password">Password</label>
                        <input type="text" hidden name="registrationErr" value="1">
                    </div>
                    <button class="w-100 btn btn-lg rounded-4 btn-warning" name="button" value="submit" type="submit">Sign up</button>
                    <small class="text-muted">By clicking Sign up, you agree to the terms of use.</small>
                    <hr class="my-4">
                </form>
            </div>
        </div>
    </div>
</div>