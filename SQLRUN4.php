<?php
// Allow requests from any origin
header("Access-Control-Allow-Origin: *");

// Allow specific HTTP methods (e.g., GET)
header("Access-Control-Allow-Methods: GET");

// Allow specific HTTP headers in requests
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Set the content type header to JSON
header('Content-Type: application/json');

// Makes DB connection
$servername = "sql1.njit.edu";
$username = "nag45";
$password = "root";
$dbname = "nag45";
$connect = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
  die("Failed to connect to MySQL: " . mysqli_connect_error());
} else {
$ID = $_GET['ID'];
$fname = $_GET['fname'];
$lname = $_GET['lname'];

// Base SQL query
$sql = "SELECT email
        FROM customer
        WHERE 1"; // Placeholder for the WHERE clause conditions

// Add conditions based on provided parameters
if (!empty($ID)) {
    $sql .= " AND customer_id = '$ID'";
}

if (!empty($fname)) {
    $sql .= " AND first_name = '$fname' ";
}

if (!empty($lname)) {
    $sql .= " AND last_name = '$lname'";
}

$sql .= " LIMIT 20";

  $result = mysqli_query($connect, $sql);

   if(mysqli_num_rows($result) > 0) {
    // Fetch the chat content from the first (and only) row of the result set
    $content = array();
    while($row = mysqli_fetch_assoc($result)){
      $content[] = $row['email'];
    }
  
    // Return the chat content as a JSON object
    $response = [true, $content, $sql];
  }else{
    $content=[];
    $response = [false, $content, $sql];
  }

  // Set the content type header to JSON
  header('Content-Type: application/json');

  // Encode the response object as a JSON string and return it
  echo json_encode($response);

  mysqli_close($connect);
}
?>
