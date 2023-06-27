<?php
$servername = "localhost";
$username = "porncha2";
$password = "9r6gCQ(hH5)t0A";
$db = "porncha2_stock";

// Create connection
$con = new mysqli($servername, $username, $password,$db);
$con->set_charset("utf8");

// Check connection
if ($con->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>