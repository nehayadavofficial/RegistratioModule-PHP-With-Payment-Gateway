<?php

$keyId = 'rzp_test_9TB3asShG3RvdV';
$keySecret = 'zrpWBMrytnHq5UMUeVikNgfn';
$displayCurrency = 'INR';

//These should be commented out in production
// This is for error reporting
// Add it to config.php to report any errors
error_reporting(E_ALL);
ini_set('display_errors', 0);


//DATABASE CONNECTION DETAILS
$host = "localhost";
$username = "neha";
$password = "hestabit";
$dbname = "test_db";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
	echo "Connection failed!";
}