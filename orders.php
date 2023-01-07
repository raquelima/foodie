<?php
//Set the session timeout
$timeout = 900;

//Set the maxlifetime of the session
ini_set( "session.gc_maxlifetime", $timeout );

//Set the cookie lifetime of the session
ini_set( "session.cookie_lifetime", $timeout );

// Sessionhandling starten
session_start();

if (empty($_SESSION) || !$_SESSION["loggedin"]) {
    echo '<script>
    window.onload = function() {
      location.replace("index.php")
    }
    </script>';
}

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

</head>

<body >
    <?php include('include/nav.php'); ?>

    <?php include('include/map.php'); ?>
   
    <div class="album py-5 bg-light">
        <main class="container">
            <div class="col-md-12">
                <?php
        
                $query = "SELECT * FROM orders WHERE {$_SESSION['id']} = userID;";

                $stmt = $mysqli->prepare($query);

                $stmt->execute();

                $result = $stmt->get_result();
                $count = 0;
                foreach ($result as $value) {
                    $count++;
                    $sec = strtotime(htmlspecialchars($value['orderDate']));
                    $newdate = date("d. M. Y H:i", $sec);
                    $orderAddress = htmlspecialchars($value['orderAddress']);
                    $orderID = htmlspecialchars($value['orderID']);
                    $orderText = htmlspecialchars($value['orderText']);
                    echo "<div class='row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative'>
                    <div class='col-auto d-none d-lg-block'>
                        <svg class='bd-placeholder-img' width='200' height='250' role='img' aria-label='Placeholder: Thumbnail' preserveAspectRatio='xMidYMid slice' focusable='false'>
                            <title>Placeholder</title>
                            <image href='images/pommes-icon.png' height='100%' width='100%' />
                        </svg>

                    </div>
                    <div class='col p-4 d-flex flex-column position-static'>
                        <h3 class='mb-3'>Your {$count}. Order</h3>

                        <p class='card-text mb-auto'>Order number: #", str_pad(htmlspecialchars($value['orderID']), 6, '0', STR_PAD_LEFT), "</p>
                        <div class='mb-1 text-muted'>
                            <p> Purchased on the {$newdate}</p>
                            <p style='display: inline; text-align: left;'>", number_format((float)htmlspecialchars($value['orderPrice']), 2, '.', ''), " CHF</p>

                            <form style='float: right;'><button type='button' onclick='updateMap(`{$orderAddress}`)' style='display: inline; text-align: right;' class='btn btn-warning' data-toggle='modal' data-target='#modalVM' >Map</button></form>
                        </div>
                        <div>
                            <button id='detail{$orderID}' onclick='showDetail({$orderID})' class='btn btn-warning'>Details</button>
                            <div id='food{$orderID}' style='display: none;'>
                                <p>{$orderText}</p>
                                <button id='less{$orderID}' onclick='showLess({$orderID})' class='btn btn-warning'>Show Less</button>
                            </div>
                        </div>

                    </div>



                </div>";
                }
                ?>

            </div>
        </main>   
    </div>

    <?php include('include/footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
    let map = "";

    function showDetail(id) {
        document.getElementById("food" + id).style.display = "block";
        document.getElementById("detail" + id).style.display = "none";
    }

    function showLess(id) {
        document.getElementById("food" + id).style.display = "none";
        document.getElementById("detail" + id).style.display = "block";
    }

    function updateMap(address) {
        map = "https://maps.google.com/maps?q=" + address + "&t=&z=13&ie=UTF8&iwloc=&output=embed";
        document.getElementById('map').src = map;

    }
</script>
</body>



</html>