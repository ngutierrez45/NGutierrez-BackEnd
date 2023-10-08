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
$ident = $_GET["id"];

if($type=="rent"){

$sql = "SELECT title FROM film WHERE description = '" . $desc . "'";
$result = mysqli_query($connect, $sql);

if(mysqli_num_rows($result) > 0){

$sql = "SELECT email FROM customer WHERE customer_id = '" . $ident . "'";
$result = mysqli_query($connect, $sql);

if(mysqli_num_rows($result) > 0){

$time = date("Y-m-d H:i:s");
$sql = "INSERT INTO rental (rental_id, rental_date, inventory_id, customer_id, return_date, staff_id, last_update)
SELECT
  COALESCE(MAX(rental_id), 0) + 1,
  $time,
  i.inventory_id,
  c.customer_id,
  NULL,
  1, 
  $time
FROM
  customer AS c
  INNER JOIN inventory AS i ON i.film_id = (
    SELECT film_id
    FROM film
    WHERE description = '" . $desc . "' 
    LIMIT 1
  )
WHERE
  c.customer_id = '" . $ident . "'";
$response = [true, $sql];
}else{
    $response = [false, $sql];
}
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
