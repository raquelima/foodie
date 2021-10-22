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


                // Session ID regenerieren
                session_regenerate_id(true);

                // weiterleiten auf index.php
                header("location: index.php");

                // Script beenden
                die();
            } else {
                $error .= "Benutzername oder Passwort sind falsch";
                echo '<script>
                window.onload = function(){
                      document.getElementById("loginBtn").click(); // Click on the login button
            
                }
            </script>';
            }
        } else {
            $error .= "Benutzername oder Passwort sind falsch";
            echo '<script>
                window.onload = function(){
                      document.getElementById("loginBtn").click(); // Click on the login button
            
                }
            </script>';
        }
    }
}

?>

<div class="modal fade" tabindex="-1" role="dialog" id="modalDelete" aria-hidden="true" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-lg rounded-5 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h2 class="fw-bold mb-0">Delete Restaurant</h2>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-5 pt-0">
                <?php
                // fehlermeldung oder nachricht ausgeben
                if (!empty($message)) {
                    echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
                } else if (!empty($error)) {
                    echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
                }
                ?>
                <div class="form-floating mb-3">
                    <p>Are you sure you want to <strong style='color: #9C3848;'>DELETE</strong> this restaurant?</p>
                </div>
                <form action="deleteRestaurant.php" method="POST">
                    <button class="w-100 mb-2 btn btn-lg rounded-4 btn-danger btn btn-info" name="deleteRestaurant" value="<?php echo $_GET["id"] ?>" type="submit">Delete Restaurant</button>
                </form>

            </div>
        </div>

    </div>
</div>