<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection details
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "stationary_db"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the input data from the POST request
$data = json_decode(file_get_contents("php://input"), true);
$input_username = $data['username'];  // Username sent from the client
$input_password = $data['password'];  // Password sent from the client

// Prepare the SQL query to check if the user exists
$sql = "SELECT * FROM user_login WHERE user_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $input_username);  // Bind the username as a string
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Check if the password is correct
    if (password_verify($input_password, $user['password'])) {  // Use input_password
        $response = [
            'success' => true,
            'role' => $user['role'],
            'redirectURL' => getRedirectURL($user['role'])
        ];
    } else {
        // Incorrect password
        $response = [
            'success' => false,
            'message' => 'Invalid username or password'
        ];
    }
} else {
    // User not found
    $response = [
        'success' => false,
        'message' => 'Invalid username or password'
    ];
}

// Close the database connection
$conn->close();

// Send the response as JSON
echo json_encode($response);

// Helper function to determine the redirect URL based on the user role
function getRedirectURL($role) {
    switch ($role) {
        case 'Basic User':
            return '/user-dashboard.php';
        case 'Advanced User':
            return '/advanced-dashboard.php';
        case 'Basic Admin':
            return '/admin-dashboard.php';
        case 'Super Admin':
            return '/super-admin-dashboard.php';
        default:
            return '/';
    }
}
?>

