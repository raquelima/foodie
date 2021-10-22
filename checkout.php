<?php

// Sessionhandling starten
session_start();
$products = explode(" ", trim($_POST['orderText']));
//Datenbank verbinden
include('include/dbconnector.inc.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foodie</title>

    <link rel="shortcut icon" href="images/7.png" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/aa92474866.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin-style.css">

</head>
</head>

<body class='bg-light'>

    <div class='container'>
        <main>
            <div class='py-5 text-center'>
                <img class='d-block mx-auto mb-4' src='images/6.png' alt='' width='80' height='80'>
                <h2>Checkout form</h2>
                <p class='lead'>All the items you would like to purchase</p>
            </div>

            <div class='row g-5'>
                <div class='col-md-5 col-lg-4 order-md-last'>
                    <h4 class='d-flex justify-content-between align-items-center mb-3'>
                        <span class='text-primary'>Your cart</span>
                        <span class='badge bg-primary rounded-pill'><?php echo count($products) ?></span>
                    </h4>
                    <ul class='list-group mb-3'>
                        <?php
                        foreach ($products as $key => $value) {

                            $query = "select * from food where foodID = {$value};";

                            $stmt = $mysqli->prepare($query);

                            $stmt->execute();

                            $result = $stmt->get_result();
                            
                            foreach ($result as $food) {
                                $totalPrice += $food['price'];
                                $totalPrice = number_format((float)$totalPrice, 2, '.', '');
                                $price = number_format((float)$food['price'], 2, '.', '');
                                echo " <li class='list-group-item d-flex justify-content-between lh-sm'>
                                            <div>
                                                <h6 class='my-0'>{$food['foodName']}</h6>
                                            </div>
                                            <span class='text-muted'>{$price} CHF</span>
                                        </li>";
                            }
                        }
                        ?>
                    </ul>

                    <li class='list-group-item d-flex justify-content-between'>
                        <span>Total</span>
                        <strong><?php echo $totalPrice; ?> CHF</strong>
                    </li>

                </div>
                <div class='col-md-7 col-lg-8'>
                    <h4 class='mb-3'>Shipping address</h4>
                    <form class='needs-validation' novalidate>

                        <div class="col-md-3">
                            <label for="title" class="form-label">Title</label>
                            <select class="form-select" id="title" required>
                                <option value="">Choose...</option>
                                <option>Herr</option>
                                <option>Frau</option>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid title.
                            </div>
                        </div>
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
                            $street = $value['street'];
                            $city = $value['city'];
                            $state = $value['state'];
                            $zip = $value['zip'];


                            echo "<div class='row g-3'>
                            <div class='col-sm-6'>
                                <label for='firstName' class='form-label'>First name</label>
                                <input type='text' class='form-control' id='firstName' value='{$firstname}' placeholder='' maxlength='30'required>
                                <div class='invalid-feedback'>
                                    Valid first name is required.
                                </div>
                            </div>

                            <div class='col-sm-6'>
                                <label for='lastName' class='form-label'>Last name</label>
                                <input type='text' class='form-control' id='lastName' placeholder='' value='{$lastname}' maxlength='30' required>
                                <div class='invalid-feedback'>
                                    Valid last name is required.
                                </div>
                            </div>

                            <div class='col-12'>
                                <label for='address' class='form-label'>Street</label>
                                <input type='text' class='form-control' id='address' placeholder='Binningerstrasse 9' value='{$street}' maxlength='100' required>
                                <div class='invalid-feedback'>
                                    Please enter your shipping address.
                                </div>
                            </div>

                            <div class='col-md-4'>
                                <label for='state' class='form-label'>State</label>
                                <input type='text' class='form-control' id='state' placeholder='' value='{$state}' maxlength='30' required>
                                <div class='invalid-feedback'>
                                    State required.
                                </div>
                            </div>

                            <div class='col-md-4'>
                                <label for='city' class='form-label'>City</label>
                                <input type='text' class='form-control' id='city' placeholder='' value='{$city}' maxlength='30' required>
                                <div class='invalid-feedback'>
                                    city required.
                                </div>
                            </div>

                            <div class='col-md-4'>
                                <label for='zip' class='form-label'>Zip</label>
                                <input type='text' class='form-control' id='zip' placeholder='' value='{$zip}' maxlength='4' required>
                                <div class='invalid-feedback'>
                                    Zip code required.
                                </div>
                            </div>
                        </div>";
                        }
                        ?>


                        <hr class="my-4">

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="same-address">
                            <label class="form-check-label" for="same-address">Shipping address is the same as my billing address</label>
                        </div>

                        <hr class="my-4">

                        <h4 class="mb-3">Payment</h4>

                        <div class="my-3">
                            <div class="form-check">
                                <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
                                <label class="form-check-label" for="credit">Credit card</label>
                            </div>
                            <div class="form-check">
                                <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>
                                <label class="form-check-label" for="debit">Debit card</label>
                            </div>
                        </div>

                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label for="cc-name" class="form-label">Name on card</label>
                                <input type="text" class="form-control" id="cc-name" placeholder="" required>
                                <small class="text-muted">Full name as displayed on card</small>
                                <div class="invalid-feedback">
                                    Name on card is required
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="cc-number" class="form-label">Credit card number</label>
                                <input type="text" class="form-control" id="cc-number" placeholder="" required>
                                <div class="invalid-feedback">
                                    Credit card number is required
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="cc-expiration" class="form-label">Expiration</label>
                                <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                                <div class="invalid-feedback">
                                    Expiration date required
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="cc-cvv" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                                <div class="invalid-feedback">
                                    Security code required
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <button class="w-100 btn btn-primary btn-lg" type="">Pay</button>
                    </form>
                </div>
            </div>
        </main>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; 2021 Foodie</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Privacy</a></li>
                <li class="list-inline-item"><a href="#">Terms</a></li>
                <li class="list-inline-item"><a href="#">Support</a></li>
            </ul>
        </footer>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    <script src="form-validation.js"></script>
</body>




</html>