document.getElementById('approveAllButton').addEventListener('click', function() {
    // Confirm the action before submitting
    if (confirm("Are you sure you want to approve all requests?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "approve_all.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Handle the response
        xhr.onload = function() {
            if (xhr.status == 200) {
                // Successfully updated, update the table status for each row
                var rows = document.querySelectorAll('#printableTable tbody tr');
                rows.forEach(function(row) {
                    // Skip the total row or any row with the class 'total-row'
                    if (row.classList.contains('total-row')) {
                        return; // Skip this row
                    }

                    var cells = row.querySelectorAll('td'); // Get all td elements in the row
                    if (cells.length >= 40) {  // Ensure there are enough columns
                        cells[39].innerText = 'Approved'; // Update the 40th column (Approval Status)
                    } else {
                        console.error("Row doesn't have 40 columns: ", row);  // Log error if row has less than 40 columns
                    }
                });
                alert("All requests approved!");  // Show success message
            } else {
                alert("Error approving all requests.");
            }
        };

        // Send the request
        xhr.send("approveAll=true"); // Send a parameter to indicate approving all rows
    }
});


