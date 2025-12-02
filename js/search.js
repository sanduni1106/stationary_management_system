// Show/hide the search input when the search icon is clicked
document.getElementById("search-icon").addEventListener("click", function() {
    var searchContainer = document.getElementById("search-container");
    searchContainer.style.display = (searchContainer.style.display === "none") ? "block" : "none";
    
    // Focus on the input field when it's shown
    if (searchContainer.style.display === "block") {
        var searchInput = document.getElementById("search-input");
        searchInput.focus();
    }
});

// Function to search through the table
function searchTable() {
    var input = document.getElementById("search-input");
    var filter = input.value.toLowerCase(); // Get the value and convert to lowercase for case-insensitive search
    var table = document.getElementById("printableTable");
    var rows = table.getElementsByTagName("tr");

    // Loop through all table rows (skip the header row)
    for (var i = 1; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName("td");
        var rowText = "";

        // Concatenate the text of each cell in the row
        for (var j = 1; j < cells.length; j++) { // Start from 1 to skip the checkbox column
            rowText += cells[j].textContent.toLowerCase(); // Make the text lowercase
        }

        // If the row text contains the search filter, show the row, else hide it
        if (rowText.indexOf(filter) > -1) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

// Refresh button functionality
document.getElementById("refresh-button").addEventListener("click", function() {
    location.reload(); // Reload the page to restore the initial state
});
