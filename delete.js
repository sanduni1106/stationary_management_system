document.getElementById('delete-btn').addEventListener('click', function () {
    const selectedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
    const selectedIds = [];

    // Collect selected row IDs (based on the unique id field)
    selectedCheckboxes.forEach(checkbox => {
        try {
            const rowData = JSON.parse(checkbox.value);  // Assuming the row data is stored in the checkbox value
            selectedIds.push(rowData['id']);  // Collect the unique id for deletion
        } catch (e) {
            console.error('Error parsing checkbox value:', e);
        }
    });

    console.log('Selected IDs:', selectedIds);

    // If no rows are selected, alert the user
    if (selectedIds.length === 0) {
        alert("Please select at least one row to delete.");
        return;
    }

    // Confirm deletion
    if (confirm('Are you sure you want to delete the selected records?')) {
        // Send AJAX request to delete.php
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Add xhr.onload function here to handle the server response
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log('Raw server response:', xhr.responseText); // Log the response text for debugging
                try {
                    const response = JSON.parse(xhr.responseText);  // Attempt to parse the response as JSON
                    if (response.status === 'success') {
                        alert('Selected records have been deleted.');
                        location.reload();  // Reload the page after deletion
                    } else {
                        alert('Error: ' + response.message);
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e);  // Log the error if parsing fails
                }
            } else {
                alert('Error: Could not connect to server.');  // Alert if status is not 200
            }
        };

        // Send the selected IDs to the server
        xhr.send('ids=' + JSON.stringify(selectedIds));  // Send the unique IDs to the server as JSON
    }
});
