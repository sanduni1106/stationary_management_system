<?php
$servername = "localhost:3306"; 
$username = "root";        
$password = ""; // Replace with your MySQL root password
$dbname = "stationary_db";   

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
