<?php

$error = '';
$restaurantName = $website = $description = $address = $from = $until = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['restaurantName'])) {
        $restaurantName = trim(htmlspecialchars($_POST['restaurantName']));
        if (empty($restaurantName) || strlen($restaurantName) > 60) {
            $error .= " Invalid Restaurant Name";
        }
    } else {
        $error .= " Invalid Restaurant Name";
    }
    if (isset($_POST['website'])) {
        $website = trim(htmlspecialchars($_POST['website']));
        if (empty($website) || strlen($website) > 256) {
            $error .= " Invalid website";
        }
    } else {
        $error .= " Invalid website";
    }
    if (isset($_POST['description'])) {
        $description = trim(htmlspecialchars($_POST['description']));
        if (empty($description) || strlen($description) > 40) {
            $error .= " Invalid description";
        }
    } else {
        $error .= " Invalid description ";
    }
    if (isset($_POST['address'])) {
        $address = trim(htmlspecialchars($_POST['address']));
        if (empty($address) || strlen($address) > 256) {
            $error .= " Invalid address";
        }
    } else {
        $error .= " Invalid address";
    }
    if (isset($_POST['from'])) {
        $from = trim(htmlspecialchars($_POST['from']));
        if (empty($from) || !is_numeric($from)) {
            $error .= " Invalid from";
        }
    } else {
        $error .= " Invalid from";
    }
    if (isset($_POST['until'])) {
        $until = trim(htmlspecialchars($_POST['until']));
        if (empty($until) || !is_numeric($until)) {
            $error .= " Invalid until";
        }
    } else {
        $error .= " Invalid until";
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
                    echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
                } else if (!empty($error)) {
                    echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
                }
                ?>
                <form class="row" action="#" method="POST" id="addRestaurantForm">
                    <div class="form-floating col-md-6 mb-3">
                        <input type="text" name="restaurantName" class="form-control rounded-4" id="restaurantName" placeholder="Restaurant Name" maxlength="60" required>
                        <label class="px-4" for="restaurantName">Restaurant Name</label>
                    </div>
                    <div class="form-floating col-md-6 mb-3">
                        <input type="text" name="website" class="form-control rounded-4" id="website" placeholder="Website (https://www.myRestaurant.com)" maxlength="256" required>
                        <label class="px-4">Website</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea name="description" style="height: 300px;" class="form-control rounded-4" id="description" placeholder="Description" maxlength="40" cols="30" rows="10" required></textarea>
                        <label class="px-4" for="description">Description</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="address" class="form-control rounded-4" id="address" placeholder="Address" maxlength="256" required>
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