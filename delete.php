<?php
include('dbconnect.php');

// Check if 'ids' is provided in the POST request
if (isset($_POST['ids'])) {
    $ids = json_decode($_POST['ids'], true); // Decode the JSON into an array

    // Check if $ids is an array
    if (is_array($ids)) {
        // Sanitize the IDs to prevent SQL injection
        $ids = implode(',', array_map('intval', $ids)); // Convert IDs to integers
        
        // Write delete queries for each table
        $sql1 = "DELETE FROM establishment_section WHERE id IN ($ids)";
        $sql2 = "DELETE FROM account_section WHERE id IN ($ids)";
        $sql3 = "DELETE FROM sports_section WHERE id IN ($ids)";

        // Execute the queries
        $conn->begin_transaction(); // Start a transaction (if needed)
        
        try {
            // Execute each delete query
            $conn->query($sql1);
            $conn->query($sql2);
            $conn->query($sql3);
            
            // Commit the transaction
            $conn->commit();
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            // Rollback if any query fails
            $conn->rollback();
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete records']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid IDs']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No IDs provided']);
}
?>
