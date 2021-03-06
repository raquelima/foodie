<?php
include('include/dbconnector.inc.php');
$error = '';
$message = '';
$food = $foodDescription = $foodPrice = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addFoodForm']) && is_numeric($_POST['addFoodForm'])) {
        if (isset($_POST['foodName'])) {
            //trim and sanitize
            $foodName = htmlspecialchars(trim($_POST['foodName']));

            // Prüfung username
            if (empty($foodName) || strlen($foodName) > 60) {
                $error .= "Invalid food name. ";
            }
        } else {
            $error .= "Invalid food name";
        }
        if (isset($_POST['foodDescription'])) {
            //trim and sanitize
            $foodDescription = htmlspecialchars(trim($_POST['foodDescription']));

            // Prüfung username
            if (empty($foodDescription) || strlen($foodDescription) > 512) {
                $error .= "Invalid food description. ";
            }
        } else {
            $error .= "Invalid food description";
        }
        if (isset($_POST['foodPrice'])) {
            //trim and sanitize
            $foodPrice = htmlspecialchars(trim($_POST['foodPrice']));

            // Prüfung username
            if (empty($foodPrice) || !is_numeric($foodPrice) || $foodPrice < 0) {
                $error .= "Invalid food price. ";
            }
        } else {
            $error .= "Invalid food price";
        }
        $restaurantID = $_POST['addFoodForm'];

        if (empty($error)) {
            $query = "INSERT INTO food (restaurantID, foodName, foodDescription, price) VALUES (?, ?, ?, ?);";

            $stmt = $mysqli->prepare($query);
            if ($stmt === false) {
                $error .= 'prepare() failed ' . $mysqli->error . '<br />';
            }

            if (!$stmt->bind_param('issd', $restaurantID, $foodName, $foodDescription, $foodPrice)) {
                $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
            }

            $stmt->execute();

            $stmt->close();


            echo "<script>
             window.onload = function() {
             window.location.href = 'http://localhost/foodie/restaurant.php?id={$restaurantID}';
            }
            </script>";
        }
        if (!empty($error)) {
            echo "<script>
             window.onload = function() {
             window.location.href = 'http://localhost/foodie/restaurant.php?id={$restaurantID}&err=" . $error . "';
            }
            </script>";
        }
    }
} else {
    echo "<script>
             window.onload = function() {
             window.location.href = 'http://localhost/foodie/index.php';
            }
            </script>";
}
