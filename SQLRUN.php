<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// Makes DB connection
$servername = "sql1.njit.edu";
$username = "nag45";
$password = "\$PissyGroot121";
$dbname = "nag45";
$connect = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
  die("Failed to connect to MySQL: " . mysqli_connect_error());
} else {
  // Retrieve the "name" parameter from the URL query string
  $name = "Nick";

   $sql = "SELECT CHAT_CONTENT FROM Chat WHERE NAME = '" . $name . "' ORDER BY CHAT_CONTENT DESC LIMIT 1";
  $result = mysqli_query($connect, $sql);

  // Check if there are any rows that match the query
  if(mysqli_num_rows($result) > 0) {
    // Fetch the chat content from the first (and only) row of the result set
    $row = mysqli_fetch_assoc($result);
    $chatContent = $row["CHAT_CONTENT"];
    
    // Return the chat content as a JSON object
    $response = [true, $chatContent];
  } else {
    // No rows match the query
    $response = [false, "User not found."];
  }

  // Set the content type header to JSON
  header('Content-Type: application/json');

  // Encode the response object as a JSON string and return it
  echo json_encode($response);

  mysqli_close($connect);
}
?>
