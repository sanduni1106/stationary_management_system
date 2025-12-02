<?php
// Start the session to access session variables
session_start();

// Destroy all session variables
session_unset();

// Destroy the session
session_destroy();

// Optionally, delete any cookies used for authentication (if applicable)
if (isset($_COOKIE['username'])) {
    setcookie('username', '', time() - 3600, '/'); // Set the cookie expiration to the past
}

if (isset($_COOKIE['password'])) {
    setcookie('password', '', time() - 3600, '/'); // Set the cookie expiration to the past
}

// Redirect the user to the login page after logging out
header('Location: home.html');
exit();  // Always call exit after a header redirect
?>
