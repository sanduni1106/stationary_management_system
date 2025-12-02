document.getElementById('search-icon').addEventListener('click', function() {
    const searchContainer = document.getElementById('search-container');
    const searchButton = document.getElementById('search-icon');

    if (searchContainer.style.display === 'none' || searchContainer.style.display === '') {
        searchContainer.style.display = 'block'; // Show the search container
        searchButton.style.display = 'none';     // Hide the search button
    } else {
        searchContainer.style.display = 'none';  // Hide the search container
        searchButton.style.display = 'inline-block'; // Show the search button
    }
});

// Hide the search container and show the search button when the "Refresh" button is clicked
document.getElementById('refresh-button').addEventListener('click', function() {
    const searchContainer = document.getElementById('search-container');
    const searchButton = document.getElementById('search-icon');

    searchContainer.style.display = 'none';  // Hide the search container
    searchButton.style.display = 'inline-block'; // Show the search button
});