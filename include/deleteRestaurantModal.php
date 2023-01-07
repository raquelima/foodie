<?php

// Sessionhandling starten falls noch keine vorhanden ist
if (session_status() !== PHP_SESSION_ACTIVE) {
    //Set the session timeout
    $timeout = 900;

    //Set the maxlifetime of the session
    ini_set("session.gc_maxlifetime", $timeout);

    //Set the cookie lifetime of the session
    ini_set("session.cookie_lifetime", $timeout);

    //Set cookie to http only
    ini_set('session.cookie_httponly', 1);

    // Sessionhandling starten
    session_start();
}

error_reporting(0);


?>
<?php if (isset($_SESSION['isAdmin']) and $_SESSION['isAdmin']) : ?>

<div class="modal fade" tabindex="-1" role="dialog" id="modalDelete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-lg rounded-5 shadow">
            <div class="modal-header px-5 pt-5 border-bottom-0">
                <h2 class="fw-bold mb-0">Delete Restaurant</h2>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-5 pb-5">

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
<?php endif; ?>