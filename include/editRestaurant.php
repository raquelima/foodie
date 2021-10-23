

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalEditRestaurant" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h2 class="fw-bold mb-0">Edit Restaurant</h2>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-5 pt-0">
                <?php
                // fehlermeldung oder nachricht ausgeben
                if (!empty($message)) {
                    echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
                } else if (!empty($editError)) {
                    echo "<div class=\"alert alert-danger\" role=\"alert\">" . $editError . "</div>";
                }
                ?>
                <?php

                $query = "select * from restaurants where id = {$_GET["id"]};";

                $stmt = $mysqli->prepare($query);

                $stmt->execute();

                $result = $stmt->get_result();
                foreach ($result as $value) {

                    echo "<div class='row'>
                    <div class='col-md-offset-3 col-md-12 col-sm-offset-2 col-sm-8'>
                        <form class='form-horizontal row' method='POST' action='edit.php'>
                            <div class='form-floating col-md-6 p-3'>
                                <input type='text' name='restaurantName' class='form-control rounded-4' value='{$value["name"]}' maxlength='60' placeholder='Password' required='true'>
                                <label for='restaurantMame' class='p-4'>Restaurant Name</label>
                            </div>
                            <div class='form-floating col-md-6 p-3'>
                                <input type='text' name='website' class='form-control rounded-4' value='{$value["website"]}' maxlength='256' placeholder='Password' required='true'>
                                <label for='website' class='p-4'>Website</label>
                            </div>
                            <div class='form-floating col-md-12 p-3'>
                                <textarea type='text' name='description'  style='height: 250px;' class='form-control rounded-4' placeholder='Password' required='true'>{$value["description"]}</textarea>
                                <label for='description' class='p-4'>Description</label>
                            </div>
                            <div class='form-floating col-md-12 p-3'>
                                <input type='text' name='address' class='form-control rounded-4' value='{$value["place"]}' maxlength='256' placeholder='Password' required='true'>
                                <label for='address' class='p-4'>Address</label>
                            </div>
                            <div class='form-floating col-md-3 p-3'>
                                <input type='number' name='deliveryFrom' class='form-control rounded-4' value='{$value["delivery-from"]}' placeholder='Password' required='true' min='0' max='500'>
                                <label for='deliveryFrom' class='p-4'>Delivery From</label>
                            </div>
                            <div class='form-floating col-md-3 p-3'>
                                <input type='number' name='deliveryUntil' class='form-control rounded-4' value='{$value["delivery-until"]}' placeholder='Password' required='true' min='0' max='500'>
                                <label for='deliveryUntil' class='p-4'>Delivery Until</label>
                            </div>
                            <div class='modal-footer p-5  pt-0 pb-0' style='border-top: 0 none;'>
                                <div class='col text-center '>
                                    <button class='w-50  btn btn-lg rounded-4 btn-warning btn btn-info' name='editedRestaurant' value='{$_GET['id']}' type='submit'>Update Restaurant</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>";
                }
                ?>

            </div>
        </div>
    </div>
</div>
