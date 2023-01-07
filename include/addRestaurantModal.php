<?php

// Sessionhandling starten falls noch keine vorhanden ist
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if (!isset($_SESSION['isAdmin']) or !$_SESSION['isAdmin']) {
    echo '<script>
    window.onload = function() {
      location.replace("../index.php");
    }
    </script>';
}

$error = '';
$restaurantName = $website = $description = $address = $from = $until = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['restaurantName'])) {
        //trim and sanitize
        $restaurantName = trim(htmlspecialchars($_POST['restaurantName']));

        if (empty($restaurantName) || !preg_match("/(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{3,60}/", $restaurantName)) {
            $error .= " Invalid Restaurant Name";
        }
    } else {
        $error .= " Invalid Restaurant Name";
    }
    if (isset($_POST['website'])) {
        //trim and sanitize
        $website = trim(htmlspecialchars($_POST['website']));

        //gültige URL
        if (empty($website) || filter_var($website, FILTER_VALIDATE_URL) === false) {
            $error .= "Please enter a valid website.<br />";
        }
    } else {
        $error .= " Invalid website";
    }
    if (isset($_POST['description'])) {
        //trim and sanitize
        $description = trim(htmlspecialchars($_POST['description']));

        if (empty($description) || !preg_match("/(?=.*[a-z])[a-zA-Z]{3,130}/", $description)) {
            $error .= " Invalid description";
        }
    } else {
        $error .= " Invalid description ";
    }
    if (isset($_POST['address'])) {
        //trim and sanitize
        $address = trim(htmlspecialchars($_POST['address']));

        if (empty($address) || !preg_match("/[a-zA-Z]+\\s[0-9]+,\\s[0-9]{4,6}/i", $address)) {
            $error .= " Invalid address";
        }
    } else {
        $error .= " Invalid address";
    }
    if (isset($_POST['from'])) {
        //trim and sanitize
        $from = trim(htmlspecialchars($_POST['from']));

        if (empty($from) || !is_numeric($from) || $from < 0) {
            $error .= " Invalid delivery duration.";
        }
    } else {
        $error .= " Invalid delivery duration.";
    }
    if (isset($_POST['until'])) {
        //trim and sanitize
        $until = trim(htmlspecialchars($_POST['until']));

        if (empty($until) || !is_numeric($until) || $until < 0) {
            $error .= "Invalid delivery duration. ";
        }
    } else {
        $error .= "Invalid delivery duration";
    }

    if (empty($error)) {

        $query = "INSERT INTO `restaurants` (`name`, `description`, `place`, `website`, `delivery-from`, `delivery-until`) VALUES (?, ?, ?, ?, ?, ?)";

        // Query vorbereiten
        $stmt = $mysqli->prepare($query);
        if ($stmt === false) {
            $error .= 'prepare() failed ' . $mysqli->error . '<br />';
        }
        // Parameter an Query binden
        if (!$stmt->bind_param('ssssii', $restaurantName, $description, $address, $website, $from, $until)) {
            $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
        }
        // Query ausführen
        if (!$stmt->execute()) {
            $error .= 'execute() failed ' . $mysqli->error . '<br />';
        }
    }
}

?>
<?php if (isset($_SESSION['isAdmin']) and $_SESSION['isAdmin']) : ?>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="addRestaurantModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-lg rounded-5 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h2 class="fw-bold mb-0">Create Restaurant</h2>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-5 pb-5">
                <?php
                // fehlermeldung oder nachricht ausgeben
                if (!empty($message)) {
                    echo "<div class=\"alert alert-success\" role=\"alert\">" . htmlspecialchars($message) . "</div>";
                } else if (!empty($error)) {
                    echo "<div class=\"alert alert-danger\" role=\"alert\">" . htmlspecialchars($error) . "</div>";
                }
                ?>
                <form class="row" action="#" method="POST" id="addRestaurantForm">
                    <div class="form-floating col-md-6 mb-3">
                        <input type="text" name="restaurantName" class="form-control rounded-4" id="restaurantName" pattern='[A-Z a-z]{3,60}' placeholder="Restaurant Name" maxlength="60" required>
                        <label class="px-4" for="restaurantName">Restaurant Name</label>
                    </div>
                    <div class="form-floating col-md-6 mb-3">
                        <input type="text" name="website" class="form-control rounded-4" id="website" pattern='(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})' title='Example: https://www.myRestaurant.com' placeholder="Website (https://www.myRestaurant.com)" required>
                        <label class="px-4">Website</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="description" class="form-control rounded-4" id="description" pattern='[A-Z a-z]{3,130}' placeholder="Description" maxlength="130" required>
                        <label class="px-4" for="description">Description</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="address" class="form-control rounded-4" id="address" pattern='[a-z A-Z]+\s[0-9]+,\s[0-9]{4,6}' placeholder="Address" title='Example: Centralbahnstrasse 9, 4053' maxlength="256" required>
                        <label class="px-4">Address</label>
                    </div>
                    <div class="form-floating col-md-3 mb-3">
                        <input type="number" name="from" class="form-control rounded-4" id="from" placeholder="From" min="0" max="500" required>
                        <label class="px-4">Delivery From</label>
                    </div>
                    <div class="form-floating col-md-3 mb-3">
                        <input type="number" name="until" class="form-control rounded-4" id="until" placeholder="Until" min="0" max="500" required>
                        <label class="px-4">Delivery Until</label>
                    </div>
                    <div class="form-floating col-md-6" style="text-align: right;">
                        <button class="btn btn-lg btn-warning mt-1" name="addRestaurantForm" form="addRestaurantForm" type="submit">Add new restaurant</button>
                    </div>
                </form>
            </div>



        </div>

    </div>
</div>
<?php endif; ?>