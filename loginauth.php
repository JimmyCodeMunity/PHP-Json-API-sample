<?php

// Get the username and password from the request body
$EncodedData = file_get_contents('php://input');
$DecodedData = json_decode($EncodedData,true);

$Email = $DecodedData['Email'];
$Password = $DecodedData['Password'];

// Connect to the MySQL database
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "mentheal";
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query the database to check if the user exists and the password is correct
$stmt = $conn->prepare("SELECT * FROM users WHERE Email = ? AND Password = ?");
$stmt->bind_param("ss", $Username, $Password);
$stmt->execute();
$result = $stmt->get_result();

// If the query returns one row, the user is authenticated
if ($result->num_rows == 1) {
  echo "authenticated";
  $userData = array(
  'username' => $username,
  'email' => $email,
);
  echo json_encode($userData);
} else {
  echo "invalid credentials";
}

// Close the database connection
$conn->close();

?>
