<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">FOODIE</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <?php
                //wenn Session personalisiert
                if (isset($_SESSION['loggedin'])) {
                    echo '<li class="nav-item"><a class="nav-link" href="include/logout.php">Logout</a></li>';
                   
                } else {
                    //wenn Session nicht personalisiert
                    echo '<li class="nav-item"><a class="nav-link" href="" data-toggle="modal" data-target="#modalSignup">Register</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="" data-toggle="modal" data-target="#modalSignin">Login</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>