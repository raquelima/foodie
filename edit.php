<?php
include('include/dbconnector.inc.php');
$editError = '';
$error = '';
$message = '';
$restaurantName = $website = $description = $address = $deliveryFrom = $deliveryUntil = '';

if (isset($_POST['editedRestaurant']) && is_numeric($_POST['editedRestaurant'])) {

    if (isset($_POST['restaurantName'])) {
        //trim and sanitize
        $restaurantName = htmlspecialchars(trim($_POST['restaurantName']));

        // Prüfung username
        if (empty($restaurantName) || strlen($restaurantName) > 60) {
            $editError .= "Invalid restaurant name. ";
        }
    } else {
        $editError .= "Invalid restaurant name";
    }
    if (isset($_POST['description'])) {
        //trim and sanitize
        $description = htmlspecialchars(trim($_POST['description']));

        // Prüfung username
        if (empty($description) || strlen($description) > 40) {
            $editError .= "Invalid restaurant description. ";
        }
    } else {
        $editError .= "Invalid restaurant description = {$description}";
    }
    if (isset($_POST['address'])) {
        //trim and sanitize
        $address = htmlspecialchars(trim($_POST['address']));

        // Prüfung username
        if (empty($address) || strlen($address) > 256) {
            $editError .= "Invalid address. ";
        }
    } else {
        $editError .= "Invalid address";
    }
    if (isset($_POST['website'])) {
        //trim and sanitize
        $website = htmlspecialchars(trim($_POST['website']));

        // Prüfung username
        if (empty($website) || strlen($website) > 256) {
            $editError .= "Invalid website. = {$website} ";
        }
    } else {
        $editError .= "Invalid website";
    }
    if (isset($_POST['deliveryFrom'])) {
        //trim and sanitize
        $deliveryFrom = htmlspecialchars(trim($_POST['deliveryFrom']));

        // Prüfung username
        if (empty($deliveryFrom) || !is_numeric($deliveryFrom) || $deliveryFrom < 0) {
            $editError .= "Invalid delivery duration. ";
        }
    } else {
        $editError .= "Invalid delivery duration";
    }
    if (isset($_POST['deliveryUntil'])) {
        //trim and sanitize
        $deliveryUntil = htmlspecialchars(trim($_POST['deliveryUntil']));

        // Prüfung username
        if (empty($deliveryUntil) || !is_numeric($deliveryUntil) || $deliveryUntil < 0) {
            $editError .= "Invalid delivery duration. ";
        }
    } else {
        $editError .= "Invalid delivery duration";
    }
    $restaurantID = $_POST['editedRestaurant'];
    if (empty($editError)) {
        // Query erstellen            
        $query = "UPDATE `restaurants` SET `name` = ?, `description` = ?, `place` = ?, `website` = ?, `delivery-from` = ?, `delivery-until` = ? WHERE `restaurants`.`id` = ?;";

        $stmt = $mysqli->prepare($query);

        if ($stmt === false) {
            $error .= 'prepare() failed ' . $mysqli->error . '<br />';
        }
        // Parameter an Query binden

        if (!$stmt->bind_param('ssssiii', $restaurantName, $description, $address, $website, $deliveryFrom, $deliveryUntil, $restaurantID)) {
            $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
        }

        // Query ausführen

        if (!$stmt->execute()) {
            $error .= 'execute() failed ' . $mysqli->error . '<br />';
        } else {
            $message .= 'Datensatz erfolgreich geändert.';
        }

        echo "<script>
        window.onload = function() {
        window.location.href = 'http://localhost/foodie/restaurant.php?id={$restaurantID}';
       }
       </script>";
    }
    if (!empty($editError)) {
        echo "<script>
        window.onload = function() {
        window.location.href = 'http://localhost/foodie/restaurant.php?id={$restaurantID}&err=" . $editError . "';
       }
       </script>";
    }
} else {
    echo "<script>
        window.onload = function() {
        window.location.href = 'http://localhost/foodie/index.php';
       }
       </script>";
}
