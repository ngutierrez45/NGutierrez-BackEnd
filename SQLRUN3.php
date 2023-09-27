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
  // Retrieve the "name" parameter from the URL query string
$movie = $_GET["movie"];
$sql = "SELECT film.description AS description, film.release_year AS release_year, film.length AS length, film.rating AS rating, GROUP_CONCAT(category.name) AS categories FROM film INNER JOIN film_category ON film.film_id = film_category.film_id INNER JOIN category ON film_category.category_id = category.category_id WHERE film.title = '" . $movie . "' GROUP BY film.film_id";
$result = mysqli_query($connect, $sql);

// Check if there are any rows that match the query
if (mysqli_num_rows($result) > 0) {
    // Fetch the chat content from the first (and only) row of the result set
    $content = array();

    $row = mysqli_fetch_assoc($result);
    $content[] = array(
        "description" => $row['description'],
        "year" => $row['release_year'],
        "length" => $row['length'],
        "rating" => $row['rating'],
        "category" => $row['categories']
    );
}

// Return the chat content as a JSON object
$response = [true, $content, "moviedesc"];

  }
  // Set the content type header to JSON
  header('Content-Type: application/json');

  // Encode the response object as a JSON string and return it
  echo json_encode($response);

  mysqli_close($connect);
?>
