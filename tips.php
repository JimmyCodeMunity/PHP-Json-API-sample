<?php
// Create a connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mentheal";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select data from the table
$sql = "SELECT * FROM quotes";
$result = $conn->query($sql);

// Store the data in an array
$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Return the data in JSON format
header('Content-Type: application/json');
echo json_encode($data);

// Close the connection to the database
$conn->close();
?>
