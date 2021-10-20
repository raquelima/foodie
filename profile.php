<?php

// Sessionhandling starten
session_start();

//Datenbank verbinden
include('include/dbconnector.inc.php');

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
                echo "<div class='col-lg-3 col-md-4 col-sm-4'>
                <div class='main-box clearfix'>
                    <h2>{$value['firstname']} {$value['lastname']} </h2>
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
                    <div class='row gutters'>
                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
                            <h6 class='mb-3 text-primary'>Personal Details</h6>
                        </div>
                        <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'>
                            <div class='form-group'>
                                <label for='firstname'>First Name</label>
                                <input type='text' class='form-control' id='firstname' value='{$value['firstname']}' placeholder='' disabled>
                            </div>
                        </div>
                        <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'>
                            <div class='form-group'>
                                <label for='lastname'>Last Name</label>
                                <input type='text' class='form-control' id='lastname' value='{$value['lastname']}' placeholder='' disabled>
                            </div>
                        </div>
                        <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'>
                            <div class='form-group'>
                                <label for='email'>Email</label>
                                <input type='email' class='form-control' id='email' value='{$value['email']}' placeholder='' disabled>
                            </div>
                        </div>
                        <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'>
                            <div class='form-group' style='margin-top: 10px;'>
                                <label for='username'>Username</label>
                                <input type='text' class='form-control' id='username' value='{$value['username']}' placeholder='' disabled>
                            </div>
                        </div>
                        <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'>
                            <div class='form-group' style='margin-top: 10px;'>
                                <label for='password'>Password</label>
                                <input type='password' class='form-control' id='password' placeholder='Password' disabled>
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
                                <input type='name' class='form-control' id='street' placeholder='Enter Street' disabled>
                            </div>
                        </div>
                        <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'>
                            <div class='form-group'>
                                <label for='city'>City</label>
                                <input type='name' class='form-control' id='city' placeholder='Enter City' disabled>
                            </div>
                        </div>
                        <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'>
                            <div class='form-group' style='margin-top: 10px;'>
                                <label for='state'>State</label>
                                <input type='text' class='form-control' id='state' placeholder='Enter State' disabled>
                            </div>
                        </div>
                        <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12'>
                            <div class='form-group' style='margin-top: 10px;'>
                                <label for='zip'>Zip Code</label>
                                <input type='text' class='form-control' id='zip' placeholder='Zip Code' disabled>
                            </div>
                        </div>

                    </div>
                    <div class='row gutters'>
                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
                            <div id='update' class='text-right' style='display: none;'>
                                <button type='button' id='submit' name='submit' class='btn btn-primary' >Update</button>
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