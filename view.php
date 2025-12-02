<?php include 'dbconnect.php';   

// Initialize section and month variables 
$section = '';  
$monthFilter = ''; // Variable to store the selected month

// Get the current month
$currentMonth = date('m');

// Check if 'vot_num' and 'month' are passed via GET 
if (isset($_GET['vot_num'])) {     
    $section = $_GET['vot_num'];      

    // Define the mapping of sections to table names     
    $sectionToTable = [         
        'ආයතන අංශය' => 'establishment_section',         
        'ගිණුම් අංශය' => 'account_section',         
        'ක්‍රීඩා අංශය' => 'sports_section',         
        'සංවර්ධන අංශය' => 'development_section',         
        'ග්‍රාම සංවර්ධන අංශය' => 'ruraldev_section',         
        'සංස්කෘතික අංශය' => 'cultural_section'     
    ];      

    // Check if the section exists in the mapping     
    if (!array_key_exists($section, $sectionToTable)) {         
        echo "<p>Invalid section selected.</p>";         
        exit;     
    }      

    // Get the table name corresponding to the section     
    $tableName = $sectionToTable[$section];  

    // Check if 'month' is passed via GET for filtering
    if (isset($_GET['month']) && $_GET['month'] != '') {
        $monthFilter = $_GET['month']; 
    } else {
        // Default to the current month if no month is selected
        $monthFilter = $currentMonth;
    }

    // Modify the SQL query to filter by month if a month is selected
    if ($monthFilter) {
        $sql = "SELECT * FROM $tableName WHERE MONTH(date) = $monthFilter";     
    } else {
        $sql = "SELECT * FROM $tableName"; // If no month filter, get all data     
    }
    $result = mysqli_query($conn, $sql);     

    // Debugging: Check if query ran successfully     
    if (!$result) {         
        echo "Error in query: " . mysqli_error($conn);         
        exit;     
    }      

    // Check if data is available     
    if (mysqli_num_rows($result) > 0) {         
        // Store the result for later use in the table display section
        $dataAvailable = true; 
    } else {         
        echo "<p>No data available for this section.</p>";     
    }
} else {     
    echo "<p>No section selected.</p>";     
    exit; 
} 
?> 

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Data for <?php echo $section; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Sinhala&display=swap" rel="stylesheet">
    <style>
        body {
    font-family: 'Noto Serif Sinhala', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f7fa;
    color: #333;
}

header {
    background-color: #5a13a1; /* Keep your theme color */
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

header img {
    width: 50px;
    height: auto;
}

header ul {
    display: flex;
    gap: 20px;
    list-style: none;
    margin: 0;
}

header li a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.2s;
}

header li a:hover {
    color: #ffab91;
}

h1 {
    font-size: 2rem;
    margin: 30px 0;
    color: #333;
    text-align: center;
}

.table-container {
    overflow-x: auto;
    margin: 20px 0;
}

/* Table styling */
table {
    width: 100%; /* Full width */
    border-collapse: collapse;
    margin: 20px auto;
    font-size: 12px;
    font-family: Arial, sans-serif;
    text-align: left;
    border: 1px solid #ddd;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Table header styling */
table th {
    background-color: #f4f4f4;
    color: #333;
    font-weight: bold;
    font-size: 12px;
    padding: 3px 3px;
    text-align: center;
    border: 1px solid #ddd;
}

/* Table row and cell styling */
table td {
    padding: 6px 7px;
    border: 1px solid #ddd;
    text-align: center;
}

/* Specific column styles */

/* Targeting Name column (3rd column) */
table th:nth-child(3),
table td:nth-child(3) {
    width: 30%; /* Set width for Name column */
    text-align: center; /* Align text to the left */
    
}
table td:nth-child(3) {
    width: 30%; /* Set width for Name column */
    text-align: left; /* Align text to the left */
    white-space: nowrap; /* Prevent text wrapping */
}

/* Apply vertical text styling to all headers with the 'category-header' class */
table th.category-header {
    writing-mode: vertical-rl; /* Makes the text vertical */
    transform: rotate(180deg); /* Rotates the text 180 degrees */
    text-align: center; /* Center-align the text */
    padding: 6px 0; /* Adjust padding for vertical alignment */
    border-left: 1px solid #ddd; /* Add a vertical line between columns */
}



/* Targeting Blue, Black, and Red Pen columns (4th, 5th, and 6th columns) */
table th:nth-child(4),
table td:nth-child(4),
table th:nth-child(5),
table td:nth-child(5),
table th:nth-child(6),
table td:nth-child(6) {
    width: 50px; /* Fixed width for all Pen columns */
    text-align: center; /* Center align text */
    white-space: nowrap; /* Prevent text wrapping */
    font-size: 13px;
}
table th:nth-child(4), /* Blue Pen */
table th:nth-child(5), /* Black Pen */
table th:nth-child(6) { /* Red Pen */
    text-align: center; /* Center-align the text */
    padding: 6px 0; /* Adjust padding for vertical alignment */
    border-left: 1px solid #ddd; /* Add a vertical line between columns */
}


/* Alternate row background */
table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:nth-child(odd) {
    background-color: #fff;
}

/* Row hover effect */
table tr:hover {
    background-color: #f1f1f1;
}


/* Responsive adjustments */
@media (max-width: 768px) {
    table {
        width: 100%; /* Use full width on small screens */
    }

    table th, table td {
        font-size: 11px; /* Smaller font size */
        padding: 5px 6px; /* Reduced padding */
    }
}
/* Button container */
.button-container {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
}

/* Button styling */
.custom-button {
    padding: 12px 20px;
    font-size: 16px;
    background-color: #5a13a1; /* Keep your theme color */
    color: white;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.custom-button:hover {
    background-color: #4e0f85;
}

.custom-button:active {
    background-color: #3f0d70;
}


    </style>
</head>
<body>

<header>
    <img src="assest/Ministry of youth and sports.png" alt="logo Icon">
    <ul>
        <li><a href="form.html">Go Back To Form</a></li>
    </ul>
</header>

<main class="container">     
    <h1>Data for <?php echo $section; ?></h1>  

    <!-- Month Filter Form -->
    <form method="GET" action="">
        <input type="hidden" name="vot_num" value="<?php echo $section; ?>">
        <label for="month">Select Month:</label>
        <select name="month" id="month" onchange="this.form.submit()">
            <option value="">All</option>
            <option value="1" <?php if($monthFilter == '1') echo 'selected'; ?>>January</option>
            <option value="2" <?php if($monthFilter == '2') echo 'selected'; ?>>February</option>
            <option value="3" <?php if($monthFilter == '3') echo 'selected'; ?>>March</option>
            <option value="4" <?php if($monthFilter == '4') echo 'selected'; ?>>April</option>
            <option value="5" <?php if($monthFilter == '5') echo 'selected'; ?>>May</option>
            <option value="6" <?php if($monthFilter == '6') echo 'selected'; ?>>June</option>
            <option value="7" <?php if($monthFilter == '7') echo 'selected'; ?>>July</option>
            <option value="8" <?php if($monthFilter == '8') echo 'selected'; ?>>August</option>
            <option value="9" <?php if($monthFilter == '9') echo 'selected'; ?>>September</option>
            <option value="10" <?php if($monthFilter == '10') echo 'selected'; ?>>October</option>
            <option value="11" <?php if($monthFilter == '11') echo 'selected'; ?>>November</option>
            <option value="12" <?php if($monthFilter == '12') echo 'selected'; ?>>December</option>
        </select>
    </form>

    <?php if (isset($dataAvailable) && $dataAvailable): ?>          
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th rowspan='2'>Emp No</th>
                    <th rowspan='2'>Name</th>
                    <th colspan='3'>Pen</th>
                    <th colspan='2'>A4 Paper</th>
                    <th colspan='3'>Files</th>
                    <th colspan='4'>Covers</th>
                    <th colspan='2'>Sticky Packs</th>
                    <th colspan='4'>CR Paper</th>
                    <th rowspan='2'>Tippex</th>
                    <th rowspan='2'>Cellotape</th>
                    <th rowspan='2'>Pins Pack</th>
                    <th rowspan='2'>File Clip</th>
                    <th rowspan='2'>Stapler</th>
                    <th rowspan='2'>Manila Papers</th>
                    <th rowspan='2'>Carbon Paper</th>
                    <th rowspan='2'>Half Sheet</th>
                    <th rowspan='2'>Highlighter</th>
                    <th rowspan='2'>Pencils</th>
                    <th rowspan='2'>Eraser</th>
                    <th rowspan='2'>Notebook</th>
                    <th rowspan='2'>Rule Paper</th>
                    <th rowspan='2'>Legal Paper</th>
                    <th rowspan='2'>Glue Bottles</th>
                    <th rowspan='2'>Ink Bottle</th>
                </tr>
                <tr>
                    <th class='category-header'>Blue</th>
                    <th class='category-header'>Black</th>
                    <th class='category-header'>Red</th>
                    <th class='category-header'>White</th>
                    <th class='category-header'>Orange</th>
                    <th class='category-header'>File 1</th>
                    <th class='category-header'>File 2</th>
                    <th class='category-header'>File Tags</th>
                    <th class='category-header'>Cover 6x3</th>
                    <th class='category-header'>Cover 9x4</th>
                    <th class='category-header'>Cover 10x7</th>
                    <th class='category-header'>Cover 10x15</th>
                    <th class='category-header'>Sticky Pack</th>
                    <th class='category-header'>Sheets</th>
                    <th class='category-header'>Page 40</th>
                    <th class='category-header'>Page 80</th>
                    <th class='category-header'>Page 120</th>
                    <th class='category-header'>Page 160</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the data and display the rows
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    foreach ($row as $column => $value) {
                        if ($column != 'id' && $column != 'date') {
                            echo "<td>" . htmlspecialchars($value) . "</td>";
                        }
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No data found for this section.</p>
    <?php endif; ?>
</main>

</body>
</html>
