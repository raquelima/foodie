    <header class="p-3 bg-dark text-white">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <svg class="bi me-2" width="120" height="50" role="img" aria-label="Bootstrap">
                        <image href='images/5.png' height='100%' width='100%' />
                    </svg>
                </a>
                <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <svg class="bi me-2" width="45" height="35" role="img" aria-label="Bootstrap">
                        <image href='images/7.png' height='100%' width='100%' />
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">

                </ul>

                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                    <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
                </form>

                <div class="text-end">
                    <?php
                    //wenn Session personalisiert
                    if (isset($_SESSION['loggedin'])) {
                        echo '<a type="" class="btn btn-outline-light me-2" href="include/logout.php">Logout</a>';
                    } else {
                        //wenn Session nicht personalisiert
                        echo '<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalSignup">Sign-up</button>';
                        echo '<button id="loginBtn" type="button" class="btn btn-outline-light me-2" data-toggle="modal" data-target="#modalSignin">Login</button>';
                    }
                    ?>
                </div>
            </div>
    </header>