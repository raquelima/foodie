<?php

$host = 'localhost';
$database = 'users';
$username = 'admin';
$password = 'admin';

// mit Datenbank verbinden
$mysqli = new mysqli($host, $username, $password, $database);

// Fehlermeldung, falls Verbindung fehl schlägt.
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
}
