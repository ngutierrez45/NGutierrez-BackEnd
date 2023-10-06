<?php
// Allow requests from any origin
header("Access-Control-Allow-Origin: *");

// Allow specific HTTP methods (e.g., GET)
header("Access-Control-Allow-Methods: GET");

// Allow specific HTTP headers in requests
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Set the content type header to JSON
header('Content-Type: application/json');
//Makes DB connection
$servername = "sql1.njit.edu";
$username = "nag45";
$password = "\$PissyGroot121";
$dbname = "nag45";
$connect = mysqli_connect($servername,$username,$password,$dbname);
if (mysqli_connect_errno())
{
 die("Failed to connect to MySQL: " . mysqli_connect_error());
}
else

 {
$type = $_GET["name"];
$desc = $_GET["desc"];

if($type=="rent"){

$sql = "SELECT title FROM film WHERE description = '" . $desc . "'";
$result = mysqli_query($connect, $sql);

if(mysqli_num_rows($result) > 0){

//Run SQL to update movie to rented
$response = [true, $sql];

}else{

    $response = [false,  $sql];
}

}
header('Content-Type: application/json');

  // Encode the response object as a JSON string and return it
  echo json_encode($response);

  mysqli_close($connect);
}
?>