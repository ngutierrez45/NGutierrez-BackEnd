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
$password = "\$PissyGroot121";
$dbname = "nag45";
$connect = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
  die("Failed to connect to MySQL: " . mysqli_connect_error());
} else {
  // Retrieve the "name" parameter from the URL query string
  $name = $_GET["name"];
  
  
   $sql = "SELECT CHAT_CONTENT FROM Chat WHERE NAME = '" . $name . "' ORDER BY CHAT_CONTENT DESC LIMIT 1";

  if($name=="top5"){

    $sql = "SELECT f.title AS title, COUNT(r.rental_id) AS rented FROM film AS f INNER JOIN inventory AS i ON f.film_id = i.film_id INNER JOIN rental AS r ON i.inventory_id = r.inventory_id GROUP BY title ORDER BY rented DESC LIMIT 5;";

  $result = mysqli_query($connect, $sql);

  // Check if there are any rows that match the query
  if(mysqli_num_rows($result) > 0) {
    // Fetch the chat content from the first (and only) row of the result set
    $content = array();
    while($row = mysqli_fetch_assoc($result)){
      $content[] = $row['title'];
    }
  
    // Return the chat content as a JSON object
    $response = [true, $content, "top5"];
  } else {
    // No rows match the query
    $response = [false, "No movies found.",""];
  }

  }else if($name=="md"){
 $response=[true, "Fill by clicking a movie","md"];
   
  }else if($name=="act"){

    $sql = "SELECT a.actor_id, a.first_name, a.last_name, COUNT(fa.film_id) AS movies FROM actor AS a INNER JOIN film_actor AS fa ON a.actor_id = fa.actor_id GROUP BY a.actor_id, a.first_name, a.last_name ORDER BY movies DESC LIMIT 5;";

  $result = mysqli_query($connect, $sql);

  // Check if there are any rows that match the query
  if(mysqli_num_rows($result) > 0) {
    // Fetch the chat content from the first (and only) row of the result set
    $content = array();

    while($row = mysqli_fetch_assoc($result)){
      $content[] = array(
        "first_name" => $row['first_name'],
        "last_name" => $row['last_name']);
    }

    // Return the chat content as a JSON object
    $response = [true, $content, "act"];
  } else {
    // No rows match the query
    $response = [false, "User not found.",""];

  }

  }else if($name=="actd"){

  $response = [true, "Fill by clicking an Actor", "actd"];

  }else if($name=="getmoviedesc"){
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


  }else if($name=="getactortop5"){
$actor = $_GET["actor"];
$sql = "SELECT f.film_id, f.title, COUNT(r.rental_id) AS rental_count FROM actor AS a JOIN film_actor AS fa ON a.actor_id = fa.actor_id JOIN film AS f ON fa.film_id = f.film_id JOIN inventory AS i ON f.film_id = i.film_id JOIN rental AS r ON i.inventory_id = r.inventory_id WHERE a.first_name = '" . $actor . "' GROUP BY f.film_id, f.title ORDER BY rental_count DESC LIMIT 5";
$result = mysqli_query($connect, $sql);

// Check if there are any rows that match the query
if (mysqli_num_rows($result) > 0) {
        // Initialize the $content array
        $content = array();

        // Fetch the chat content from the result set
        while ($row = mysqli_fetch_assoc($result)) {
            $content[] = $row['title'];
        }

        // Return the chat content as a JSON object
        $response = [true, $content, "actortop5"];
    } else {
        // If no rows match the query, return an appropriate response
        $response = [false, "No movies found for the actor.", "actortop5"];
    }
  }

  // Set the content type header to JSON
  header('Content-Type: application/json');

  // Encode the response object as a JSON string and return it
  echo json_encode($response);

  mysqli_close($connect);
}
?>

