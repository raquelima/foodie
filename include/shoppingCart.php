<?php
$count = 0;
if (isset($_POST['removedFood']) && array_key_exists($_POST['removedFood'], $_SESSION['products'])) {
  unset($_SESSION['products'][$_POST['removedFood']]);
  echo "<script>
  window.onload = function() {
      location.reload();
  }
   </script>";
}

?>
<div class="modal fade" id="modalShoppingCart" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content rounded-5 shadow">
      <div class="modal-header pb-4 border-bottom-0">
        <h5 class="modal-title" style="color: black;">
          Your Shopping Cart
        </h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-image">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col">Product</th>
              <th scope="col">Price</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $price = 0;
            if (isset($_SESSION['products']) && !empty($_SESSION['products'])) {
              foreach ($_SESSION['products'] as $key => $value) {

                $query = "select * from food where foodID = {$key};";

                $stmt = $mysqli->prepare($query);

                $stmt->execute();

                $result = $stmt->get_result();
                foreach ($result as $food) {
                  $count++;
                  $price = number_format((float)$food['price'], 2, '.', '');
                  echo "<tr>
                    <td class='w-25'>
                      <img src='https://ais.kochbar.de/vms/5ced0e371d90da128862f2c2/24-05xcp0/1200x900/3285/burger.jpg' class='img-fluid img-thumbnail' alt='Image not found'>
                    </td>
                    <td>{$food['foodName']}</td>
                    <td>{$price} CHF</td>
                    <td>
                    <form action='#' method='POST'>
                    <button type='submit' class='btn btn-danger' name='removedFood' value='{$food['foodID']}'><i class='fa fa-times'></i></button>
                    </form>
                    </td>
                  </tr>";
                }
              }
            }

            ?>


          </tbody>
        </table>
        <div class="d-flex justify-content-end">
          <h5>Total: <span class="price text-success"><?php
                                                      $price = 0;

                                                      if (isset($_SESSION['products']) && !empty($_SESSION['products'])) {
                                                        foreach ($_SESSION['products'] as $key => $value) {
                                                          $result->free();

                                                          $query = "select * from food where foodID = {$key};";

                                                          $stmt = $mysqli->prepare($query);

                                                          $stmt->execute();

                                                          $result = $stmt->get_result();
                                                          foreach ($result as $food) {
                                                            $price += $food['price'];
                                                          }
                                                        }
                                                      }
                                                      echo number_format((float)$price, 2, '.', '');
                                                      ?> CHF</span></h5>
        </div>
      </div>
      <div class="modal-footer border-top-0 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <form action="checkout.php" method="POST">

          <input type="text" name="orderText" value="<?php
                                                      $ids = "";
                                                      if (isset($_SESSION['products']) && !empty($_SESSION['products'])) {
                                                        foreach ($_SESSION['products'] as $key => $value) {
                                                          $result->free();

                                                          $query = "select * from food where foodID = {$key};";

                                                          $stmt = $mysqli->prepare($query);

                                                          $stmt->execute();

                                                          $result = $stmt->get_result();
                                                          foreach ($result as $food) {
                                                            $ids .= "{$food['foodID']} ";
                                                          }
                                                        }
                                                      }
                                                      echo $ids;
                                                      ?>" hidden>
          <button type="submit" id="checkout" class="btn btn-warning">Checkout</button>
        </form>

      </div>
    </div>
  </div>
  <script>
  window.onload = function() {
    document.getElementById("checkout").disabled = <?php 
        if($count == 0){
          echo "true";
        }elseif($count > 0){
          echo "false";
        }else{
          echo "true";
        }
      ?>;
  }
</script>";
</div>
