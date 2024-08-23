<?php 
#database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtbinventory";

#connection string
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>