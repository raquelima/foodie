<?php

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $error = '';
        $restaurantName = $website = $description = $address = $from = $until = '';
        
        if (isset($_POST['restaurantName'])) {
            $restaurantName = trim(htmlspecialchars($_POST['restaurantName']));
            if (empty($restaurantName) || strlen($restaurantName) > 60) {
                $error .= " Invalid Restaurant Name";
            }
        } else {
            $error .= " Invalid Restaurant Name";
        }
        if (isset($_POST['website'])) {
            $website = trim($_POST['website']);
            if (empty($website) || strlen($website) > 256) {
                $error .= " Invalid website";
            }
        } else {
            $error .= " Invalid website";
        }
        if (isset($_POST['description'])) {
            $description = trim(htmlspecialchars($_POST['description']));
            if (empty($description) || strlen($description) > 256) {
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
            echo '<script>
                window.onload = function(){
                    window.location.href = "index.php";
            
                }
            </script>';
        }
    }

    
    $result->free();

    $query = "SELECT * FROM restaurants";

    $stmt = $mysqli->prepare($query);

    $stmt->execute();

    $result = $stmt->get_result();
    if (strlen($error)) {
        echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
    }

    if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"]) {
        echo '<div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-12 col-sm-offset-2 col-sm-8">
                <form class="form-horizontal row" method="POST" action="">
                    <div class="form-icon "><i class="fa fa-plus-square" aria-hidden="true"></i></div>
                    <div class="form-group col-md-6 ">
                    </div>
                    <div class="form-group col-md-6 ">
                        <label>Restaurant Name</label>
                        <input class="form-control" type="Name" name="restaurantName" required="" placeholder="Restaurant Name">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Website</label>
                        <input class="form-control" type="Name" name="website" required="" placeholder="Website">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Description</label>
                        <input class="form-control" type="" name="description" required="" placeholder="Description" maxlength="512">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Address</label>
                        <input class="form-control" type="name" name="address" required="" placeholder="Address" maxlength="256">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Delivery From</label>
                        <input class="form-control" type="number" name="from" required="" placeholder="From">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Delivery Until</label>
                        <input class="form-control" type="number" name="until" required="" placeholder="Until">
                    </div>
                    <button type="submit" class="btn btn-default">Create Restaurant</button>
                </form>
            </div>
        </div>
    </div>';
    }


    ?>

    </div>