document.getElementById("update-btn").addEventListener("click", function () {
    let selectedEntries = [];
    
    // Assuming checkboxes are used to select entries
    document.querySelectorAll(".row-checkbox:checked").forEach((checkbox) => {
        let row = checkbox.closest("tr");
        let entryId = row.dataset.id; // Get entry ID
        let updatedValue = row.querySelector(".editable-field").value; // Example editable field

        selectedEntries.push({
            id: entryId,
            value: updatedValue,
        });
    });

    if (selectedEntries.length === 0) {
        alert("Please select entries to update.");
        return;
    }

    // Send data to server using Fetch API (AJAX)
    fetch("update.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ entries: selectedEntries }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Entries updated successfully!");
            location.reload(); // Reload table
        } else {
            alert("Error updating entries.");
        }
    })
    .catch(error => console.error("Error:", error));
});
