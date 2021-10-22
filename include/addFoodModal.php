


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalAddFood" aria-hidden="true" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-lg rounded-5 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h2 class="fw-bold mb-0">Add Food</h2>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-5 pt-0">
                <?php
                // fehlermeldung oder nachricht ausgeben
                if (!empty($message)) {
                    echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
                } else if (!empty($error)) {
                    echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
                }
                ?>
                <form action="addFood.php" method="POST" id="addFoodForm">
                    <div class="form-floating mb-3">
                        <input type="text" name="foodName" class="form-control rounded-4" id="username" placeholder="Password" maxlength="60" required="true">
                        <label for="foodName">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea name="foodDescription" style="height: 300px;" class="form-control rounded-4" id="password" placeholder="Password" maxlength="512" required="true" cols="30" rows="10"></textarea>
                        <label for="foodDescription">description</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" step="0.01" name="foodPrice" class="form-control rounded-4" id="password" placeholder="Password" min="1" max="2000" required="true">
                        <label for="foodPrice">price</label>
                    </div>

                </form>
            </div>
            <div class="modal-footer p-5 pt-0" style="border-top: 0 none;">
                <div class="col text-center ">
                    <button class="w-50 mb-2 btn btn-lg rounded-4 btn-warning btn btn-info" name="addFoodForm" form="addFoodForm" value="<?php echo $_GET["id"] ?>" type="submit">Add new dish</button>
                </div>
            </div>
        </div>

    </div>
</div>