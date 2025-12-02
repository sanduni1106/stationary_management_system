<!DOCTYPE html>
<html lang="si">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>දකුණු පළාත් ක්‍රීඩා, යෞවන කටයුතු, ග්‍රාම සංවර්ධන අමාත්‍යංශය Department of Sports, Southern Province Dakshinapaya.</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Sinhala&display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

  <style>
    <style> 
    /* Header styles */
    .header {
        position: sticky;
        top: 20px;
        z-index: 1000;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100px;
        padding: 0 30px;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.01);
        margin: 0 auto 20px auto;
    }
    
    .header-title {
        height: 100px;
        margin-right: 300px;
        display: flex;
        align-items: center;
        transition: transform 0.2s ease;
    }
    
    .header-title:hover {
        transform: scale(1.05);
    }
    
    .header-nav {
        display: flex;
        align-items: center;
    }
    
    .header-nav ul {
        display: flex;
        align-items: center;
        gap: 30px;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .header-nav li {
        font-size: 16px;
    }
    
    .header-nav li a {
        text-decoration: none;
        color: #333;
        transition: color 0.2s;
    }
    
    .header-nav li a:hover {
        color: rgb(15, 15, 15);
        transform: scale(1.05);
    }
    
    /* Button styles */
    .button-icon {
        width: 20px;
        height: 20px;
        vertical-align: middle;
        margin-left: 5px;
    }

    button {
        padding: 10px 15px;
        background: linear-gradient(135deg, rgb(108, 78, 134), rgb(187, 154, 248));
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .button:hover {
        background-color: rgb(72, 33, 136);
    }

    .custom-button {
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 8px 15px;
        font-size: 16px;
        font-weight: bold;
        color: rgb(10, 10, 10);
        background: transparent;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .custom-button:hover {
        transform: scale(1.1);
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2);
    }

    .custom-button:active {
        transform: scale(0.95);
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

     /* Table Styles */
.table-container {
    overflow-x: auto;
    margin: 20px 0;
}

table {
    width: 90%;
    border-collapse: collapse;
    font-size: 12px;
    text-align: left;
    border: 1px solid #ddd;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Table Header */
table th {
    background-color: #f4f4f4;
    color: #333;
    font-weight: bold;
    font-size: 13px;
    padding: 5px;
    text-align: center;
    border: 1px solid #ddd;
    white-space: nowrap;
    writing-mode: vertical-rl; /* Makes the text vertical */
    transform: rotate(180deg);
}

/* Table Cells */
table td {
    padding: 6px 7px;
    border: 1px solid #ddd;
    text-align: center;
}

table th:nth-child(3),
table td:nth-child(3) {
    width: 5%; /* Set width for Name column */
    text-align: center; /* Align text to the left */
    
}
table td:nth-child(3) {
    width: 5%; /* Set width for Name column */
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
table th:nth-child(4){
    width: 30px; /* Fixed width for all Pen columns */
    text-align: center; /* Center align text */
    white-space: nowrap; /* Prevent text wrapping */
    font-size: 13px;
}
table th:nth-child(4),{ /* Red Pen */
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



    /* Input and submit button styles */
    #section {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 2px solid rgb(12, 12, 11);
        border-radius: 8px;
        font-size: 16px;
        color: #333;
        background-color: #fff;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    #section:focus {
        border-color: rgb(15, 13, 13);
        box-shadow: 0px 0px 5px rgba(255, 105, 0, 0.5);
    }

    #section-form input[type="submit"] {
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        color: #fff;
        background-color: rgb(17, 16, 18);
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    #section-form input[type="submit"]:hover {
        background-color: rgb(44, 36, 34);
    }
    table.summary-table {
    width: 30%; /* Reduced table width */
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    position: absolute; /* Use absolute positioning */
    top: 750px;  /* Adjust distance from the top */
    right: 800px; /* Adjust distance from the right */
}

/* Table Header Styling */
table.summary-table th {
    padding: 4px 5px; /* Smaller padding for headers */
    text-align: left;
    border-bottom: 2px solid #ddd;
    color: #333;
    font-weight: bold;
    font-size: 12px; /* Reduced font size */
}

/* Table Body Styling */
table.summary-table td {
    padding: 4px 5px; /* Smaller padding for cells */
    border-bottom: 1px solid #ddd;
    color: #555;
    font-size: 12px; /* Reduced font size */
}

/* Hover Effect for Rows */
table.summary-table tbody tr:hover {
    background-color: #f1f1f1;
}

/* Table Border */
table.summary-table, table.summary-table th, table.summary-table td {
    border: 1px solid #ccc;
}


  </style>
</head>
<body>
<header class="header">
    <nav class="header-nav">
        <img src="assest/Ministry of youth and sports.png" alt="logo Icon" class="header-title" />
        <ul>
            <li><button type="button" class="custom-button"><a href="home.html"><img src="assest/home.png" alt="home Icon" class="button-icon" /></a></button></li>
            <li>
            
    <form action="approve_all.php" method="POST">
        <input type="hidden" name="approveAll" value="1"> <!-- Send approval flag -->
        <input type="hidden" name="branch" value="<?php echo $_GET['branch']; ?>"> <!-- Send selected branch -->
        <button type="submit" id="approveAllButton">Approve All</button>
    </form>


            </li>
            <li>
            
                <button id="update-btn" class="action-button" title="Update selected entries"> 
                    Update
                </button>
        
            </li>

           <li><button id="delete-btn" type="button" class="custom-button"> Delete</button></li>
           <li>
                <button type="button" class="custom-button" onclick="printTable();">
                    <img src="assest/printing.png" alt="print Icon" class="button-icon" />
                </button>
            </li>
            <li><button type="button" id="search-icon">&#128269;</button></li>
                 <button type="button" id="refresh-button"><img src="assest/refresh_btn.png" alt="Refresh Icon" class="button-icon" /></button>
            <li><button type="button" class="custom-button"><a href="logout.php">Logout</a></button></li>
        </ul>
    </nav>
</header>
<?php
include('dbconnect.php');

// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');

// Check if 'branch' parameter is set in URL
if (isset($_GET['branch'])) {
    $branch = $_GET['branch'];

    // Start HTML output
    if ($branch == 'all') {
        echo "<h2>All Branches Data</h2>";
        
        // Establishment Table
        echo "<h3>Establishment Section</h3>";
        $sql = "SELECT * FROM establishment_section WHERE MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'";
        displayTable($sql, 'establishment');

        // Account Table
        echo "<h3>Account Section</h3>";
        $sql = "SELECT * FROM account_section WHERE MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'";
        displayTable($sql, 'account');

        // Sports Table
        echo "<h3>Sports Section</h3>";
        $sql = "SELECT * FROM sports_section WHERE MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'";
        displayTable($sql, 'sports');

        // Development Table
        echo "<h3>Development Section</h3>";
        $sql = "SELECT * FROM development_section WHERE MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'";
        displayTable($sql, 'development');

        // Rural Development Table
        echo "<h3>Rural Development Section</h3>";
        $sql = "SELECT * FROM ruraldev_section WHERE MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'";
        displayTable($sql, 'ruraldev');

        // Cultural Art Table
        echo "<h3>Cultural Art Section</h3>";
        $sql = "SELECT * FROM cultural_section WHERE MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'";
        displayTable($sql, 'culturalart');

    } else {
        // For a specific branch
        echo "<h2>Data for $branch Section</h2>";

        // Query for the specific branch
        switch ($branch) {
            case 'establishment':
                $sql = "SELECT * FROM establishment_section WHERE MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'"; 
                break;
            case 'account':
                $sql = "SELECT * FROM account_section WHERE MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'"; 
                break;
            case 'sports':
                $sql = "SELECT * FROM sports_section WHERE MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'"; 
                break;
            case 'development':
                $sql = "SELECT * FROM development_section WHERE MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'"; 
                break;
            case 'ruraldev':
                $sql = "SELECT * FROM ruraldev_section WHERE MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'"; 
                break;
            case 'culturalart':
                $sql = "SELECT * FROM cultural_section WHERE MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'"; 
                break;
            default:
                echo "<p>Invalid branch.</p>";
                exit;
        }

        // Display the table for the specific branch
        displayTable($sql, $branch);
    }
}

/**
 * Function to display table data
 */
function displayTable($sql, $branch) {
    global $conn;

    // Execute the query
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Initialize totals array
        $totals = [
            'bluePen' => 0, 'blackPen' => 0, 'redPen' => 0, 'a4paper' => 0, 'a4orange' => 0, 'file1' => 0, 'file2' => 0, 'fileTags' => 0,
            'cover6x3' => 0, 'cover9x4' => 0, 'cover10x7' => 0, 'cover10x15' => 0, 'stickyPack' => 0, 'stickyPackSheets' => 0, 'crPaper40' => 0,
            'crPaper80' => 0, 'crPaper120' => 0, 'crPaper160' => 0, 'tippex' => 0, 'cellotape' => 0, 'pinsPack' => 0, 'fileClip' => 0, 'stapler' => 0,
            'manilaPapers' => 0, 'carbonPaper' => 0, 'halfSheet' => 0, 'highlighter' => 0, 'pencils' => 0, 'eraser' => 0, 'notebook' => 0,
            'rulePaper' => 0, 'legalPaper' => 0, 'glueBottles' => 0, 'inkBottle' => 0
        ];

        echo "<form action='update_form.php' method='POST'>"; 

        // Table headers
        echo "<table border='1' id='printableTable'><thead><tr>";
        echo "<th>Select</th><th>ID</th>"; // Select and ID columns
        $fields = $result->fetch_fields();
        $columns = [];

        // Generate table headers dynamically from the database fields
        foreach ($fields as $field) {
            if ($field->name != 'id') { // Exclude the 'id' column
                echo "<th>" . ucfirst($field->name) . "</th>"; // Capitalize field name
                $columns[] = $field->name; // Store column names for totals calculation
            }
        }
        echo "</tr></thead><tbody>";

        // Table rows
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><input type='checkbox' class='row-checkbox' value='" . json_encode($row) . "'></td>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            
            
            foreach ($columns as $column) {
                if (isset($row[$column])) {
                    echo "<td>" . htmlspecialchars($row[$column]) . "</td>";
                    if (is_numeric($row[$column])) {
                        $totals[$column] += (int)$row[$column]; // Calculate total
                    }
                }
            }
            echo "</tr>";
        }

        // Output total row
        echo "<tr class='total-row'>";
        echo "<td colspan='5'><strong>Total</strong></td>"; // Total label
        foreach ($columns as $column) {
            if ($column != 'date' && $column != 'employeenum' && $column != 'name') {
                if (isset($totals[$column])) {
                    echo "<td><strong>" . number_format($totals[$column]) . "</strong></td>";
                }
            }
        }
        echo "</tr>";

        echo "</tbody></table>";
        echo "</form>";
    } else {
        echo "<p>No data found for this branch for the current month.</p>";
    }
}
?>



  <script>


document.getElementById("update-btn").addEventListener("click", function () {
    let selectedRows = [];
    document.querySelectorAll(".row-checkbox:checked").forEach((checkbox) => {
        selectedRows.push(JSON.parse(checkbox.value)); // Convert stored JSON back to object
    });

    if (selectedRows.length === 0) {
        alert("Please select at least one row to update.");
        return;
    }

    // Convert data to JSON and send via form
    let form = document.createElement("form");
    form.method = "POST";
    form.action = "update.php"; // The update script
    let input = document.createElement("input");
    input.type = "hidden";
    input.name = "selectedRows";
    input.value = JSON.stringify(selectedRows);
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
});
</script>
                  


<script src="js/delete.js" defer></script>

<script src="js/print.js" defer></script>
<script src="js/approve.js" defer></script>


</body>
</html>
