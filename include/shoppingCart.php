
<div class="modal fade" id="modalShoppingCart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content rounded-5 shadow">
      <div class="modal-header pb-4 border-bottom-0">
        <h5 class="modal-title" style="color: black;">
          Your Shopping Cart
        </h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-image">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col">Product</th>
              <th scope="col">Price</th>
              <th scope="col">Qty</th>
              <th scope="col">Total</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="w-25">
                <img src="https://ais.kochbar.de/vms/5ced0e371d90da128862f2c2/24-05xcp0/1200x900/3285/burger.jpg" class="img-fluid img-thumbnail" alt="Sheep">
              </td>
              <td>Burger</td>
              <td>9.50CHF</td>
              <td class="qty" style="max-width: 2rem;"><input type="text" class="form-control" id="input1" value="2"></td>
              <td>19CHF</td>
              <td>
                <a href="#" class="btn btn-danger btn-sm">
                  <i class="fa fa-times"></i>
                </a>
              </td>
            </tr>
          </tbody>
        </table> 
        <div class="d-flex justify-content-end">
          <h5>Total: <span class="price text-success">19CHF</span></h5>
        </div>
      </div>
      <div class="modal-footer border-top-0 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-warning">Checkout</button>
      </div>
    </div>
  </div>
</div>