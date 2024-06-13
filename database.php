<?php

$host = "localhost";
$dbname = "id21946870_czyrah_os";
$username = "id21946870_czyrahs";
$password = "24Starexified!";

$mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;