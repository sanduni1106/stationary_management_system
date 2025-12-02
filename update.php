
<?php
include('dbconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectedRows'])) {
    $selectedRows = json_decode($_POST['selectedRows'], true); // Decode JSON data

    if (empty($selectedRows)) {
        echo "No rows selected.";
        exit;
    }

    echo "<h2>Update Selected Entries</h2>";
    echo "<form method='POST' action='update_process.php'>";
    
    foreach ($selectedRows as $row) {
        echo "<input type='hidden' name='ids[]' value='" . htmlspecialchars($row['id']) . "'>";
        
        foreach ($row as $key => $value) {
            if ($key !== 'id') { // Skip ID field (not editable)
                echo "<label>$key:</label>";
                echo "<input type='text' name='{$key}[]' value='" . htmlspecialchars($value) . "'><br>";
            }
        }
        echo "<hr>";
    }

    echo "<button type='submit'>Submit Updates</button>";
    echo "</form>";
}
?>
