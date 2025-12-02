<?php
session_start();
include('dbconnect.php');

if (isset($_POST['approveAll'])) {
    $branch = $_POST['branch'];  // Ensure 'branch' is passed from the form
    $table = ""; // Table name variable based on branch

    // Determine table name based on branch
    switch ($branch) {
        case 'establishment':
            $table = 'establishment_section';
            break;
        case 'account':
            $table = 'account_section';
            break;
        case 'sports':
            $table = 'sports_section';
            break;
        case 'development':
            $table = 'development_section';
            break;
        case 'ruraldev':
            $table = 'ruraldev_section';
            break;
        case 'culturalart':
            $table = 'cultural_section';
            break;
        default:
            echo "Invalid branch.";
            exit();
    }

    // Update the approval status to 'Approved' for all rows that are not already approved
    $sql = "UPDATE $table SET approval_status = 'Approved' WHERE approval_status != 'Approved'";

    if ($conn->query($sql) === TRUE) {
        echo "All rows have been approved.";

        // Log the approval action
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id']; // Ensure user_id is stored in session
            $log_sql = "INSERT INTO approval_history (user_id, branch, action, timestamp) VALUES ('$user_id', '$branch', 'Approved All', NOW())";
            $conn->query($log_sql);
            echo "Approval action has been logged.";
        } else {
            echo "Warning: User session not found. Action not logged.";
        }
    } else {
        echo "Error updating records: " . $conn->error;
    }

    // Redirect back to the previous page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    echo "No approval request received.";
}
?>
<!-- CREATE TABLE approval_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    branch VARCHAR(255) NOT NULL,
    approved_by INT NOT NULL,  -- User ID of the person who approved
    approval_date DATETIME NOT NULL
); -->
