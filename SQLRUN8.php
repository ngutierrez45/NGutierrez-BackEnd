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

$ident = $_GET["id"];
$fname = $_GET["fname"];
$lname = $_GET["lname"];
$email = $_GET["email"];

$sql = "SELECT email FROM customer WHERE customer_id = '" . $ident . "'";
//$sql = "SELECT customer_id FROM customer WHERE first_name = '" . $fname . "' AND last_name = '" . $lname . "' AND email = '" . $email . "'";
$result = mysqli_query($connect, $sql);
$i = 0;
if(mysqli_num_rows($result) > 0){

if (!empty($fname)) {
    $sql = "UPDATE customer SET first_name = '" . $fname . "' WHERE customer_id = '" . $ident . "'";
    $result = mysqli_query($connect, $sql);
    $i++;
}

if (!empty($lname)) {
    $sql = "UPDATE customer SET last_name = '" . $lname . "' WHERE customer_id = '" . $ident . "'";
    $result = mysqli_query($connect, $sql);
    $i++;
}

if (!empty($email)) {
    $sql = "UPDATE customer SET email = '" . $email . "' WHERE customer_id = '" . $ident . "'";
    $result = mysqli_query($connect, $sql);
    $i++;
}

$update = date("Y-m-d H:i:s");
$sql = "UPDATE customer SET last_update = '" . $update . "' WHERE customer_id = '" . $ident . "'";
$result = mysqli_query($connect, $sql);

$response = [true, $sql];
}else{

    $response = [false,  $sql];
}

header('Content-Type: application/json');

  // Encode the response object as a JSON string and return it
  echo json_encode($response);

  mysqli_close($connect);
}
?>