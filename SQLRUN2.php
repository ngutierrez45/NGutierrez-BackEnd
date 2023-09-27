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
$movieTitle = $_GET['title'];
$actorFirstName = $_GET['actor'];
$genre = $_GET['genre'];

// Base SQL query
$sql = "SELECT DISTINCT film.title
        FROM film
        JOIN film_actor ON film.film_id = film_actor.film_id
        JOIN actor ON film_actor.actor_id = actor.actor_id
        JOIN film_category ON film.film_id = film_category.film_id
        JOIN category ON film_category.category_id = category.category_id
        WHERE 1"; // Placeholder for the WHERE clause conditions

// Add conditions based on provided parameters
if (!empty($movieTitle)) {
    $sql .= " AND film.title = '$movieTitle'";
}

if (!empty($actorFirstName)) {
    $sql .= " AND actor.first_name = '$actorFirstName' ";
}

if (!empty($genre)) {
    $sql .= " AND category.name = '$genre'";
}

$sql .= " LIMIT 20";

  $result = mysqli_query($connect, $sql);

   if(mysqli_num_rows($result) > 0) {
    // Fetch the chat content from the first (and only) row of the result set
    $content = array();
    while($row = mysqli_fetch_assoc($result)){
      $content[] = $row['title'];
    }
  
    // Return the chat content as a JSON object
    $response = [true, $content, $sql];
  }else{
    $content=[];
    $response = [true, $content, $sql];
  }

  // Set the content type header to JSON
  header('Content-Type: application/json');

  // Encode the response object as a JSON string and return it
  echo json_encode($response);

  mysqli_close($connect);
}
?>

