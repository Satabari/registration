<?php

// Set connection variables
$server = "localhost";
$username = "root";
$password = "";
$db_name = "registration";

// Create a database connection
$con = mysqli_connect($server, $username, $password, $db_name);

// Check for connection success
if(!$con){
    die("connection to this database failed due to " . mysqli_connect_error());
}

?>