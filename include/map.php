<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<!--Modal: Name-->
<div class="modal fade" id="modalVM" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

    <!--Content-->
    <div onseeking="getMap()" class="modal-content">

      <!--Body-->
      <div class="modal-body mb-0 p-0">

        <div class="embed-responsive embed-responsive-16by9 z-depth-1-half">
          <?php
          error_reporting(0);
          echo "<iframe id='map' src='https://maps.google.com/maps?q={$test}&t=&z=13&ie=UTF8&iwloc=&output=embed'
            style='border:0' allowfullscreen></iframe>"
          ?>
          
        </div>

      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">

        <button type="button" class="btn btn-warning btn-rounded btn-md ml-4" data-dismiss="modal">Close</button>

      </div>

    </div>
    <!--/.Content-->

  </div>
</div>
<!--Modal: Name-->


