<?php

$host = "localhost";
$dbname = "u471532386_czyrahs_os";
$username = "u471532386_czyrahs";
$password = "24Starexified!";

$mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;