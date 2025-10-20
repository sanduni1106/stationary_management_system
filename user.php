<?php
// Database connection details
$servername = "localhost"; // Database host
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "stationary_db"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// User data (you can add more users as needed)
$users = [
    ['user_name' => 'basic_user', 'password' => 'user2025', 'role' => 'Basic User'],
    ['user_name' => 'advanced_user', 'password' => 'advanceduser2025', 'role' => 'Advanced User'],
    ['user_name' => 'basic_admin', 'password' => 'basicadmin2025', 'role' => 'Basic Admin'],
    ['user_name' => 'super_admin', 'password' => 'superadmin2025', 'role' => 'Super Admin']
];

// Prepare the SQL query to insert user data into the user_login table
$sql = "INSERT INTO user_login (user_name, password, role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

// Loop through each user and insert them with hashed passwords
foreach ($users as $user) {
    // Hash the password before inserting
    $hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);
    
    // Bind the parameters and execute the query
    $stmt->bind_param("sss", $user['user_name'], $hashed_password, $user['role']);
    $stmt->execute();
}

// Close the statement and connection
$stmt->close();
$conn->close();

echo "Users inserted successfully!";
?>
