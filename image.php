<?php

// Connect to database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'mentheal';
$conn = mysqli_connect($host, $user, $password, $database);

// Get image data from database
$id = $_GET['id'];
$query = "SELECT profilepic FROM professionaldata WHERE id = 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Send image data as response
header('Content-Type: image/jpeg');
echo $row['profilepic'];

?>
