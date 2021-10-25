<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalEditRestaurant" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header px-5 pt-5 border-bottom-0">
                <h2 class="fw-bold mb-0">Edit Restaurant</h2>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-5 pb-5">
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

                    echo "
                        <form class='row' method='POST' action='edit.php'>
                            <div class='form-floating col-md-6 mb-3'>
                                <input type='text' name='restaurantName' class='form-control rounded-4' value='{$value["name"]}' placeholder='Restaurant Name' maxlength='60' required>
                                <label class='px-4'>Restaurant Name</label>
                            </div>
                            <div class='form-floating col-md-6 mb-3'>
                                <input type='text' name='website' class='form-control rounded-4' value='{$value["website"]}' maxlength='256' placeholder='Website (https://www.myRestaurant.com)' required>
                                <label class='px-4'>Website</label>
                            </div>
                            <div class='form-floating mb-3'>
                                <textarea name='description' style='height: 300px;' class='form-control rounded-4' placeholder='Description' required cols='30' rows='10'>{$value["description"]}</textarea>
                                <label class='px-4'>Description</label>
                            </div>
                            <div class='form-floating mb-3'>
                                <input type='text' name='address' class='form-control rounded-4' value='{$value["place"]}' maxlength='256' placeholder='Address' required>
                                <label class='px-4'>Address</label>
                            </div>
                            <div class='form-floating col-md-3 mb-3'>
                                <input type='number' name='deliveryFrom' class='form-control rounded-4' value='{$value["delivery-from"]}' placeholder='From' required min='0' max='500'>
                                <label class='px-4'>Delivery From</label>
                            </div>
                            <div class='form-floating col-md-3 mb-3'>
                                <input type='number' name='deliveryUntil' class='form-control rounded-4' value='{$value["delivery-until"]}' placeholder='Until' required min='0' max='500'>
                                <label class='px-4'>Delivery Until</label>
                            </div>
                            <div class='form-floating col-md-6' style='text-align: right;'>
                            <button class='btn btn-lg btn-warning mt-1' name='editedRestaurant' value='{$_GET['id']}' type='submit'>Update Restaurant</button>
                            </div>
                        </form>
                        ";
                }
                ?>


            </div>
        </div>
    </div>
</div>