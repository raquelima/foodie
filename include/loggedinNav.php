<?php include('include/shoppingCart.php');
if (isset($_POST['removedFood']) && is_numeric($_POST['removedFood'])) {
    echo '<script>
                window.onload = function(){
                      document.getElementById("cartBTN").click(); // Click on the cart button
            
                }
            </script>';
}
?>
<div class="d-flex align-items-center">
    <a class="text-reset me-3" href="" id="cartBTN" data-toggle="modal" data-target="#modalShoppingCart">
        <span class="badge badge-pill " style="background-color:rgb(240, 173, 78); "><?php echo count($_SESSION['products']); ?></span>
        <i class="fas fa-shopping-cart"></i>
    </a>
    <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
    </a>
    <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
        <li><a class="dropdown-item" href="index.php">Home</a></li>
        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
        <li><a class="dropdown-item" href="orders.php">My orders</a></li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item" href="include/logout.php">Sign out</a></li>
    </ul>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>