<?php
session_start();
$_SESSION = array();
session_destroy();
if (isset($_COOKIE['CSRFP-Token'])) {
    unset($_COOKIE['CSRFP-Token']);
    setcookie('CSRFP-Token', null, -1, '/');
}
header('Location: ../index.php');
