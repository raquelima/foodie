<?php

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
            $error .= "The username does not match the required format.<br />";
        }
    } else {
        $error .= "Please enter the username.<br />";
    }
    // password
    if (isset($_POST['password'])) {
        //trim and sanitize
        $password = htmlspecialchars(trim($_POST['password']));
        // passwort gültig?
        if (empty($password) || !preg_match("/(?=^.{8,255}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $password)) {
            $error .= "The password does not match the required format.<br />";
        }
    } else {
        $error .= "Please enter the password.<br />";
    }

    // kein Fehler
    if (empty($error)) {
        // Query erstellen
        $query = "SELECT id, username, password, admin from users where username = ?";

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
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $username;
                $_SESSION['loggedin'] = true;
                $_SESSION['isAdmin'] = $row['admin'];
                $_SESSION['products'] = array();
                

                // Session ID regenerieren
               session_regenerate_id(true);

                // weiterleiten auf index.php
                header("location: index.php");

                // Script beenden
                die();
            } else {
                $error .= "Username or password are incorrect";
                echo '<script>
                window.onload = function(){
                      document.getElementById("loginBtn").click(); // Click on the login button
            
                }
            </script>';
            }
        } else {
            $error .= "Username or password are incorrect";
            echo '<script>
                window.onload = function(){
                      document.getElementById("loginBtn").click(); // Click on the login button
            
                }
            </script>';
        }
    }
}

?>

<div class="modal fade modal-signin " tabindex="-1" role="dialog" id="modalSignin" aria-hidden="true" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-5 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h2 class="fw-bold mb-0">Log in</h2>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-5 pt-0">
                <?php
                // fehlermeldung oder nachricht ausgeben
                if (!empty($message)) {
                    echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
                } else if (!empty($error)) {
                    if(isset($_POST["loginErr"])){
                        echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
                    }
                }
                ?>
                <form action="" method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" name="username" class="form-control rounded-4" id="username" placeholder="Password" pattern="(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,}" maxlength="30" required="true">
                        <label for="username">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control rounded-4" id="password" placeholder="Password" pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" maxlength="255" required="true">
                        <label for="floatingPassword">Password</label>
                        <input type="text" hidden name="loginErr" value="1">
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-4 btn-warning btn btn-info" name="button" value="submit" type="submit">Log in</button>
                    <small class="text-muted">Use your Foodie account.<br>Don't have a Foodie account? <a href="" class="" data-toggle="modal" data-target="#modalSignup">Create one</a></small>
                </form>
            </div>
        </div>
        
    </div>
</div>
